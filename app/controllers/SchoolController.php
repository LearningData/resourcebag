<?php
require '../app/services/TimeTable.php';

class SchoolController extends UsersController {
    public function timetableAction() {
        $slots = TimeTableConfig::findBySchoolId($this->view->user->schoolId);
        $this->view->hours = TimeTable::hours();
        $this->view->minutes = TimeTable::minutes();
        $this->view->weekDays = TimeTable::weekDays();

        $this->view->slots = $slots;
    }

    public function createSlotAction() {
        if($this->request->isPost()) {
            $schoolId = $this->view->user->schoolId;

            $req = $this->request;
            $startTime = $req->getPost("start-hour") . ":" . $req->getPost("start-minutes");
            $endTime = $req->getPost("end-hour") . ":" . $req->getPost("end-minutes");
            $idTimeSlot = $req->getPost("start-hour") . $req->getPost("start-minutes");

            $timeTableConfig = new TimeTableConfig();
            $timeTableConfig->id = $idTimeSlot;
            $timeTableConfig->startTime = $startTime;
            $timeTableConfig->endTime = $endTime;
            $timeTableConfig->preset = $req->getPost("preset");
            $timeTableConfig->weekDay = $req->getPost("week-day");
            $timeTableConfig->schoolId = $schoolId;

            if ($timeTableConfig->save()) {
                $this->flash->success("user was created successfully");
            } else {
                foreach ($timeTableConfig->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }

            return $this->dispatcher->forward(array("action" => "timetable"));
        }
    }
}
?>