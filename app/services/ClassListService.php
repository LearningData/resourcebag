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

    public function getClassesByGroup($group, $user) {
        $classes = array();
        $ids = array();
        $t = Translation::get(Language::get(), "schoolbag");
        foreach ($user->classes as $classList) { $ids []= $classList->id; }

        if($group && count($group->cohorts) > 0) {
            foreach ($group->cohorts as $cohort) {
                foreach ($cohort->classes as $classList) {
                    if($classList->subject) {
                        if(in_array($classList->id, $ids)) { continue; }

                        $classInfo = $classList->subject->name . " " .
                                    $t->_($classList->user->title) . " " .
                                    $classList->user->lastName . " " .
                                    $classList->extraRef;
                    } else {
                        $classInfo = $classList->extraRef . " " .
                                    $cohort->stage;
                    }


                    $classes[$classList->id] = $classInfo;
                }
            }
        }

        return $classes;
    }
}
?>