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
        $count = 0;
        for ($i=0; $i < $info["count"]; $i++) {
            if(!strstr($info[$i]["mail"][0], '@')) { continue; }
            // if(User::find("email='" . $info[$i]["mail"][0] . "'")) { continue; }
            $user = new User();
            $user->schoolId = 1;
            $user->password = "guest";
            $user->email = $info[$i]["mail"][0];
            $user->lastName = $info[$i]["sn"][0];

            $name = split(" ", $info[$i]["cn"][0]);
            $user->name = $name[0];
            $user->type = User::getTypeStudent();
            // if(!User::find("email=" . $user->email)) { continue; }
            if($user->save()){
                $count++;
                echo "Sync: " . $user->email . "\n";
            }
        }

        echo "Finish: " . $count . "\n";
    }
}