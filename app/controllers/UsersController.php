<?php
use Phalcon\Mvc\Model\Criteria, Phalcon\Paginator\Adapter\Model as Paginator;

class UsersController extends ControllerBase {
    public function indexAction() {
        $userId = $this->session->get("userId");
        if(!$userId) {
            return $this->response->redirect("index");
        }

        $user = User::findFirst($userId);
        $this->view->user = $user;
    }

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
                "action" => "edit",
                "params" => array($user->id)
            ));
        }

        $this->flash->success("user was updated successfully");
        return $this->toIndex();
    }

    public function changePasswordAction($userId) {
        $this->view->userId = $userId;
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

    private function toIndex() {
        return $this->dispatcher->forward(array(
            "action" => "index"
        ));
    }
}