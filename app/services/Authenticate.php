<?php
use Phalcon\Mvc\User\Component;

class Authenticate extends Component {
    public function authentication($email, $password) {
        $user = User::findFirstByEmail($email);

        if($user) {
            if(Authenticate::checkPassword($password, $user->password)) {
                return $user;
            }
        }

        return false;
    }

    public function checkPassword($password, $hashedPassword) {
        return $this->security->checkHash($password, $hashedPassword);
    }
}
?>