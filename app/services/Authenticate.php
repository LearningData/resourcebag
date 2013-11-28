<?php
use Phalcon\Mvc\User\Component;
require "SessionService.php";

class Authenticate extends Component {
    public function authentication($email, $password) {
        if(strstr($email, '@')) {
            $user = User::findFirstByEmail($email);
        } else {
            $user = User::findFirstByUsername($email);
        }

        if($user) {
            if(Authenticate::checkPassword($password, $user->password)) {
                SessionService::createSession($user);
                Authenticate::saveSuccess($user);
                return $user;
            }

            Authenticate::saveLoginFail($user->id);
        }

        return false;
    }

    public function authenticationMicrosoft($user) {
        if($user) {
            SessionService::createSession($user);
            Authenticate::saveSuccess($user);
            return $user;
        }

        Authenticate::saveLoginFail($user->id);
        return false;
    }

    public function checkPassword($password, $hashedPassword) {
        return md5($password) == $hashedPassword;
    }

    public function getUser() {
        if($this->session->has("schoolbag_" . $this->request->getServerAddress())) {
            $session = $this->session->get("schoolbag_" .
                $this->request->getServerAddress());

            if(isset($session["id"])) {
                $user = User::findFirstById($session["id"]);
                if($user) {
                    $this->view->user = $user;
                    return $user;
                }
            }
        }

        return false;
    }

    private function saveLoginFail($userId) {
        $failedLogin = new FailedLogin();
        $failedLogin->userId = $userId;
        $failedLogin->ipAddress = $this->request->getClientAddress();
        $failedLogin->userAgent = $this->request->getUserAgent();
        $date = new DateTime('NOW');
        $failedLogin->date = $date->format('Y-m-d H:i:s');

        if (!$failedLogin->save()) {
            $messages = $failedLogin->getMessages();
            throw new Exception($messages[0]);
        }
    }

    private function saveSuccess($user) {
        $successLogin = new SuccessLogin();
        $successLogin->userId = $user->id;
        $successLogin->ipAddress = $this->request->getClientAddress();
        $successLogin->userAgent = $this->request->getUserAgent();
        $date = new DateTime('NOW');
        $successLogin->loggedAt = $date->format('Y-m-d H:i:s');

        if (!$successLogin->save()) {
                $messages = $successLogin->getMessages();
                throw new Exception($messages[0]);
        }
    }
}
?>