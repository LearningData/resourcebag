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

        foreach(School::find() as $school) {
            /*
            * TODO
            * CHANGE THE QUERY TO USE THE REAL ATTRIBUTE TO IDENIFY THE SCHOOL
            * $query = "(&(ou=Student)(schoolid=$school->clientId))";
            */

            $info = LDAP::search($ds, $dcs, "(&(ou=Student)(givenname=*))");
            $this->saveUsers($info, User::getTypeStudent(),
                $config->ldap->pathLog);

            $info = LDAP::search($ds, $dcs, "(&(ou=Teacher)(givenname=*))");
            $this->saveUsers($info, User::getTypeTeacher(),
                $config->ldap->pathLog);
        }

        LDAP::disconnect($ds);
    }

    private function saveUsers($info, $type, $pathLog) {
        $logger = new FileAdapter($pathLog);
        $count = 0;

        for ($i=0; $i < $info["count"]; $i++) {
            $user = $this->populeUser($info[$i], $type);

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

    private function getConfig() {

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