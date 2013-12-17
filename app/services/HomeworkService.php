<?php
use Phalcon\Paginator\Adapter\Model as ModelPaginator;
use Phalcon\Paginator\Adapter\NativeArray as ArrayPaginator;

class HomeworkService {
    public static function jsonToDashboard($user) {
        $jsonHomeworks = array();

        if ($user->isStudent()) {
            $homeworks = $user->homeworks;
            foreach ($homeworks as $homework) {
                $subject = $homework->info->classList->subject->name;
                $name = $homework->student->name . " " .
                    $homework->student->lastName;

                $jsonHomeworks []= array("id" => $homework->id,
                     "subject" => $subject,
                     "description" => $homework->info->text,
                     "title" => $homework->info->title,
                     "status" => $homework->status,
                     "student" => $name,
                     "due-date" => $homework->info->dueDate
                );
            }
        } else {
            $homeworks = Homework::findByTeacherId($user->id);

            foreach($homeworks as $homeworkInfo) {
                foreach ($homeworkInfo->works as $homework) {
                    $subject = $homework->info->classList->subject->name;
                    $name = $homework->student->name . " " .
                        $homework->student->lastName;

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

    public static function getLinksByClass($controller,$classId, $pages, $status, $params="") {
        $links = array();
        foreach (range(1, $pages) as $page) {
            $url = "$controller/homework/class/$classId?page=$page&filter=$status$params";
            $links []= array("url"=> $url,
                "page" => $page
            );
        }

        return $links;
    }

    public static function getPage($homeworks, $currentPage, $limit = 10) {
        $params = array("data" => $homeworks,
            "limit"=> $limit, "page" => $currentPage
        );

        if(is_array($homeworks)) {
            $paginator = new ArrayPaginator($params);
        } else {
            $paginator = new ModelPaginator($params);
        }

        return $paginator->getPaginate();
    }

    public function getHomeworkByClass($user, $classId) {
        $homeworks = $this->modelsManager->createBuilder()
            ->from("HomeworkUser")
            ->join("Homework")
            ->where("classId = " . $classId)
            ->andWhere("studentId = " . $user->id)
            ->orderBy("status")
            ->orderBy("dueDate")
            ->getQuery()
            ->execute();

        return $homeworks;
    }

    public function getHomeworkByWeek($classId, $firstWeek, $secondWeek) {
        $homeworks = $this->modelsManager->createBuilder()
            ->from("HomeworkUser")
            ->innerJoin("Homework", 'Homework.id = HomeworkUser.homeworkId')
            ->where("classId = $classId")
            ->andWhere("dueDate >= '$firstWeek'")
            ->andWhere("dueDate <= '$secondWeek'")
            ->getQuery()
            ->execute();

        return $homeworks;
    }

    public function homeworksGroupedByWeek($classId) {
        $homeworks = array();
        $first = date('Y-m-d',strtotime('monday +0 week'));

        for($week = 1; $week <= 4; $week++) {
            $next = date('Y-m-d',strtotime("monday +$week week"));
            $works = HomeworkService::getHomeworkByWeek($classId, $first, $next);
            $homeworks []= array("week" => "$first - $next", "homeworks" => $works,
                        "start" => $first);
            $first = $next;
        }

        return $homeworks;
    }
}
?>
