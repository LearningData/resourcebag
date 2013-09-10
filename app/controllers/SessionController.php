<?php
require '../app/services/Authenticate.php';

class SessionController extends ControllerBase {
    public function loginAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }
        echo "HERE 1";
        $email = $this->request->getPost("email");
        $password = $this->request->getPost("password");
        echo "HERE 2";
        $user = Authenticate::authentication($email, $password);

        if(!$user) {
            $this->flash->error("User or password invalid");
            return $this->toIndex();
        }

        echo "HERE 3";

        $this->session->set("userId", $user->id);
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
        if ($user->type == "S") {
            return $this->response->redirect("student");
        }

        if ($user->type == "A") {
            return $this->response->redirect("admin");
        }
    }
}
?>