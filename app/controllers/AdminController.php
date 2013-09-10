<?php
use Phalcon\Mvc\Model\Criteria, Phalcon\Paginator\Adapter\Model as Paginator;

class AdminController extends \Phalcon\Mvc\Controller {
    public function indexAction() {
        $userId = $this->session->get("userId");

        if(!$userId) {
            return $this->response->redirect("index");
        }

        $numberPage = $this->request->getQuery("page", "int");
        $school = School::find();

        $user = User::findFirst($userId);

        $paginator = new Paginator(array("data" => $school, "limit"=> 10,"page" => $numberPage));
        $this->view->page = $paginator->getPaginate();
        $this->view->userId = $user->FirstName;
        $this->view->user = $user;
    }

    public function newSchoolAction() {
        $this->view->render('admin/schools', 'new');
    }

    public function createSchoolAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

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

        $this->flash->success("school was created successfully");
        return $this->toIndex();
    }

    public function deleteSchoolAction($schoolID) {
        $school = School::findFirstByschoolID($schoolID);

        if (!$school) {
            $this->flash->error("school was not found");
            return $this->toIndex();
        }

        if (!$school->delete()) {
            foreach ($school->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->toIndex();
        }

        $this->flash->success("school was deleted successfully");
        return $this->toIndex();
    }

    public function editSchoolAction($schoolID) {
        if (!$this->request->isPost()) {
            $school = School::findFirstByschoolID($schoolID);
            if (!$school) {
                $this->flash->error("school was not found");
                return $this->toIndex();
            }

            $this->view->schoolID = $school->schoolID;

            $this->tag->setDefault("schoolID", $school->schoolID);
            $this->tag->setDefault("SchoolName", $school->SchoolName);
            $this->tag->setDefault("Address", $school->Address);
            $this->tag->setDefault("SchoolPath", $school->SchoolPath);
            $this->tag->setDefault("AccessCode", $school->AccessCode);
            $this->tag->setDefault("TeacherAccessCode", $school->TeacherAccessCode);
            $this->tag->setDefault("allTY", $school->allTY);

            $this->view->render("admin/schools", "edit");
        }
    }

    public function updateSchoolAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

        $schoolID = $this->request->getPost("schoolID");

        $school = School::findFirstByschoolID($schoolID);

        if (!$school) {
            $this->flash->error("school does not exist " . $schoolID);
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
                "params" => array($school->schoolID)
            ));
        }

        $this->flash->success("school was updated successfully");
        return $this->toIndex();
    }

    private function toIndex() {
        return $this->dispatcher->forward(array(
            "controller" => "admin",
            "action" => "index"
        ));
    }

    private function populeSchool() {
        $school = new School();
        $school->schoolID = $this->request->getPost("schoolID");
        $school->SchoolName = $this->request->getPost("SchoolName");
        $school->Address = $this->request->getPost("Address");
        $school->SchoolPath = $this->request->getPost("SchoolPath");
        $school->AccessCode = $this->request->getPost("AccessCode");
        $school->TeacherAccessCode = $this->request->getPost("TeacherAccessCode");
        $school->allTY = $this->request->getPost("allTY");

        return $school;
    }
}
?>

