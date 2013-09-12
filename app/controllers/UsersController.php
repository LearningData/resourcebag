<?php
use Phalcon\Mvc\Model\Criteria, Phalcon\Paginator\Adapter\Model as Paginator;

class UsersController extends ControllerBase {
    public function beforeExecuteRoute($dispatcher){
        $user = $this->getUserBySession();

        if (!$user) {
            $this->response->redirect("index");
            return false;
        }

        $this->view->user = $user;
        $cname = $dispatcher->getControllerName();

        if ($cname != $user->getController()) {
            $this->response->redirect($user->getController());
            return false;
        }
    }

    public function indexAction() {}

    public function editAction() {}

    public function updateAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

        $userID = $this->request->getPost("userID");

        $user = User::findFirstById($userID);

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

    public function changePasswordAction() {}

    public function updatePasswordAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }
        $user = $this->view->user;
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

    protected function getUserBySession() {
        $userId = $this->session->get("userId");
        $user = User::findFirstById($userId);
        $this->view->user = $user;

        return $user;
    }
}