<?php

class ClassListService {
    public static function getClassesByUser($user) {
        $classes = array();

        if ($user->isStudent()) {
            $classesList = $user->classes;
        } else {
            if ($user->isTeacher()) {
                $classesList = ClassList::findByTeacherId($user->id);
            } else {
                $classesList = ClassList::findBySchoolId($user->schoolId);
            }
        }

        foreach ($classesList as $classList) {
            $classInfo = $classList->extraRef . " " .
                        $classList->subject->name . " " .
                        $classList->cohort->stage;

            $classes[$classList->id] = $classInfo;
        }

        return $classes;
    }

    public static function getSubjectsByUser($user) {
        $subjects = array();

        if ($user->isStudent()) {
            $classesList = $user->classes;
        } else {
            if ($user->isTeacher()) {
                $classesList = ClassList::findByTeacherId($user->id);
            } else {
                $classesList = ClassList::findBySchoolId($user->schoolId);
            }
        }

        foreach ($classesList as $classList) {
            $subjects[$classList->subject->id] = $classList->subject->name;
        }

        return $subjects;
    }

    public static function classesToIds($classes) {
        $classIdParams = "";

        foreach ($classes as $classList) {
            $classIdParams .= $classList->id . ",";
        }

        $classIdParams .= "''";
        return $classIdParams;
    }

    public function getClassesByGroup($group) {
        $classes = array();
        if($group && count($group->cohorts) > 0) {
            foreach ($group->cohorts as $cohort) {
                foreach ($cohort->classes as $classList) {
                    $classes [$classList->id]= $classList->subject->name;
                }
            }
        }

        return $classes;
    }
}
?>