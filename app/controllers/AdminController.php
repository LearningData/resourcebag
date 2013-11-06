<?php
use Phalcon\Mvc\Model\Criteria, Phalcon\Paginator\Adapter\Model as Paginator;

class AdminController extends UsersController {
    public function beforeExecuteRoute($dispatcher){
        $user = Authenticate::getUser();

        if(!$user) {
            $this->dispatcher->forward(array(
                "controller" => "index",
                "action" => "index"
            ));
            return false;
        }

        if(!$user->isAdmin()) {
            return $this->response->redirect("dashboard");
        }

        $this->view->t = Translation::get(Language::get(), "schoolbag");
    }

    public function indexAction() {
        $user = Authenticate::getUser();

        if(!$user) {
            return $this->response->redirect("index");
        }

        $numberPage = $this->request->getQuery("page", "int");
        $school = School::find();

        $paginator = new Paginator(array("data" => $school,
            "limit"=> 10,"page" => $numberPage));
        $this->view->page = $paginator->getPaginate();

        $this->view->user = $user;
    }

    public function newSchoolAction() {
        $this->view->t = Translation::get(Language::get(), "school");
        $this->setTokenValues();
        $this->view->render('admin/schools', 'new');
    }

    public function createSchoolAction() {
        $t = Translation::get(Language::get(), "school");
        if (!$this->isValidPost()) { return $this->toIndex(); }

        $school = $this->populeSchool();

        if (!$school->save()) {
            foreach ($school->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "admin",
                "action" => "newSchool"
            ));
        }

        $this->flash->success($t->_("school-created"));
        return $this->toIndex();
    }

    public function deleteSchoolAction($schoolID) {
        $t = Translation::get(Language::get(), "school");
        $school = School::findFirstById($schoolID);

        if (!$school) {
            $this->flash->error($t->_("school-not-found"));
            return $this->toIndex();
        }

        if (!$school->delete()) {
            foreach ($school->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->toIndex();
        }

        $this->flash->success($t->_("school-deleted"));
        return $this->toIndex();
    }

    public function editSchoolAction($schoolID) {
        $this->view->t = Translation::get(Language::get(), "school");
        if (!$this->request->isPost()) {
            $school = School::findFirstById($schoolID);
            if (!$school) {
                $this->flash->error($this->view->t->_("school-not-found"));
                return $this->toIndex();
            }

            $this->view->schoolID = $school->schoolID;

            $this->tag->setDefault("schoolID", $school->id);
            $this->tag->setDefault("SchoolName", $school->name);
            $this->tag->setDefault("Address", $school->address);
            $this->tag->setDefault("SchoolPath", $school->path);
            $this->tag->setDefault("AccessCode", $school->accessCode);
            $this->tag->setDefault("TeacherAccessCode", $school->teacherAccessCode);
            $this->tag->setDefault("allTY", $school->allTY);
            $this->setTokenValues();

            $this->view->render("admin/schools", "edit");
        }
    }

    public function updateSchoolAction() {
        if (!$this->isValidPost()) { return $this->toIndex(); }
        $t = Translation::get(Language::get(), "school");

        $schoolID = $this->request->getPost("schoolID");

        $school = School::findFirstById($schoolID);

        if (!$school) {
            $this->flash->error($t->_("school-not-found"));
            return $this->toIndex();
        }

        $school = $this->populeSchool();

        if (!$school->save()) {
            foreach ($school->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "admin",
                "action" => "editSchool",
                "params" => array($school->id)
            ));
        }

        $this->flash->success($t->_("school-updated"));
        return $this->toIndex();
    }

    public function listConfigsAction() {
        $this->view->configs = Config::find();
        $this->view->render("admin/configs", "index");
    }

    public function newConfigAction() {
        $this->setTokenValues();
        $this->view->render("admin/configs", "new");
    }

    public function createConfigAction() {
        if (!$this->isValidPost()) {
            return $this->toIndex();
        }

        $config = new Config();

        $config->name = $this->request->getPost("name");
        $config->value = $this->request->getPost("value");

        if($config->save()) {
            $this->flash->success("config was created");
        } else {
            $this->flash->error("config was not created");
        }

        return $this->dispatcher->forward(
            array("action" => "listConfigs")
        );
    }

    public function deleteConfigAction($configId) {
        $config = Config::findFirstById($configId);

        if($config) {
            if($config->delete()) {
                $this->flash->success("config was deleted");
            } else {
                $this->flash->error("config was not deleted");
            }
        }

        return $this->dispatcher->forward(
            array("action" => "listConfigs")
        );
    }

    protected function toIndex() {
        return $this->dispatcher->forward(array(
            "controller" => "admin",
            "action" => "index"
        ));
    }

    private function populeSchool() {
        $school = new School();
        $school->id = $this->request->getPost("schoolID");
        $school->name = $this->request->getPost("SchoolName");
        $school->address = $this->request->getPost("Address");
        $school->path = $this->request->getPost("SchoolPath");
        $school->accessCode = $this->request->getPost("AccessCode");
        $school->teacherAccessCode = $this->request->getPost("TeacherAccessCode");
        $school->allTY = $this->request->getPost("allTY");

        return $school;
    }
}
?>

