<?php
use Phalcon\Paginator\Adapter\Model as ModelPaginator;
use Phalcon\Paginator\Adapter\NativeArray as ArrayPaginator;

class HomeworkService {
    public static function jsonToDashboard($user) {
        $jsonHomeworks = array();

        if ($user->isStudent()) {
            $homeworks = $user->homeworks;
        } else {
            $homeworks = Homework::findByTeacherId($user->id);
        }

        foreach($homeworks as $homeworkInfo) {
            foreach ($homeworkInfo->works as $key => $homework) {
                $subject = $homework->info->classList->subject->name;
                $name = $homework->student->name . " " . $homework->student->lastName;
                $jsonHomeworks []= array("id" => $homework->id,
                     "subject" => $subject,
                     "description" => $homework->info->text,
                     "title" => $homework->info->title,
                     "status" => $homework->status,
                     "student" => $name,
                     "due-date" => $homework->info->dueDate
                );
            }
        }

        return $jsonHomeworks;
    }

    public static function create($classList, $params, $owner) {
        $homework = new Homework();
        $homework->text = $params["description"];
        $homework->classId = $classList->id;
        $homework->dueDate = $params["due-date"];
        $homework->title = $params["title"];
        $homework->schoolId = $classList->schoolId;
        $homework->teacherId = $classList->user->id;
        $homework->setDate = date("Y-m-d");
        $homework->owner = $owner;

        if(array_key_exists("due-time", $params)) {
            $homework->timeSlotId = $params["due-time"];
        }

        return $homework;
    }

    public static function createHomeworkUser($homeworkId, $studentId) {
        $homeworkUser = new HomeworkUser();
        $homeworkUser->homeworkId = $homeworkId;
        $homeworkUser->studentId = $studentId;
        $homeworkUser->submittedDate = "0000-00-00";
        $homeworkUser->reviewedDate = "0000-00-00";
        $homeworkUser->status = Homework::$PENDING;

        return $homeworkUser;
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

    public static function getLinksByclass($controller,$classId, $pages, $status) {
        $links = array();
        foreach (range(1, $pages) as $page) {
            $url = "$controller/homework/class/$classId?page=$page&filter=$status";
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

        if(is_array($homeworks)) {
            $paginator = new ArrayPaginator($params);
        } else {
            $paginator = new ModelPaginator($params);
        }

        return $paginator->getPaginate();
    }
}
?>
