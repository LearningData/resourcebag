<?php
use Phalcon\Mvc\Model\Criteria, Phalcon\Paginator\Adapter\Model as Paginator;

class SchoolsController extends ControllerBase {
    public function indexAction() {
        $numberPage = $this->request->getQuery("page", "int");
        $school = School::find();

        if (count($school) == 0) {
            $this->flash->notice("The search did not find any school");
            return $this->toIndex();
        }

        $paginator = new Paginator(array("data" => $school, "limit"=> 10,"page" => $numberPage));
        $this->view->page = $paginator->getPaginate();
    }

    public function newAction() {}

    public function editAction($schoolID) {
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

        }
    }

    public function createAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

        $school = $this->populeSchool();

        if (!$school->save()) {
            foreach ($school->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "schools",
                "action" => "new"
            ));
        }

        $this->flash->success("school was created successfully");
        return $this->toIndex();
    }

    public function updateAction() {
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
                "controller" => "schools",
                "action" => "edit",
                "params" => array($school->schoolID)
            ));
        }

        $this->flash->success("school was updated successfully");
        return $this->toIndex();
    }

    public function deleteAction($schoolID) {
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

    private function toIndex() {
        return $this->dispatcher->forward(array(
            "controller" => "schools",
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