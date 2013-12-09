<?php

class Timetable {
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

    public function getStudentSlotsByDay($user, $day) {
        $dayOfWeek = $day->format("w");
        $configs = TimetableConfig::findBySchoolAndDay($user->schoolId,
            $dayOfWeek);
        $t = Translation::get(Language::get(), "schoolbag");
        $studentClasses = array();

        foreach ($user->classes as $classList) {
            $slots = TimetableSlot::findByClassAndDay($classList->id,
                $dayOfWeek);

            if (!$slots) { continue; }

            foreach ($slots as $slot) {
            $homeworks = $this->modelsManager->createBuilder()
                ->from("Homework")
                ->join("HomeworkUser")
                ->where("classId = " . $classList->id)
                ->andWhere("studentId = " . $user->id)
                ->andWhere("dueDate = '" . $day->format("Y-m-d") . "'")
                ->andWhere("status <= " . Homework::$SUBMITTED)
                ->getQuery()
                ->execute()
                ->count();

                $content = array(
                    "class-id" => $classList->id,
                    "subject" => $classList->subject->name,
                    "room" => $slot->room,
                    "homeworks" => $homeworks,
                    "teacher" => $t->_($classList->user->title) . " " .
                        $classList->user->lastName
                );
                $studentClasses[$slot->timeSlotId] = $content;
            }
        }

        $slots = Timetable::populeSlots($studentClasses, $configs);

        return $slots;
    }

    public function getTeacherSlotsByDay($user, $day) {
        $dayOfWeek = $day->format("w");
        $configs = TimetableConfig::findBySchoolAndDay($user->schoolId, $dayOfWeek);
        $teacherClasses = array();

        $classes = ClassList::findByTeacherId($user->id);

        foreach ($classes as $classList) {
            $slots = TimetableSlot::findByClassAndDay($classList->id,
                $dayOfWeek);

            if (!$slots) { continue; }

            foreach ($slots as $slot) {
                $content = array(
                    "class-id" => $classList->id,
                    "extraRef" => $classList->extraRef,
                    "subject" => $classList->subject->name,
                    "room" => $slot->room,
                );
                $teacherClasses[$slot->timeSlotId] = $content;
            }
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
                    $content["endTime"] = $config->endTime;
                    $content["checked"] = true;
                    $slots []= $content;
                } else {
                    $slots []= array("time" => $config->startTime,
                        "subject" => $config->preset,
                        "endTime" => $config->endTime,
                        "checked" => false);
                }
            }
        }

        return $slots;
    }

    public static function getEmptySlotsByDay($user, $day) {
        $configs = TimetableConfig::findBySchoolAndDay($user->schoolId, $day);
        $classesList = ClassList::findByTeacherId($user->id);
        $classes = Timetable::populeClasses($classesList, $day);
        $slots = array();

        foreach ($configs as $config) {
            if(!array_key_exists($config->timeSlotId, $classes) && !$config->hasPreset()) {
                $slots[$config->timeSlotId] = $config;
            }
        }

        return $slots;
    }

    public function getTeacherTimetable($user, $day, $classId) {
        $configs = TimetableConfig::findBySchoolAndDay($user->schoolId, $day);
        $classesList = ClassList::findById($classId);
        $classes = Timetable::populeClasses($classesList, $day);
        $slots = array();

        foreach($configs as $config) {
            if(!$config->hasPreset()) {
                if (array_key_exists($config->timeSlotId, $classes)) {
                    $slots[$config->timeSlotId] = array("checked" => true,
                        "config" => $config);
                } else {
                    $slots[$config->timeSlotId] = array("checked" => false,
                        "config" => $config);
                }
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
