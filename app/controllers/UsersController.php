<?php
use Phalcon\Mvc\Model\Criteria, Phalcon\Paginator\Adapter\Model as Paginator;

class UsersController extends ControllerBase {
    public function editAction($id) {
        if (!$this->request->isPost()) {
            $user = User::findFirstById($id);
            if (!$user) {
                $this->flash->error("user was not found");
                return $this->toIndex();
            }

            $this->view->id = $user->id;

            $this->tag->setDefault("userID", $user->id);
            $this->tag->setDefault("FirstName", $user->name);
            $this->tag->setDefault("LastName", $user->lastName);
            $this->tag->setDefault("email", $user->email);
        }
    }

    public function createAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

        $user = $this->populeUsers();

        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "new"
            ));
        }

        $this->flash->success("user was created successfully");
        return $this->toIndex();
    }

    public function updateAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

        $userID = $this->request->getPost("userID");

        $user = User::findFirstById($userID);

        if (!$user) {
            $this->flash->error("user does not exist " . $userID);
            return $this->toIndex();
        }

        $user->name = $this->request->getPost("FirstName");
        $user->lastName = $this->request->getPost("LastName");
        $user->email = $this->request->getPost("email", "email");

        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "edit",
                "params" => array($user->id)
            ));
        }

        $this->flash->success("user was updated successfully");
        return $this->toIndex();
    }

    public function updatePasswordAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

        $userID = $this->request->getPost("user-id");
        $user = User::findFirstById($userID);

        if (!$user) {
            $this->flash->error("user does not exist " . $userID);
            return $this->toIndex();
        }

        $oldPassword = $this->request->getPost("old-password");
        $newPassword = $this->request->getPost("new-password");
        $confirmPassword = $this->request->getPost("confirm-new-password");

        if($oldPassword != $user->password) {
            $this->flash->error("invalid password");
            return $this->toIndex();
        }

        if ($newPassword == $confirmPassword) {
            $user->password = $newPassword;
        } else {
            $this->flash->error("confirm your password");
            return $this->toIndex();
        }

        if(!$user->save()) {
            $this->flash->error("was not possible to change your password");
        }

        $this->flash->success("password was updated successfully");
        return $this->toIndex();
    }

    public function signUpAction() {
        $this->view->schools = School::find();
    }

    private function toIndex() {
        return $this->dispatcher->forward(array(
            "action" => "index"
        ));
    }

    private function populeUsers() {
        $user = new User();
        $user->id = $this->request->getPost("userID");
        $user->schoolId = $this->request->getPost("schoolID");
        $user->year = $this->request->getPost("year");
        $user->name = $this->request->getPost("FirstName");
        $user->lastName = $this->request->getPost("LastName");
        $user->type = $this->request->getPost("Type");
        $user->email = $this->request->getPost("email", "email");
        $user->password = $this->request->getPost("password");

        return $user;
    }
}
