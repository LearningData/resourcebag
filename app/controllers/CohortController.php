<?php
class CohortController extends ControllerBase {
    public function indexAction(){
        $user = $this->getUserBySession();

        if(!$user->isSchool()) {
            return $this->response->redirect($user->getController());
        }

        $this->view->cohorts = Cohort::find("schoolId = " . $user->schoolId);
    }

    public function newAction() {
        $this->view->cohort = new Cohort();
        $this->view->year = Config::findFirst("name='schoolYear'");
    }

    public function editAction($cohortId) {
        $this->view->cohort = Cohort::findFirstById($cohortId);
        $this->view->year = Config::findFirst("name='schoolYear'");
    }

    public function removeAction($cohortId) {
        $cohort = Cohort::findFirstById($cohortId);

        if($cohort->delete()) {
            $this->flash->success("Cohort was removed.");
        } else {
            $this->flash->success("Cohort was not removed.");
        }

        return $this->response->redirect("cohort");
    }

    public function updateAction() {
        $cohortId = $this->request->getPost("cohort-id");

        $cohort = Cohort::findFirstById($cohortId);
        $cohort->stage = $this->request->getPost("stage");

        if ($cohort->save()) {
            $this->flash->success("Cohort was saved.");
        } else {
            $this->appendErrorMessages($cohort->getMessages());
        }

        return $this->response->redirect("cohort");
    }

    public function createAction() {
        $year = Config::findFirst("name='schoolYear'");
        $user = $this->getUserBySession();

        $cohort = new Cohort();
        $cohort->schoolYear = $year->value;
        $cohort->stage = $this->request->getPost("stage");
        $cohort->courseId = 0;
        $cohort->schoolId = $user->schoolId;

        if ($cohort->save()) {
            $this->flash->success("Cohort was saved.");
        } else {
            $this->appendErrorMessages($cohort->getMessages());
        }

        return $this->response->redirect("cohort/new");
    }
}