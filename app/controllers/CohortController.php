<?php
class CohortController extends ControllerBase {
    public function beforeExecuteRoute($dispatcher){
        $user = Authenticate::getUser();

        if(!$user) { return $this->response->redirect("index"); }

        if(!$user->isSchool()) {
            return $this->response->redirect("dashboard");
        }
        $this->view->t = Translation::get(Language::get(), "cohort");
    }

    public function indexAction(){
        $user = $this->getUserBySession();
        $this->view->cohorts = Cohort::findBySchoolId($user->schoolId);
    }

    public function newAction() {
        $this->setTokenValues();
        $this->view->cohort = new Cohort();
        $this->view->year = Config::schoolYear();
    }

    public function editAction($cohortId) {
        $this->setTokenValues();
        $this->view->cohort = Cohort::findFirstById($cohortId);
        $this->view->year = Config::schoolYear();
    }

    public function removeAction($cohortId) {
        $cohort = Cohort::findFirstById($cohortId);

        if($cohort->delete()) {
            $this->flash->success($this->view->t->_("cohort-removed"));
        } else {
            $this->flash->success($this->view->t->_("cohort-not-removed"));
        }

        return $this->response->redirect("cohort");
    }

    public function updateAction() {
        $cohortId = $this->request->getPost("cohort-id");
        $cohort = Cohort::findFirstById($cohortId);
        $cohort->stage = $this->request->getPost("stage");

        if ($cohort->save()) {
            $this->flash->success($this->view->t->_("cohort-updated"));
        } else {
            $this->appendErrorMessages($cohort->getMessages());
        }

        return $this->response->redirect("cohort");
    }

    public function createAction() {
        if($this->isValidPost()) {
            $user = $this->getUserBySession();

            $cohort = new Cohort();
            $cohort->schoolYear = Config::schoolYear();
            $cohort->stage = $this->request->getPost("stage");
            $cohort->courseId = 0;
            $cohort->schoolId = $user->schoolId;

            if ($cohort->save()) {
                $this->flash->success($this->view->t->_("cohort-created"));
            } else {
                $this->appendErrorMessages($cohort->getMessages());
            }

            return $this->response->redirect("cohort/new");
        }
    }
}