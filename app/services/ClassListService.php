<?php

class ClassListService {
    public static function getClassesByUser($user) {
        $classes = array();

        if ($user->isStudent()) {
            $classesList = $user->classes;
        } else {
            if ($user->isTeacher()) {
                $classesList = ClassList::getClassesByTeacherId($user->id);
            } else {
                $classesList = ClassList::find("schoolId = " . $user->schoolId);
            }
        }

        foreach ($classesList as $classList) {
            $classes[$classList->id] = $classList->subject->name;
        }

        return $classes;
    }

    public static function classesToIds($classes) {
        $classIdParams = "";

        foreach ($classes as $classList) {
            $classIdParams .= $classList->id . ",";
        }

        $classIdParams .= "''";
        return $classIdParams;
    }
}
?>