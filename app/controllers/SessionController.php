<?php
require '../app/services/Authenticate.php';

class SessionController extends ControllerBase {
    public function loginAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

        $email = $this->request->getPost("email");
        $password = $this->request->getPost("password");

        $user = Authenticate::authentication($email, $password);

        if(!$user) {
            $this->flash->error("User or password invalid");
            return $this->toIndex();
        }

        $this->session->set("userId", $user->userID);
        return $this->redirectUser($user);
    }

    public function logoutAction() {
        $this->session->remove("userId");

        return $this->dispatcher->forward(array(
            "controller" => "index",
            "action" => "index"
        ));

    }

    private function redirectUser($user) {
        if ($user->Type == "S") {
            $this->response->redirect("student");
        }

        if ($user->Type == "A") {
            $this->response->redirect("admin");
        }
    }
}
?>