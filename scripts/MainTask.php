<?php
class mainTask extends \Phalcon\CLI\Task {
    public function mainAction() {
        echo "Synchronizing students\n";
        $config = include APPLICATION_PATH . '/../app/config/config.php';

        $ds = LDAP::bind($config->ldap->server);
        $conn = LDAP::connect($ds, $config->ldap->userDomain,
            $config->ldap->password);

        $dcs = "dc=" . $config->ldap->dc1 . ",dc=" . $config->ldap->dc2;

        $info = LDAP::search($ds, $dcs, "ou=Student");
        $this->saveUsers($info, User::getTypeStudent());

        $info = LDAP::search($ds, $dcs, "ou=Teacher");
        $this->saveUsers($info, User::getTypeTeacher());

        LDAP::disconnect($ds);
    }

    private function saveUsers($info, $type) {
        $count = 0;

        for ($i=0; $i < $info["count"]; $i++) {
            $user = $this->populeUser($info[$i], $type);

            if($user->save()){
                $count++;
                echo "Saving: " . $user->username . "\n";
            } else {
                foreach ($user->getMessages() as $m) {
                    echo "Error: $m\n";
                }
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
        $user->password = "guest";
        $user->lastName = $this->getElement("sn", $info);
        $user->username = $this->getElement("uid", $info);
        $name = split(" ",  $this->getElement("cn", $info));
        $user->name = $name[0];
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