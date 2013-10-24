<?php
use Phalcon\Mvc\View;

class RegisterController extends Phalcon\Mvc\Controller {
    public function indexAction() {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $this->view->schools = School::find();
    }

    public function createAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        $password = $this->request->getPost("password");
        $confirmPassword = $this->request->getPost("confirm-password");
        $password = $this->security->hash($password);
        $email = $this->request->getPost("email");

        if(!Authenticate::checkPassword($confirmPassword, $password)) {
            $this->flash->error("You need confirm the password");
            return $this->dispatcher->forward(array("action" => "index"));
        }

        if($email != $this->request->getPost("confirm-email")) {
            $this->flash->error("You need confirm the email");
            return $this->dispatcher->forward(array("action" => "index"));
        }

        $user = new User();
        $user->id = $this->request->getPost("userID");
        $user->schoolId = $this->request->getPost("schoolID");
        $user->name = $this->request->getPost("FirstName");
        $user->lastName = $this->request->getPost("LastName");
        $user->type = $this->request->getPost("Type");
        $user->email = $email;
        $user->password = $password;

        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                echo "$message <br>";
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "register",
                "action" => "index"
            ));
        }

        $this->flash->success("user was created successfully");
        return $this->toIndex();
    }

    private function toIndex() {
        return $this->dispatcher->forward(array(
            "controller" => "register",
            "action" => "index"
        ));
    }
}
?>