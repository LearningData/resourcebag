<?php
use Phalcon\Mvc\Model\Criteria, Phalcon\Paginator\Adapter\Model as Paginator;

class UsersController extends ControllerBase {
    // public function indexAction() {
    //     $numberPage = $this->request->getQuery("page", "int");
    //     $users = User::find();

    //     if (count($users) == 0) {
    //         $this->flash->notice("The search did not find any users");
    //         return $this->toIndex();
    //     }

    //     $paginator = new Paginator(array("data" => $users, "limit"=> 10,"page" => $numberPage));
    //     $this->view->page = $paginator->getPaginate();
    // }

    // public function newAction() {}

    public function editAction($userID) {
        if (!$this->request->isPost()) {
            $user = User::findFirstByuserID($userID);
            if (!$user) {
                $this->flash->error("user was not found");
                return $this->toIndex();
            }

            $this->view->userID = $user->userID;

            $this->tag->setDefault("userID", $user->userID);
            $this->tag->setDefault("schoolID", $user->schoolID);
            $this->tag->setDefault("year", $user->year);
            $this->tag->setDefault("FirstName", $user->FirstName);
            $this->tag->setDefault("LastName", $user->LastName);
            $this->tag->setDefault("Type", $user->Type);
            $this->tag->setDefault("email", $user->email);
            $this->tag->setDefault("password", $user->password);

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

        $user = User::findFirstByuserID($userID);

        if (!$user) {
            $this->flash->error("user does not exist " . $userID);
            return $this->toIndex();
        }

        $user = $this->populeUsers();

        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "edit",
                "params" => array($user->userID)
            ));
        }

        $this->flash->success("user was updated successfully");
        return $this->toIndex();
    }

    // public function deleteAction($userID) {
    //     $user = User::findFirstByuserID($userID);

    //     if (!$user) {
    //         $this->flash->error("user was not found");
    //         return $this->toIndex();
    //     }

    //     if (!$user->delete()) {
    //         foreach ($user->getMessages() as $message){
    //             $this->flash->error($message);
    //         }

    //         return $this->toIndex();
    //     }

    //     $this->flash->success("user was deleted successfully");
    //     return $this->toIndex();
    // }

    public function signUpAction() {
        $this->view->schools = School::find();
    }

    private function toIndex() {
        return $this->dispatcher->forward(array(
            "controller" => "users",
            "action" => "index"
        ));
    }

    private function populeUsers() {
        $user = new User();
        $user->userID = $this->request->getPost("userID");
        $user->schoolID = $this->request->getPost("schoolID");
        $user->year = $this->request->getPost("year");
        $user->FirstName = $this->request->getPost("FirstName");
        $user->LastName = $this->request->getPost("LastName");
        $user->Type = $this->request->getPost("Type");
        $user->email = $this->request->getPost("email", "email");
        $user->password = $this->request->getPost("password");

        return $user;
    }
}
