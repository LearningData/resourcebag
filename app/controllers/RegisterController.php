<?php
use Phalcon\Mvc\View;
require "../app/services/Translation.php";

class RegisterController extends Phalcon\Mvc\Controller {
    public function indexAction() {
        $tokenKey = $this->security->getTokenKey();
        $token = $this->security->getToken();

        $this->view->csrf_params = array("name" => $tokenKey,
            "value" => $token);

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $this->view->schools = School::find();
        $this->view->titles = User::getTitles();

        $this->view->t = Translation::get(Language::get(), "user");
    }

    public function accessCodeAction() {
        $tokenKey = $this->security->getTokenKey();
        $token = $this->security->getToken();

        $this->view->csrf_params = array("name" => $tokenKey,
            "value" => $token);

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        $this->view->t = Translation::get(Language::get(), "user");
    }

    public function createAction() {
        $t = Translation::get(Language::get(), "user");

        if (!$this->request->isPost() || !$this->security->checkToken()) {
            return $this->toIndex();
        }

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        $password = $this->request->getPost("password");
        $confirmPassword = $this->request->getPost("confirm-password");
        $password = md5($password);
        $email = $this->request->getPost("email");

        if(!Authenticate::checkPassword($confirmPassword, $password)) {
            $this->flash->error($t->_("need-confirm-password"));
            return $this->dispatcher->forward(array("action" => "index"));
        }

        if($email != $this->request->getPost("confirm-email")) {
            $this->flash->error($t->_("need-confirm-email"));
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

        if($user->isTeacher()) {
            $user->title = $this->request->getPost("title");
        }

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

        $this->flash->success($t->_("user-created"));
        return $this->toIndex();
    }

    public function accessCodeCheckAction() {
        $t = Translation::get(Language::get(), "user");

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        $accessCode = $this->request->getPost("accessCode");
        $school = School::findFirstByAccessCode($accessCode);

        if ($accessCode != '' && $school) {
            $user = $_SESSION['newUser'];
            $schoolUser = new User();
            $schoolUser->schoolId = $school->id;
            $schoolUser->type = User::getTypeStudent();
            $schoolUser->name = $user['name'];
            $schoolUser->lastName = $user['lastname'];
            $schoolUser->password = "084e0343a0486ff05530df6c705c8bb4";
            $schoolUser->email = $user['email'];

            $schoolUser->save();

            if (isset($user['photo']) && $user['photo'] != '') {
                $userId=$schoolUser->id;
                $photo = UserPhoto::findFirst("userId = " . $userId);

                if (!$photo) {
                    $photo = new UserPhoto();
                    $photo->userId = $userId;
                    $photo->originalName = $user['email'];
                    $photo->name = $user['email'].rand();
                    $photo->size = '';
                    $photo->type = '';
                    $photo->file = file_get_contents($user['photo']);

                    $photo->save();
                }
            }

            if ($user['authprovider'] == "google") {
                Authenticate::authenticationGoogle($schoolUser);
            } elseif ($user['authprovider'] == "microsoft") {
                Authenticate::authenticationMicrosoft($schoolUser);
            }

            return $this->response->redirect("dashboard");
        } else {
            $this->flash->error($t->_("get-access-code"));
            return $this->dispatcher->forward(array(
                "controller" => "register",
                "action" => "accessCode"
            ));
        }
    }

    private function toIndex() {
        return $this->dispatcher->forward(array(
            "controller" => "register",
            "action" => "index"
        ));
    }
}
?>
