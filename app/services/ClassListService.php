<?php

class ClassListService {
    public static function getClassesByUser($user) {
        $classes = array();

        if ($user->isStudent()) {
            $classesList = $user->classes;
        } else {
            $classesList = ClassList::getClassesByTeacherId($user->id);
        }

        foreach ($classesList as $classList) {
            $classes[$classList->id] = $classList->subject->name;
        }

        return $classes;
    }
}
?>