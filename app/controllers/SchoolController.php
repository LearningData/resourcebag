<?php
class SchoolController extends UsersController {
    public function timetableAction() {
        $this->view->hours = array(
            "07" => "07",
            "08" => "08",
            "09" => "09",
            "10" => "10",
            "11" => "11",
            "12" => "12",
            "13" => "13",
            "14" => "14",
            "15" => "15"
        );
        $this->view->minutes = array(
            "05" => "05",
            "10" => "10",
            "15" => "15",
            "20" => "20",
            "25" => "25",
            "25" => "30",
            "35" => "35",
            "40" => "40",
            "45" => "45",
            "50" => "50",
            "55" => "55"
        );
        $this->view->weekDays = array(
            1 => "Sunday",
            2 => "Monday",
            3 => "Tuesday",
            4 => "Wednesday",
            5 => "Thursday",
            6 => "Friday",
            7 => "Saturday"
        );
    }

    public function createSlotAction() {
        if($this->request->isPost()) {
            $req = $this->request;
            $startTime = $req->getPost("start-hour") . ":" . $req->getPost("start-minutes");
            $startTime = $req->getPost("end-hour") . ":" . $req->getPost("end-minutes");
            echo "Start time: " . $startTime;
            echo "End time: " . $endTime;
        }
    }
}
?>