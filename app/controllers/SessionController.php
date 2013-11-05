<?php
require '../app/services/Authenticate.php';

class SessionController extends Phalcon\Mvc\Controller {
    public function loginAction() {
        if (!$this->request->isPost() || !$this->security->checkToken()) {
            return $this->response->redirect("");
        }

        $email = $this->request->getPost("email");
        $password = $this->request->getPost("password");
        $user = Authenticate::authentication($email, $password);

        if(!$user) {
            $this->flash->error("User or password invalid");
            return $this->response->redirect("");
        }

        return $this->response->redirect("dashboard");
    }

    public function logoutAction() {
        SessionService::destroySession();
        return $this->response->redirect("");
    }
}
?>