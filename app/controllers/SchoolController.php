<?php

class SchoolController extends UsersController {
    public function timetableAction() {
        $slots = TimetableConfig::findBySchoolId($this->view->user->schoolId);
        $this->view->hours = Timetable::hours();
        $this->view->minutes = Timetable::minutes();
        $this->view->weekDays = Timetable::weekDays();
        $this->view->year = Config::findFirst("name = 'schoolYear'")->value;

        $this->view->slots = $slots;
    }

    public function createSlotAction() {
        if($this->request->isPost()) {
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
                $this->flash->success("user was created successfully");
            } else {
                foreach ($timeTableConfig->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }

            return $this->dispatcher->forward(array("action" => "timetable"));
        }
    }

    public function deleteSlotAction($slotId) {
        $slot = TimetableConfig::findFirstById($slotId);

        if($slot->delete()) {
            $this->flash->success("Slot was deleted");
        } else {
            $this->flash->error("Slot was not deleted");
        }

        return $this->dispatcher->forward(array("action" => "timetable"));
    }
}
?>