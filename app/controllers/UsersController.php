<?php
use Phalcon\Mvc\Model\Criteria, Phalcon\Paginator\Adapter\Model as Paginator;

class UsersController extends ControllerBase {
    public function indexAction() {}

    public function newAction() {
        $types = array("T" => "Teacher",
            "P" => "Student", "S" => "School Admin");

        $cohorts = Cohort::find("schoolId = " . $this->view->user->schoolId);

        $this->view->cohorts = $cohorts;
        $this->view->types = $types;
    }

    public function editAction() {}

    public function createAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }
        $admin = $this->getUserBySession();
        $password = $this->request->getPost("password");

        if($password != $this->request->getPost("confirm-password")) {
            $this->flash->error("You need confirm the password");
            return $this->dispatcher->forward(array("action" => "new"));
        }

        $user = new User();
        $user->name = $this->request->getPost("name");
        $user->lastName = $this->request->getPost("last-name");
        $user->schoolId = $admin->schoolId;
        $user->password = $password;
        $user->type = $this->request->getPost("type");
        $user->groupId = $this->request->getPost("group-id");
        $user->email = $this->request->getPost("email");

        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array("action" => "new"));
        }

        foreach ($this->request->getUploadedFiles() as $file){
            $this->uploadPhoto($file, $user->id);
        }

        $this->flash->success("user was updated successfully");
        return $this->toIndex();
    }

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

        foreach ($this->request->getUploadedFiles() as $file){
            $this->uploadPhoto($file, $user->id);
        }

        $this->flash->success("user was updated successfully");
        return $this->toIndex();
    }

    public function removeAction($userId) {
        $admin = $this->getUserBySession();
        if (!$admin->isSchool()) { $this->toIndex(); }

        $user = User::findFirstById($userId);
        if($user->delete()) {
            $this->flash->success("User was deleted");
        } else {
            $this->flash->error("Was not possible remove the user.");
        }

        return $this->dispatcher->forward(
            array("controller" => "school", "action" => "listUsers")
        );
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

    protected function toIndex() {
        return $this->dispatcher->forward(array(
            "action" => "index"
        ));
    }

    private function uploadPhoto($file, $userId) {
        $photo = UserPhoto::findFirst("userId = " . $userId);

        if (!$photo) {
            $photo = new UserPhoto();
            $photo->userId = $userId;
        }

        $photo->originalName = $file->getName();
        $photo->name = $file->getName();
        $photo->size = $file->getSize();
        $photo->type = $file->getType();
        $photo->file = file_get_contents($file->getTempName());

        if ($photo->save()) {
            $this->flash->success("The file was uploaded.");
        } else {
            $this->flash->error("The file was not uploaded.");
            foreach ($photo->getMessages() as $message) {
                $this->flash->error($message);
            }
        }
    }
}