<?php
class HomeworkService {
    public static function create($user, $classList, $params) {
        $homework = new Homework();
        $homework->text = $params["description"];
        $homework->classId = $classList->id;
        $homework->dueDate = $params["due-date"];
        $homework->title = $params["title"];
        $homework->schoolId = $user->schoolId;
        $homework->teacherId = $classList->user->id;
        $homework->studentId = $user->id;
        $homework->timeSlotId = $params["due-time"];
        $homework->setDate = date("Y-m-d");
        $homework->submittedDate = "0000-00-00";
        $homework->reviewedDate = "0000-00-00";
        $homework->status = Homework::$PENDING;

        return $homework;
    }

    public static function createFile($homeworkId, $file, $description) {
        $homeworkFile = new HomeworkFile();
        $homeworkFile->originalName = $file->getName();
        $homeworkFile->name = $file->getName();
        $homeworkFile->size = $file->getSize();
        $homeworkFile->type = $file->getType();
        $homeworkFile->file = file_get_contents($file->getTempName());
        $homeworkFile->homeworkId = $homeworkId;
        $homeworkFile->description = $description;

        return $homeworkFile;
    }
}
?>