<?php
use Phalcon\Mvc\Model\Criteria, Phalcon\Paginator\Adapter\Model as Paginator;

require '../app/services/Authenticate.php';

class UsersController extends ControllerBase {
    public function indexAction() {}

    public function newAction() {
        $this->setTokenValues();
        $types = array("T" => "Teacher",
            "P" => "Student", "S" => "School Admin");

        $cohorts = Cohort::find("schoolId = " . $this->view->user->schoolId);

        $this->view->cohorts = $cohorts;
        $this->view->types = $types;
    }

    public function editAction() {
        $this->setTokenValues();
        $this->view->pick("users/edit");
        $this->view->t = Translation::get("en", "user");
    }

    public function createAction() {
        if (!$this->isValidPost()) { return $this->toIndex(); }
        $t = Translation::get("en", "user");
        $admin = $this->getUserBySession();
        $password = $this->request->getPost("password");
        $confirmPassword = $this->request->getPost("confirm-password");
        $password = $this->security->hash($password);

        if(!Authenticate::checkPassword($confirmPassword, $password)) {
            $this->flash->error($t->_("You need to confirm the password"));
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

        $this->flash->success($t->_("user was created successfully"));
        return $this->toIndex();
    }

    public function updateAction() {
        if (!$this->isValidPost()) { return $this->toIndex(); }
        $t = Translation::get("en", "user");

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

        $this->flash->success($t->_("user was updated successfully"));
        return $this->toIndex();
    }

    public function removeAction($userId) {
        $admin = $this->getUserBySession();
        if (!$admin->isSchool()) { $this->toIndex(); }
        $t = Translation::get("en", "user");

        $user = User::findFirstById($userId);
        if($user->delete()) {
            $this->flash->success($t->_("User was deleted"));
        } else {
            $this->flash->error($t->_("Was not possible remove the user."));
        }

        return $this->dispatcher->forward(
            array("controller" => "school", "action" => "listUsers")
        );
    }

    public function changePasswordAction() {
        $this->setTokenValues();
        $this->view->t = Translation::get("en", "user");
        $this->view->pick("users/changePassword");
    }

    public function updatePasswordAction() {
        if (!$this->isValidPost()) { return $this->toIndex(); }
        $t = Translation::get("en", "user");
        $user = $this->view->user;
        $oldPassword = $this->request->getPost("old-password");
        $newPassword = $this->request->getPost("new-password");
        $confirmPassword = $this->request->getPost("confirm-new-password");

        $newPassword = $this->security->hash($newPassword);

        if(!Authenticate::checkPassword($oldPassword, $user->password)) {
            $this->flash->error($t->_("invalid password"));
            return $this->toIndex();
        }

        if (Authenticate::checkPassword($confirmPassword, $newPassword)) {
            $user->password = $newPassword;
        } else {
            $this->flash->error($t->_("confirm your password"));
            return $this->toIndex();
        }

        if(!$user->save()) {
            $this->flash->error($t->_("was not possible to change your password"));
        }

        $this->flash->success($t->_("password was updated successfully"));
        return $this->toIndex();
    }

    protected function toIndex() {
        return $this->dispatcher->forward(array(
            "action" => "index"
        ));
    }

    private function uploadPhoto($file, $userId) {
        $t = Translation::get("en", "user");
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
            $this->flash->success($t->_("The photo was uploaded."));
        } else {
            $this->flash->error($t->_("The photo was not uploaded."));
            foreach ($photo->getMessages() as $message) {
                $this->flash->error($message);
            }
        }
    }
}