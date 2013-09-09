<?php
class SessionController extends ControllerBase {
    public function loginAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

        $email = $this->request->getPost("email");
        $password = $this->request->getPost("password");

        $conditions = "email = ?1 AND password = ?2";
        $parameters = array(1 => $email, 2 => $password);

        $user = User::findFirst(array($conditions,"bind" => $parameters));

        if(!$user) {
            $this->flash->error("User or password invalid");
            return $this->toIndex();
        }

        echo "Welcome $user->FirstName";
    }

    private function toIndex() {
        return $this->dispatcher->forward(array(
            "controller" => "index",
            "action" => "index"
        ));
    }
}
?>