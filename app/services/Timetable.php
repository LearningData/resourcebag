<?php
    class Timetable {
        public static function getSlotsByDay($user, $weekDay) {
            $params = "schoolId = " . $user->schoolId . " and weekDay = $weekDay";
            $configs = TimetableConfig::find($params);

            $classes = ClassList::find("teacherId = " . $user->id);
            $teacherClasses = array();

            foreach($classes as $classList) {
                $query = "classId = " . $classList->id . " and day = $weekDay";
                $slots = TimetableSlot::find($query);

                foreach($slots as $slot) {
                    $teacherClasses[$slot->timeSlotId] = $classList->subject->name;
                }
            }

            $slots = array();

            foreach ($configs as $config) {
                if (array_key_exists($config->timeSlotId, $teacherClasses)) {
                    $subjectName = $teacherClasses[$config->timeSlotId];
                    $slots[$config->timeSlotId] = $config->startTime . " / " . $subjectName;
                } else {
                    $slots[$config->timeSlotId] = $config->startTime;
                }
            }

            return $slots;
        }

        public static function getEmptySlotsByDay($user, $weekDay) {
            $params = "schoolId = " . $user->schoolId . " and weekDay = $weekDay";
            $configs = TimetableConfig::find($params);

            $classes = ClassList::find("teacherId = " . $user->id);
            $teacherClasses = array();

            foreach ($classes as $classList) {
                $query = "classId = " . $classList->id . " and day = $weekDay";
                $slot = TimetableSlot::findFirst($query);

                if ($slot) {
                    $teacherClasses[$slot->timeSlotId] = $classList->subject->name;
                }
            }

            $slots = array();

            foreach ($configs as $config) {
                if (!array_key_exists($config->timeSlotId, $teacherClasses)) {
                    $slots[$config->timeSlotId] = $config;
                }
            }

            return $slots;
        }

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