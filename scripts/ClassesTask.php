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

        foreach(School::find() as $school) {
            if(!$school->clientId) { continue; }

            $dn = "ou=TchEnrol,ou=$school->clientId,dc=" . $config->ldap->dc1 .
                ",dc=" . $config->ldap->dc2;

            $info = $ldap->search($dn, "cn=*");
            $this->syncTeachers($info);

            $dn = "ou=StdEnrol,ou=$school->clientId,dc=" . $config->ldap->dc1 .
                ",dc=" . $config->ldap->dc2;

            $info = $ldap->search($dn, "cn=*");
            $this->syncStudent($info);

        }

        LDAP::disconnect($ds);
    }
    public function syncTeachers($info) {
        for($i=0; $i < $info["count"]; $i++) {
            $cn =  $info[$i]["cn"][0];
            $teacher = User::findFirstByUsername($info[0]["memberuid"][0]);

            if(!$teacher) { continue; }

            $splited = split("-", $cn);
            $stage = substr($splited[1], -3);
            $ref = substr($splited[1], 0, -3);
            $cohort = Cohort::findFirstByStage($stage);

            if(!$cohort) {
                $cohort = new Cohort();
                $cohort->stage = $stage;
                $cohort->schoolId = $teacher->id;
                $cohort->schoolYear = 2014;
                $cohort->courseId = 1;
                $cohort->groupId = 3;

                if(!$cohort->save()) {
                    foreach ($cohort->getMessages() as $m) {
                        echo $m . "\n";
                    }
                }
            }
            $subject = Subject::findFirstByName($splited[0]);

            if(!$subject) {
                $subject = new Subject();
                $subject->name = $splited[0];

                $subject->save();
            }

            $classList = ClassList::findFirst("cohortId = " .
                $cohort->id . "and subjectId = " . $subject->id .
                " and schoolId = 75");

            if(!$classList) {
                $classList = new ClassList();
                $classList->teacherId = $teacher->id;
                $classList->subjectId = $subject->id;
                $classList->schoolId = 75;
                $classList->extraRef = $subject->name;
                $classList->cohortId = $cohort->id;

                if(!$classList->save()) {
                    foreach ($classList->getMessages() as $m) {
                        echo $m . "\n";
                    }
                }
            }
        }
    }


    public function syncStudent($info) {
        for($i=0; $i < $info["count"]; $i++) {
            $names = $info[$i]["memberuid"];
            foreach($names as $username) {
                $user = User::findFirstByUsername($username);

                if(!$user) { continue; }

                if($user) {
                    $cn =  $info[$i]["cn"][0];
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

                    if($classList) {
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
    }
}