<?php
require "../app/services/HomeworkService.php";

class HomeworkController extends ControllerBase {
    public function beforeExecuteRoute($dispatcher){
        $user = Authenticate::getUser();
        if(!$user) { return $this->response->redirect("index"); }
        $this->view->t = Translation::get(Language::get(), "homework");
    }

    public function indexAction() {
        $user = $this->getUserBySession();
        if(!$user) { return $this->response->redirect("index"); }

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
        $user = $this->getUserBySession();
        $currentPage = $this->request->getQuery("page", "int");
        $this->view->status = $this->request->get("filter");
        $group = $this->request->get("group");
        $template = "teacher/homework/list";

        $classList = ClassList::findFirstById($classId);

        if($user->isStudent()) {
            $homeworks = HomeworkService::getHomeworkByClass($user, $classId);
        } else {
            if($classList && $classList->teacherId == $user->id) {
                if($group && $group == "date") {
                    $homeworks = Homework::findByClassAndStatus($classId,
                        $this->view->status);

                    $template = "teacher/homework/listGrouped";
                } else {
                    $homeworks = Homework::findByClassAndStatus($classId,
                        $this->view->status);
                }
            } else {
                $homeworks = array();
            }
        }

        $this->view->page = HomeworkService::getPage($homeworks, $currentPage);
        $totalPages = $this->view->page->total_pages;
        $this->view->links = HomeworkService::getLinksByClass(
            $user->getController(),
            $classId,
            $totalPages, $this->view->status
        );
        $this->view->classId = $classId;

        $this->view->pick($template);
    }

    public function showAction($homeworkId) {
        $this->getUserBySession();
        $this->view->homework = HomeworkUser::findFirstById($homeworkId);
    }

    public function startAction($homeworkId) {
        $homework = HomeworkUser::findFirstById($homeworkId);
        $homework->status = Homework::$STARTED;
        $homework->save();

        return $this->response->redirect("student/homework/do/" . $homework->id);
    }

    public function newHomeworkAction() {
        $user = $this->getUserBySession();
        $template = $user->getController() . "/homework/new";

        $this->view->t = Translation::get(Language::get(), "homework");
        $this->view->classes = ClassListService::getClassesByUser($user);
        $this->view->pick($template);
    }

    public function doAction($homeworkId) {
        if(!Authenticate::getUser()->isStudent()) {
            return $this->response->redirect("dashboard");
        }

        $homework = HomeworkUser::findFirstById($homeworkId);
        $this->getUserBySession();

        if (!$homework) { echo "error"; }
        $this->view->homework = $homework;
    }

    public function updateAction() {
        $homeworkId = $this->request->getPost("homework-id");
        $homework = HomeworkUser::findFirstById($homeworkId);
        if (!$homework) { echo "error"; }

        $homework->text = $this->request->getPost("content-homework");
        if($homework->text) {
            if ($homework->save()) {
                $this->flash->success($this->view->t->_("homework-updated"));
            } else {
                $this->flash->error($this->view->t->_("homework-not-updated"));
            }
        }

        $this->view->homework = $homework;
        return $this->response->redirect("student/homework/do/" . $homework->id);
    }

    public function reviewAction($homeworkId) {
        if(!$this->isTeacher()) {
            return $this->response->redirect("dashboard");
        }

        $homework = HomeworkUser::findFirstById($homeworkId);
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
        $homework = HomeworkUser::findFirstById($homeworkId);
        $this->getUserBySession();

        if (!$homework->text && count($homework->files) == 0) {
            $this->flash->error($this->view->t->_("need-upload-or-text"));
            return $this->response->redirect("student/homework");
        }

        $homework->submittedDate = date("Y-m-d");
        $homework->status = Homework::$SUBMITTED;

        if($homework->save()) {
            $this->flash->success($this->view->t->_("homework-submitted"));
        } else {
            $this->flash->error($this->view->t->_("homework-not-submitted"));
            $this->appendErrorMessages($homework->getMessages());
        }

        return $this->response->redirect("student/homework");
    }

    public function createHomeworkByStudentAction() {
        $user = $this->getUserBySession();
        $classListId = $this->request->getPost("classList-id");
        $classList = ClassList::findFirstById($classListId);

        $homeworkInfo = HomeworkService::create($classList,
            $this->request->getPost(), $user->id);

        if (!$homeworkInfo->save()) {
            $this->flash->error($this->view->t->_("homework-not-created"));
            $this->appendErrorMessages($homeworkInfo->getMessages());
        } else {
            $homework = HomeworkService::createHomeworkUser($homeworkInfo->id,
                $user->id);

            if($homework->save()) {
                $this->flash->success($this->view->t->_("homework-created"));
            } else {
                $this->appendErrorMessages($homework->getMessages());
            }
        }

        return $this->response->redirect("student/homework?filter=0");
    }

    public function uploadFileAction() {
        $homeworkId = $this->request->getPost("homework-id");
        $description = $this->request->getPost("description");
        $t = Translation::get(Language::get(), "file");

        if ($this->request->hasFiles() == true) {
            foreach ($this->request->getUploadedFiles() as $file){
                $homeworkFile = HomeworkService::createFile($homeworkId,
                    $file, $description);

                if ($homeworkFile->save()) {
                    $this->flash->success($t->_("uploaded"));
                } else {
                    $this->flash->error($t->_("upload-error"));
                    foreach ($homeworkFile->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                }
            }
        }

        return $this->dispatcher->forward(array("action" => "do",
            "params" => array("homeworkId" => $homeworkId)));
    }

    public function removeFileAction($fileId) {
        $file = HomeworkFile::findFirstById($fileId);
        $homeworkId = $file->homeworkId;
        $t = Translation::get(Language::get(), "file");

        if ($file->delete()) {
            $this->flash->success($t->_("removed"));
        } else {
            $this->flash->error($t->_("not-removed"));
        }

        return $this->dispatcher->forward(array("action" => "do",
            "params" => array("homeworkId" => $homeworkId)));
    }

    private function reviewHomework($homeworkId) {
        if(!$this->isTeacher()) {
            return $this->response->redirect("dashboard");
        }

        $homework = HomeworkUser::findFirstById($homeworkId);
        $this->getUserBySession();
        $homework->reviewedDate = date("Y-m-d");
        $homework->status = Homework::$REVIEWED;

        if (!$homework->save()) {
            $this->flash->error($this->view->t->_("homework-not-reviewed"));
        } else {
            $this->flash->success($this->view->t->_("homework-reviewed"));
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