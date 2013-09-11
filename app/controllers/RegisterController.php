<?php
class RegisterController extends ControllerBase {
    public function indexAction() {
        $this->view->schools = School::find();
    }

    public function createAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

        $user = $this->populeUsers();

        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
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
?>