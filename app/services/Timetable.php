<?php
    class Timetable {
        public static function getSlotsByDay($user, $weekDay) {
            $params = "schoolId = " . $user->schoolId . " and weekDay = $weekDay";
            $configs = TimetableConfig::find($params);

            $classes = ClassList::find("teacherId = " . $user->id);
            $studentClasses = array();

            foreach($classes as $classList) {
                $query = "classId = " . $classList->id . " and day = $weekDay";
                $slots = TimetableSlot::find($query);

                foreach($slots as $slot) {
                    $studentClasses[$slot->timeSlotId] = $classList->subject->name;
                }
            }

            $slots = Timetable::populeSlots($studentClasses, $configs);

            return $slots;
        }

        public static function getStudentSlotsByDay($user, $weekDay) {
            $params = "schoolId = " . $user->schoolId . " and weekDay = $weekDay";
            $configs = TimetableConfig::find($params);

            $studentClasses = array();
            $changes = TimetableChange::find("day = $weekDay");

            foreach($changes as $slot) {
                $studentClasses[$slot->timeSlotId] = $slot->subject->name;
            }

            $slots = Timetable::populeSlots($studentClasses, $configs);

            return $slots;
        }

        public static function populeSlots($classes, $configs) {
            $slots = array();

            if($classes && $configs) {
                foreach ($configs as $config) {
                    if (array_key_exists($config->timeSlotId, $classes)) {
                        $subjectName = $classes[$config->timeSlotId];
                        $slots[$config->timeSlotId] = $config->startTime . " / " . $subjectName;
                    } else {
                        $slots[$config->timeSlotId] = $config->startTime;
                    }
                }
            }

            return $slots;
        }

        public static function getEmptySlotsByDay($user, $weekDay) {
            $params = "schoolId = " . $user->schoolId . " and weekDay = $weekDay";
            $configs = TimetableConfig::find($params);

            $classes = ClassList::find("teacherId = " . $user->id);
            $studentClasses = array();

            foreach ($classes as $classList) {
                $query = "classId = " . $classList->id . " and day = $weekDay";
                $slot = TimetableSlot::findFirst($query);

                if ($slot) {
                    $studentClasses[$slot->timeSlotId] = $classList->subject->name;
                }
            }

            $slots = array();

            foreach ($configs as $config) {
                if (!array_key_exists($config->timeSlotId, $studentClasses)) {
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
    }
?>