<?php

class SchoolController extends UsersController {
    public function beforeExecuteRoute($dispatcher){
        $user = Authenticate::getUser();

        if(!$user) {
            $this->dispatcher->forward(array(
                "controller" => "index",
                "action" => "index"
            ));
            return false;
        }

        if(!$user->isSchool()) {
            return $this->response->redirect("dashboard");
        }

        $this->view->t = Translation::get(Language::get(), "schoolbag");
    }

    public function timetableAction() {
        $this->view->t = Translation::get(Language::get(), "timetable");
        $slots = TimetableConfig::findBySchoolId($this->view->user->schoolId);
        $this->view->hours = Timetable::hours();
        $this->view->minutes = Timetable::minutes();
        $this->view->weekDays = Timetable::weekDays();
        $this->view->year = Config::schoolYear();

        $this->view->slots = $slots;
    }

    public function listUsersAction() {
        $this->view->t = Translation::get(Language::get(), "user");
        $user = Authenticate::getUser();

        $users = User::findBySchoolId($user->schoolId);
        $this->view->users = $users;
    }

    public function editUserAction($userId) {
        $this->view->t = Translation::get(Language::get(), "user");
        $user = User::findFirstById($userId);
        $this->view->schoolUser = $user;
    }

    public function createSlotAction() {
        if($this->request->isPost()) {
            $t = Translation::get(Language::get(), "slot");
            $schoolId = $this->view->user->schoolId;

            $req = $this->request;
            $startTime = $req->getPost("start-hour") . ":" . $req->getPost("start-minutes");
            $endTime = $req->getPost("end-hour") . ":" . $req->getPost("end-minutes");
            $idTimeSlot = $req->getPost("start-hour") . $req->getPost("start-minutes");
            $year = $req->getPost("year");

            $timeTableConfig = new TimetableConfig();
            $timeTableConfig->timeSlotId = $idTimeSlot;
            $timeTableConfig->startTime = $startTime;
            $timeTableConfig->endTime = $endTime;
            $timeTableConfig->preset = $req->getPost("preset");
            $timeTableConfig->weekDay = $req->getPost("week-day");
            $timeTableConfig->schoolId = $schoolId;
            $timeTableConfig->year = $year;

            if ($timeTableConfig->save()) {
                $this->flash->success($t->_("slot-created"));
            } else {
                foreach ($timeTableConfig->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }

            return $this->dispatcher->forward(array("action" => "timetable"));
        }
    }

    public function deleteSlotAction($slotId) {
        $t = Translation::get(Language::get(), "slot");
        $slot = TimetableConfig::findFirstById($slotId);

        if($slot->delete()) {
            $this->flash->success($t->_("slot-deleted"));
        } else {
            $this->flash->error($t->_("slot-not-deleted"));
        }

        return $this->dispatcher->forward(array("action" => "timetable"));
    }
}
?>