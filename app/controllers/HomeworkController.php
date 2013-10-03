<?php
use Phalcon\Mvc\Model\Criteria, Phalcon\Paginator\Adapter\Model as Paginator;

class HomeworkController extends ControllerBase {
    public function indexAction() {
        $user = $this->getUserBySession();
        $numberPage = $this->request->getQuery("page", "int");
        $status = $this->request->get("filter");

        if ($user->isStudent()) {
            $homeworks = $user->getHomeworkByStatus($status);
            $template = "student/homework/list";
        } else {
            if ($status != "") {
                $homeworks = Homework::find("classId = $classId and status = $status");
            } else {
                $homeworks = Homework::find("classId = $classId and status >= 2");
            }

            $template = "teacher/homework/list";
        }

        $this->view->user = $user;
        $this->view->status = $status;

        $params = array("data" => $homeworks,
            "limit"=> 10, "page" => $numberPage
        );

        $paginator = new Paginator($params);
        $this->view->page = $paginator->getPaginate();
        $totalPages = $this->view->page->total_pages;
        $links = array();
        foreach (range(1, $totalPages) as $number) {
            $attributes = "/homework?page=$number&filter=$status";
            $links []= array("url"=> $user->getController() . $attributes,
                "page" => $number
            );
        }
        $this->view->links = $links;
        $this->view->pick($template);
    }

    public function showAction($homeworkId) {
        $this->getUserBySession();
        $this->view->homework = Homework::findFirstById($homeworkId);
    }

    public function newHomeworkAction() {
        $user = $this->getUserBySession();

        if ($user->isStudent()) {
            $classes = array();

            foreach ($user->classes as $classList) {
                $classes[$classList->id] = $classList->subject->name;
            }

            $this->view->classes = $classes;
            $template = "student/homework/new";
        } else {
            $template = "teacher/homework/new";
        }

        $this->view->status = $status;
        $this->view->pick($template);
    }

    public function answerAction($homeworkId) {
        $homework = Homework::findFirstById($homeworkId);
        $user = $this->getUserBySession();

        if (!$homework) { echo "error"; }
        $this->view->homework = $homework;
    }

    public function reviewAction($homeworkId) {
        $homework = Homework::findFirstById($homeworkId);
        $user = $this->getUserBySession();

        if (!$homework) { echo "error"; }
        $this->view->homework = $homework;
    }

    public function reviewedAction($homeworkId) {
        $homework = $this->reviewHomework($homeworkId);

        $uri = "teacher/homework/" . $homework->classId;
        return $this->response->redirect($uri);
    }

    public function reviewManyHomeworksAction() {
        $ids = $this->request->getPost("ids");

        foreach ($ids as $id) {
            $this->reviewHomework($id);
        }

        $uri = "teacher/homework/" . $this->request->getPost("class-id");
        return $this->response->redirect($uri);
    }

    public function downloadFileAction($fileId) {
        $file = HomeworkFile::findFirst("id = $fileId");
        if (!$file) {
            $this->flash->error("Error to download file.");
        }

        header("Content-length: " . $file->size);
        header("Content-type: " . $file->type);
        header("Content-Disposition: attachment; filename=" . $file->name);

        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->response->setContent($file->file)->send();
    }

    public function submitAction($homeworkId) {
        $homework = Homework::findFirstById($homeworkId);
        $user = $this->getUserBySession();

        if (!$homework) { echo "error"; }

        $homework->submittedDate = date("Y-m-d");
        $homework->status = Homework::$SUBMITTED;

        if ($homework->save()) {
            $this->flash->success("The homework was submitted.");
        } else {
            $this->flash->error("The homework was not submitted.");
        }

        return $this->response->redirect("student/homework");
    }

    public function createHomeworkByStudentAction($classId) {
        $user = $this->getUserBySession();
        $teacherId = $this->request->getPost("teacher-id");
        $homework = $this->populeHomework($teacherId, $user->id);

        if (!$homework->save()) {
            $this->flash->error("Was not possible to create the homework");
            $this->appendErrorMessages($homework->getMessages());
        } else {
            $this->flash->success("The homework was created");
        }

        return $this->dispatcher->forward(array("action" => "homework"));
    }

    public function uploadFileAction() {
        $homeworkId = $this->request->getPost("homework-id");
        $description = $this->request->getPost("description");

        if ($this->request->hasFiles() == true) {
            foreach ($this->request->getUploadedFiles() as $file){
                $homeworkFile = new HomeworkFile();
                $homeworkFile->originalName = $file->getName();
                $homeworkFile->name = $file->getName();
                $homeworkFile->size = $file->getSize();
                $homeworkFile->type = $file->getType();
                $homeworkFile->file = file_get_contents($file->getTempName());
                $homeworkFile->homeworkId = $homeworkId;
                $homeworkFile->description = $description;

                if ($homeworkFile->save()) {
                    $this->flash->success("The file was uploaded.");
                } else {
                    $this->flash->error("The file was not uploaded.");
                    foreach ($homeworkFile->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                }
            }
        }

        return $this->dispatcher->forward(array("action" => "answer",
            "params" => array("homeworkId" => $homeworkId)));
    }

    public function removeFileAction($fileId) {
        $file = HomeworkFile::findFirstById($fileId);

        $homeworkId = $file->homeworkId;

        if ($file->delete()) {
            $this->flash->success("File was removed");
        } else {
            $this->flash->error("File was not removed");
        }

        return $this->dispatcher->forward(array("action" => "answer",
            "params" => array("homeworkId" => $homeworkId)));
    }

    private function populeHomework($teacherId, $studentId) {
        $homework = new Homework();

        $homework->text = $this->request->getPost("description");
        $homework->classId = $this->request->getPost("class-id");
        $homework->dueDate = $this->request->getPost("due-date");
        $homework->schoolId = $this->view->user->schoolId;
        $homework->teacherId = $teacherId;
        $homework->studentId = $studentId;
        $homework->timeSlotId = "0000";
        $homework->setDate = date("Y-m-d");
        $homework->submittedDate = "0000-00-00";
        $homework->reviewedDate = "0000-00-00";
        $homework->status = 0;

        return $homework;
    }

    private function reviewHomework($homeworkId) {
        $homework = Homework::findFirstById($homeworkId);
        $user = $this->getUserBySession();

        $homework->reviewedDate = date("Y-m-d");
        $homework->status = Homework::$REVIEWED;

        if (!$homework->save()) {
            $this->flash->error("Error to review the homework");
        } else {
            $this->flash->success("Homework was reviewed.");
        }

        return $homework;
    }

    private function appendErrorMessages($messages) {
        foreach ($messages as $message) {
            $this->flash->error($message);
        }
    }
}