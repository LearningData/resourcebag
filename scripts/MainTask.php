<?php
use Phalcon\Logger\Adapter\File as FileAdapter;

class mainTask extends \Phalcon\CLI\Task {
    public function mainAction() {
        echo "Synchronizing users\n";
        $config = include APPLICATION_PATH . '/../app/config/config.php';

        $ds = LDAP::bind($config->ldap->server);
        $conn = LDAP::connect($ds, $config->ldap->userDomain,
            $config->ldap->password);

        $dcs = "dc=" . $config->ldap->dc1 . ",dc=" . $config->ldap->dc2;
        $ldap = new LDAPService($ds);

        foreach(School::find() as $school) {
            if($school->clientId) {
                $dn = "ou=$school->clientId,dc=" . $config->ldap->dc1 .
                       ",dc=" . $config->ldap->dc2;

                $ldapSchool = $ldap->search($dn, "cn=users");

                if($ldapSchool["count"] > 0) {
                    $users = $ldapSchool[0]["member"];
                    for($i=0; $i < $users["count"]; $i++) {
                        if($users[$i]) {
                            $userId = $this->getUserId($users[$i]);
                            $type = User::getTypeStudent();

                            $info = $ldap->search($dcs,
                                "(&(ou=Student)(uid=$userId))");

                            if($info["count"] == 0) {
                                $type = User::getTypeTeacher();
                                $info = $ldap->search($dcs,
                                    "(&(ou=Teacher)(uid=$userId))");
                            }

                            $this->saveUsers($info, $type, $school->id,
                                $config->ldap->pathLog);
                        }
                    }
                }
            }
        }

        LDAP::disconnect($ds);
    }

    private function getUserId($value) {
        $splitedValue = split(",", $value);
        $splitedValue = split("=", $splitedValue[0]);

        return $splitedValue[1];
    }

    private function saveUsers($info, $type, $schoolId, $pathLog) {
        $logger = new FileAdapter($pathLog);
        $count = 0;

        for ($i=0; $i < $info["count"]; $i++) {
            $user = $this->populeUser($info[$i], $type);
            $user->schoolId = $schoolId;

            if($user->save()){
                $count++;
                echo "Saving: " . $user->username . "\n";
            } else {
                $errors = "\n";

                foreach ($user->getMessages() as $m) {
                    $errors .= "$m\n";
                }

                $logger->error("Error to synchronize: " .
                    $user->username . $errors);
            }
        }

        echo "Finish: " . $count . "\n";
    }

    private function populeUser($info, $type) {
        $username = $this->getElement("uid", $info);
        $email = $this->getElement("mail", $info);


        if($email != "") {
            $user = User::findFirst("username = '" . $username .
                "' or email = '" . $email . "'");
        } else {
            $user = User::findFirst("username = '" . $username . "'");
        }

        if(!$user) { $user = new User(); }


        if(strstr($email, '@')) {
            $user->email = $email;
        }

        $user->schoolId = 1;

        $binary = $this->getElement("userpassword", $info);
        $binary = substr($binary, 4);
        $user->password = bin2hex((base64_decode($binary)));

        $user->lastName = $this->getElement("sn", $info);
        $user->username = $this->getElement("uid", $info);
        $user->name = $this->getElement("givenname", $info);
        $user->type = $type;

        return $user;
    }

    private function getElement($key, $info) {
        if(array_key_exists($key, $info)) {
            return $info[$key][0];
        }

        return "";
    }
}