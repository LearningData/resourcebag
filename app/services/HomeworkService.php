<?php
use Phalcon\Mvc\Model\Criteria, Phalcon\Paginator\Adapter\Model as Paginator;

class HomeworkService {
    public static function jsonToDashboard($user) {
        $jsonHomeworks = array();

        if ($user->isStudent()) {
            $homeworks = $user->homeworks;
        } else {
            $homeworks = Homework::find("teacherId = " .$user->id);
        }

        foreach($homeworks as $homework) {
            $subject = $homework->classList->subject->name;
            $jsonHomeworks []= array("id" => $homework->id,
                 "subject" => $subject,
                 "description" => $homework->text,
                 "status" => $homework->status,
                 "student" => $homework->user->name . " " . $homework->user->lastName
            );
        }

        return $jsonHomeworks;
    }

    public static function create($user, $classList, $params) {
        $homework = new Homework();
        $homework->text = $params["description"];
        $homework->classId = $classList->id;
        $homework->dueDate = $params["due-date"];
        $homework->title = $params["title"];
        $homework->schoolId = $user->schoolId;
        $homework->teacherId = $classList->user->id;
        $homework->studentId = $user->id;
        $homework->setDate = date("Y-m-d");
        $homework->submittedDate = "0000-00-00";
        $homework->reviewedDate = "0000-00-00";
        $homework->status = Homework::$PENDING;

        if(array_key_exists("due-time", $params)) {
            $homework->timeSlotId = $params["due-time"];
        }

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

    public static function getPaginateLinks($controller, $pages, $status) {
        $links = array();
        foreach (range(1, $pages) as $page) {
            $url = "$controller/homework?page=$page&filter=$status";
            $links []= array("url"=> $url,
                "page" => $page
            );
        }

        return $links;
    }

    public static function getPage($homeworks, $currentPage) {
        $params = array("data" => $homeworks,
            "limit"=> 10, "page" => $currentPage
        );

        $paginator = new Paginator($params);
        return $paginator->getPaginate();
    }
}
?>