<?php
require "../app/services/HomeworkService.php";

class HomeworkController extends ControllerBase {
    public function beforeExecuteRoute($dispatcher){
        $user = Authenticate::getUser();
        if(!$user) { return $this->response->redirect("index"); }
        $this->view->t = Translation::get("en", "schoolbag");
    }

    public function indexAction() {
        $user = $this->getUserBySession();
        $currentPage = $this->request->getQuery("page", "int");
        $status = $this->request->get("filter");
        $template = $user->getController() . "/homework/list";

        if ($user->isStudent()) {
            $homeworks = $user->getHomeworkByStatus($status);
        } else {
            $homeworks = Homework::findByTeacherAndStatus($user->id, $status);
            $this->view->classes = ClassList::findByteacherId($user->id);
        }

        $this->view->user = $user;
        $this->view->status = $status;
        $this->view->page = HomeworkService::getPage($homeworks, $currentPage);
        $totalPages = $this->view->page->total_pages;
        $this->view->links = HomeworkService::getPaginateLinks(
            $user->getController(),
            $totalPages, $status
        );

        $this->view->pick($template);
    }

    public function listByClassAction($classId) {
        if(!$this->isTeacher()) {
            return $this->response->redirect("dashboard");
        }

        $user = $this->getUserBySession();
        $currentPage = $this->request->getQuery("page", "int");
        $status = $this->request->get("filter");

        $homeworks = Homework::findByClassAndStatus($classId, $status);

        $this->view->page = HomeworkService::getPage($homeworks, $currentPage);
        $totalPages = $this->view->page->total_pages;
        $this->view->links = HomeworkService::getPaginateLinks(
            $user->getController(),
            $totalPages, $status
        );

        $this->view->pick("teacher/homework/list");
    }

    public function showAction($homeworkId) {
        $this->getUserBySession();
        $this->view->homework = Homework::findFirstById($homeworkId);
    }

    public function startAction($homeworkId) {
        $homework = Homework::findFirstById($homeworkId);
        $homework->status = Homework::$STARTED;
        $homework->save();

        return $this->response->redirect("student/homework/edit/" . $homework->id);
    }

    public function newHomeworkAction() {
        $user = $this->getUserBySession();
        $template = $user->getController() . "/homework/new";

        $this->view->classes = ClassListService::getClassesByUser($user);
        $this->view->pick($template);
    }

    public function editAction($homeworkId) {
        if(!Authenticate::getUser()->isStudent()) {
            return $this->response->redirect("dashboard");
        }

        $homework = Homework::findFirstById($homeworkId);
        $this->getUserBySession();

        if (!$homework) { echo "error"; }
        $this->view->homework = $homework;
    }

    public function updateAction() {
        $homeworkId = $this->request->getPost("homework-id");
        $homework = Homework::findFirstById($homeworkId);
        if (!$homework) { echo "error"; }

        $homework->textEditor = $this->request->getPost("content-homework");
        if($homework->textEditor) {
            if ($homework->save()) {
                $this->flash->success("Homework updated.");
            } else {
                $this->flash->error("Homework was not updated.");
            }
        }

        $this->view->homework = $homework;
        return $this->response->redirect("student/homework/edit/" . $homework->id);
    }

    public function reviewAction($homeworkId) {
        if(!$this->isTeacher()) {
            return $this->response->redirect("dashboard");
        }

        $homework = Homework::findFirstById($homeworkId);
        $this->getUserBySession();

        if (!$homework) { echo "error"; }
        $this->view->homework = $homework;
    }

    public function reviewedAction($homeworkId) {
        if(!$this->isTeacher()) {
            return $this->response->redirect("dashboard");
        }

        $this->reviewHomework($homeworkId);
        $uri = "teacher/homework";
        return $this->response->redirect($uri);
    }

    public function reviewManyHomeworksAction() {
        if(!$this->isTeacher()) {
            return $this->response->redirect("dashboard");
        }

        $ids = $this->request->getPost("ids");

        foreach ($ids as $id) {
            $this->reviewHomework($id);
        }

        return $this->response->redirect("teacher/homework");
    }

    public function submitAction($homeworkId) {
        $homework = Homework::findFirstById($homeworkId);
        $this->getUserBySession();

        if (!$homework->files->count()) {
            $this->flash->error("Please upload a file before submit the homework");
            return $this->response->redirect("student/homework");
        }

        $homework->submittedDate = date("Y-m-d");
        $homework->status = Homework::$SUBMITTED;

        if($homework->save()) {
            $this->flash->success("The homework was submitted.");
        } else {
            $this->flash->error("The homework was not submitted.");
            $this->appendErrorMessages($homework->getMessages());
        }

        return $this->response->redirect("student/homework");
    }

    public function createHomeworkByStudentAction() {
        $user = $this->getUserBySession();
        $classListId = $this->request->getPost("classList-id");
        $classList = ClassList::findFirstById($classListId);
        $homework = HomeworkService::create($user,
            $classList, $this->request->getPost());

        if (!$homework->save()) {
            $this->flash->error("Was not possible to create the homework");
            $this->appendErrorMessages($homework->getMessages());
        } else {
            $this->flash->success("The homework was created");
        }

        return $this->response->redirect("student/homework?filter=0");
    }

    public function uploadFileAction() {
        $homeworkId = $this->request->getPost("homework-id");
        $description = $this->request->getPost("description");

        if ($this->request->hasFiles() == true) {
            foreach ($this->request->getUploadedFiles() as $file){
                $homeworkFile = HomeworkService::createFile($homeworkId,
                    $file, $description);

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

        return $this->dispatcher->forward(array("action" => "edit",
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

        return $this->dispatcher->forward(array("action" => "edit",
            "params" => array("homeworkId" => $homeworkId)));
    }

    private function reviewHomework($homeworkId) {
        if(!$this->isTeacher()) {
            return $this->response->redirect("dashboard");
        }

        $homework = Homework::findFirstById($homeworkId);
        $this->getUserBySession();
        $homework->reviewedDate = date("Y-m-d");
        $homework->status = Homework::$REVIEWED;

        if (!$homework->save()) {
            $this->flash->error("Error to review the homework");
        } else {
            $this->flash->success("Homework was reviewed.");
        }

        return $homework;
    }

    private function isTeacher() {
        if (Authenticate::getUser()->isTeacher()) {
            return true;
        }

        return false;
    }
}