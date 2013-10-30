<?php
use Phalcon\Mvc\User\Component;

class Authenticate extends Component {
    public function authentication($email, $password) {
        $user = User::findFirstByEmail($email);

        if($user) {
            if(Authenticate::checkPassword($password, $user->password)) {
                Authenticate::createSession($user);
                Authenticate::saveSuccess($user);
                return $user;
            }

            Authenticate::saveLoginFail($user->id);
        }

        return false;
    }

    public function checkPassword($password, $hashedPassword) {
        return $this->security->checkHash($password, $hashedPassword);
    }

    public function destroySession() {
        $this->session->remove($this->request->getServerAddress());
        $this->session->destroy();
    }

    public function getUser() {
        $session = $this->session->get($this->request->getServerAddress());

        if(isset($session["id"])) {
            $user = User::findFirstById($session["id"]);
            if ($user) {
                $this->view->user = $user;
                return $user;
            }

            return false;
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

    private function createSession($user) {
        $this->session->set($this->request->getServerAddress(),
            array("id" => $user->id, "name" => $user->name));
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