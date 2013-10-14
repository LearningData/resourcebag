<?php
    class Timetable {
        public static function getSlotsByDay($user, $day) {
            $configs = TimetableConfig::findBySchoolAndDay($user->schoolId, $day);
            $classesList = ClassList::find("teacherId = " . $user->id);
            $classes = Timetable::populeClasses($classesList, $day);
            $slots = Timetable::populeSlots($classes, $configs);

            return $slots;
        }

        public static function populeClasses($classesList, $day) {
            $classes = array();

            foreach($classesList as $classList) {
                $slots = TimetableSlot::findByClassAndDay($classList->id, $day);

                foreach($slots as $slot) {
                    $classes[$slot->timeSlotId] = $classList->subject->name;
                }
            }

            return $classes;
        }

        public static function getStudentSlotsByDay($user, $day) {
            $dayOfWeek = $day->format("w");
            $configs = TimetableConfig::findBySchoolAndDay($user->schoolId, $dayOfWeek);
            $studentClasses = array();

            foreach ($user->classes as $classList) {
                $query = "classId = " . $classList->id . " and day = $dayOfWeek";
                $slot = TimetableSlot::findFirst($query);
                if (!$slot) { continue; }

                $homeworkQuery = "studentId = " . $user->id .
                    " and classId = " . $classList->id .
                    " and dueDate = '" . $day->format("Y-m-d") . "'" .
                    " and status >= " . Homework::$SUBMITTED;

                $homeworks = Homework::find($homeworkQuery);
                //$content = $classList->subject->name . " / " . count($homeworks);
                $content = array(
                    "subject" => $classList->subject->name,
                    "room" => $slot->room,
                    "homeworks" => count($homeworks)
                );
                $studentClasses[$slot->timeSlotId] = $content;
            }

            $slots = Timetable::populeSlots($studentClasses, $configs);

            return $slots;
        }

        public static function getTeacherSlotsByDay($user, $day) {
            $dayOfWeek = $day->format("w");
            $configs = TimetableConfig::findBySchoolAndDay($user->schoolId, $dayOfWeek);
            $teacherClasses = array();

            $classes = ClassList::find("teacherId = " . $user->id);

            foreach ($classes as $classList) {
                $query = "classId = " . $classList->id . " and day = $dayOfWeek";
                $slot = TimetableSlot::findFirst($query);
                if (!$slot) { continue; }

                $content = array(
                    "subject" => $classList->subject->name,
                    "room" => $slot->room,
                );
                $teacherClasses[$slot->timeSlotId] = $content;
            }

            $slots = Timetable::populeSlots($teacherClasses, $configs);

            return $slots;
        }

        public static function populeSlots($classes, $configs) {
            $slots = array();

            if($configs) {
                foreach ($configs as $config) {
                    if (array_key_exists($config->timeSlotId, $classes)) {
                        $content = $classes[$config->timeSlotId];
                        $content["time"] = $config->startTime;
                        $slots []= $content;
                    } else {
                        $slots []= array("time" => $config->startTime,
                            "subject" => $config->preset);
                    }
                }
            }

            return $slots;
        }

        public static function getEmptySlotsByDay($user, $day) {
            $configs = TimetableConfig::findBySchoolAndDay($user->schoolId, $day);
            $classesList = ClassList::find("teacherId = " . $user->id);
            $classes = Timetable::populeClasses($classesList, $day);
            $slots = array();

            foreach ($configs as $config) {
                if (!array_key_exists($config->timeSlotId, $classes)) {
                    $slots[$config->timeSlotId] = $config;
                }
            }

            return $slots;
        }

        public static function weekDays() {
            return array(
                0 => "Sunday",
                1 => "Monday",
                2 => "Tuesday",
                3 => "Wednesday",
                4 => "Thursday",
                5 => "Friday",
                6 => "Saturday"
            );
        }

        public static function hours() {
            $hours = array();

            for ($i=7; $i <= 15 ; $i++) {
                $hour = sprintf("%02s", $i);
                $hours[$hour] = $hour;
            }

            return $hours;
        }

        public static function minutes() {
            $minutes = array();

            for ($i=0; $i <= 55 ; $i = $i + 5) {
                $minute = sprintf("%02s", $i);
                $minutes[$minute] = $minute;
            }

            return $minutes;
        }

        public static function getCurrentWeek() {
            $timestamp = time();
            $lastSunday = date("Y-m-d H:i:s", strtotime("last monday", $timestamp));
            $start = new DateTime($lastSunday);
            $interval = new DateInterval("P1D");
            $period = new DatePeriod($start,$interval, 5);

            return $period;
        }
    }
?>