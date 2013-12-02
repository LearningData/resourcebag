<?php
use Phalcon\Logger\Adapter\File as FileAdapter;

class classesTask extends \Phalcon\CLI\Task {
    public function syncAction() {
        echo "Synchronizing users\n";
        $config = include APPLICATION_PATH . '/../app/config/config.php';

        $ds = LDAP::bind($config->ldap->server);
        $conn = LDAP::connect($ds, $config->ldap->userDomain,
            $config->ldap->password);

        $dcs = "dc=" . $config->ldap->dc1 . ",dc=" . $config->ldap->dc2;
        $ldap = new LDAPService($ds);

        $user = User::findFirstById(2172);

        foreach(School::findById($user->schoolId) as $school) {
            if(!$school->clientId) { continue; }

            $dn = "ou=StdEnrol,ou=$school->clientId,dc=" . $config->ldap->dc1 .
                ",dc=" . $config->ldap->dc2;

            $info = $ldap->search($dn, "cn=*");
            $this->syncStudent($user, $info);
        }

        LDAP::disconnect($ds);
    }

    public function syncStudent($user, $info) {
        for($i=0; $i < $info["count"]; $i++) {
            if(in_array($user->username, $info[$i]["memberuid"])) {
                $cn =  $info[$i]["cn"][0];
                $teacher = $info[0]["memberuid"][0];

                $splited = split("-", $cn);

                $stage = substr($splited[1], -3);
                $ref = substr($splited[1], 0, -3);

                $cohort = Cohort::findFirstByStage($stage);
                $subject = Subject::findFirstByName($splited[0]);

                if(!$subject) {
                    $subject = new Subject();
                    $subject->name = $splited[0];

                    $subject->save();
                }

                $classList = ClassList::findFirst("cohortId = " .
                    $cohort->id . "and subjectId = " . $subject->id);

                if(!$classList) {
                    $classList = new ClassList();
                    $classList->teacherId = 1000;
                    $classList->subjectId = $subject->id;
                    $classList->schoolId = 2;
                    $classList->extraRef = $subject->name;
                    $classList->cohortId = $cohort->id;

                    $classList->save();
                }

                $response = StudentService::joinClass($user, $classList);

                echo "COHORT: " .  $stage . "\n";
                echo "SUBJECT: " .  $splited[0] . "\n";
                echo "REF: " .  $ref . "\n";
                echo "CN: " .  $cn . "\n";
                echo "RES: " . $response . "\n";
                echo "==================================================\n";
            }
        }
    }
}