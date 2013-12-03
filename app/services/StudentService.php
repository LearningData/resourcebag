<?php
use Phalcon\Mvc\User\Component;

class StudentService extends Component {
    public function joinClass($user, $classList) {
        $classListUser = ClassListUser::findFirst("studentId = " . $user->id .
            " and classId = " . $classList->id);

        if($classListUser) { return true; }

        $classListUser = new ClassListUser();
        $classListUser->schoolId = $user->schoolId;
        $classListUser->studentId = $user->id;
        $classListUser->classId = $classList->id;


        if ($classListUser->save()) {
            $slots = TimetableSlot::findByClassId($classList->id);

            foreach ($slots as $slot) {
                $timetableChange = new TimetableChange();
                $timetableChange->schoolId = $slot->schoolId;
                $timetableChange->day = $slot->day;
                $timetableChange->studentId = $user->id;
                $timetableChange->timeSlotId = $slot->timeSlotId;
                $timetableChange->room = $slot->room;
                $timetableChange->subjectId = $classList->subject->id;

                if (!$timetableChange->save()) {
                    $classListUser->delete();
                }
            }

            return true;
        } else {
            return false;
        }
    }
}