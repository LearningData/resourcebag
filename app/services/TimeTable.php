<?php
    class TimeTable {
        public static function weekDays() {
            return array(
                1 => "Sunday",
                2 => "Monday",
                3 => "Tuesday",
                4 => "Wednesday",
                5 => "Thursday",
                6 => "Friday",
                7 => "Saturday"
            );
        }

        public static function hours() {
            return array(
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
        }

        public static function minutes() {
            return array(
                "00" => "00",
                "05" => "05",
                "10" => "10",
                "15" => "15",
                "20" => "20",
                "25" => "25",
                "30" => "30",
                "35" => "35",
                "40" => "40",
                "45" => "45",
                "50" => "50",
                "55" => "55"
            );
        }
    }
?>