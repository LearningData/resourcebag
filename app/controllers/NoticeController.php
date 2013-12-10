<?php

class NoticeController extends ControllerBase {
    public function indexAction(){
        $this->view->t = Translation::get(Language::get(), "notice");
        $this->view->notices = $this->getNotices();
        $user = Authenticate::getUser();

        if(!$user->isStudent()) {
            $this->view->myNotices = NoticeBoard::findByUploadedBy($user->id);
        }
    }

    public function showAction($noticeId) {
        $this->view->t = Translation::get(Language::get(), "notice");
        $notice = NoticeBoard::findFirstById($noticeId);

        $this->view->notice = $notice;
    }

    public function jsonNoticesAction() {
        $notices = $this->getNotices();
        $json = array();

        if($notices) {
            foreach($notices as $notice) {
                $json []= array("id" => $notice->id, "date" => $notice->date,
                    "text" => $notice->text, "title" => $notice->title,
                    "category" => $notice->category);
            }
        }

        header('Content-Type: application/json');
        $response = new Phalcon\Http\Response();
        $content = array('status' => 'success', 'notices' => $json);
        $response->setJsonContent($content);

        return $response;
    }

    public function newAction() {
        $this->view->t = Translation::get(Language::get(), "notice");
        $user = $this->getUserBySession();
        $this->setTokenValues();

        if ($user->isStudent()) { $this->response->redirect("notice/index"); }

        $classes = ClassListService::getClassesByUser($user);
        $this->view->categories = NoticeBoard::getCategories();
        $this->view->classes = $classes;
        $this->view->expiryDate = date('Y-m-d', strtotime("+2 month"));
    }

    public function editAction($noticeId) {
        $this->view->t = Translation::get(Language::get(), "notice");
        $user = $this->getUserBySession();
        $this->setTokenValues();

        if ($user->isStudent()) { $this->response->redirect("student/noticeboard"); }


        $classes = ClassListService::getClassesByUser($user);
        $this->view->classes = $classes;
        $this->view->categories = NoticeBoard::getCategories();
        $this->view->types = array("A" => "Teachers/Students",
             "P" => "Students", "T" => "Teachers");

        $notice  = NoticeBoard::findFirstById($noticeId);
        $this->view->notice = $notice;

        $this->tag->setDefault("notice", $notice->text);
        $this->tag->setDefault("title", $notice->title);
        $this->tag->setDefault("category", $notice->category);
        $this->tag->setDefault("class-id", $notice->classId);
        $this->tag->setDefault("notice-id", $notice->id);
    }

    public function updateAction() {
        if($this->isValidPost()) {
            $user = $this->getUserBySession();
            $noticeId = $this->request->getPost("notice-id");
            $notice = NoticeBoard::findFirstById($noticeId);
            $this->view->t = Translation::get(Language::get(), "notice");

            $notice->text = $this->request->getPost("notice");
            $notice->userType = $this->request->getPost("type");
            $notice->title = $this->request->getPost("title");
            $notice->category = $this->request->getPost("category");
            $notice->classId = $this->request->getPost("class-id");

            if($notice->save()) {
                $this->flash->success($this->view->t->_("notice-updated"));
            } else {
                $this->appendErrorMessages($notice->getMessages());
            }

            $this->response->redirect($user->getController() . "/noticeboard");
        }
    }

    public function createAction() {
        if($this->isValidPost()){
            $user = $this->getUserBySession();

            $notice = new NoticeBoard();
            $notice->date = $this->request->getPost("date");
            $notice->text = $this->request->getPost("notice");
            $notice->userType = $this->request->getPost("type");
            $notice->title = $this->request->getPost("title");
            $notice->category = $this->request->getPost("category");
            $notice->schoolId = $user->schoolId;
            $notice->uploadedBy = $user->id;

            if($this->request->getPost("expiryDate")) {
                $notice->expiryDate = $this->request->getPost("expiryDate");
            } else {
                $notice->expiryDate = date('Y-m-d', strtotime("+2 month"));
            }

            $t = Translation::get(Language::get(), "notice");


            if($notice->save()) {
                foreach ($this->request->getPost("class-id") as $classId) {
                    $noticeClass = new NoticeBoardClasses();
                    $noticeClass->classId = $classId;
                    $noticeClass->noticeId = $notice->id;
                    $noticeClass->schoolId = $user->schoolId;
                    $noticeClass->save();
                }

                foreach ($this->request->getUploadedFiles() as $file){
                    $noticeFile = new NoticeBoardFile();
                    $noticeFile->originalName = $file->getName();
                    $noticeFile->name = $file->getName();
                    $noticeFile->size = $file->getSize();
                    $noticeFile->type = $file->getType();
                    $noticeFile->file = file_get_contents($file->getTempName());
                    $noticeFile->noticeId = $notice->id;

                    $this->uploadFile($notice->id, $file);
                }
            } else {
                foreach ($notice->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->dispatcher->forward(array("action" => "index"));
            }

            $this->flash->success($t->_("notice-created"));
            // return $this->dispatcher->forward(array("action" => "index"));
            $this->response->redirect("teacher/noticeboard");
        }
    }

    public function removeAction($noticeId) {
        $user = Authenticate::getUser();
        $notice = NoticeBoard::findFirstById($noticeId);

        if($notice != null && $user->id == $notice->uploadedBy) {
            if($notice->delete()) {
                $this->flash->success($t->_("notice-deleted"));
            }
        }

        $this->response->redirect("teacher/noticeboard");
    }

    private function uploadFile($noticeId, $file) {
        $noticeFile = new NoticeBoardFile();
        $noticeFile->originalName = $file->getName();
        $noticeFile->name = $file->getName();
        $noticeFile->size = $file->getSize();
        $noticeFile->type = $file->getType();
        $noticeFile->file = file_get_contents($file->getTempName());
        $noticeFile->noticeId = $noticeId;

        return $noticeFile->save();
    }

    private function getNotices() {
        $user = $this->getUserBySession();

        if($user->isStudent()) {
            return NoticeBoard::getStudentNotices($user);
        }

        if($user->isSchool()) {
            $query = "schoolId = ?1 order by date desc";
            $params = array($query, "bind" => array(1 => $user->schoolId));

            return NoticeBoard::find($params);
        }

        if($user->isTeacher()) {
            return NoticeBoard::getTeacherNotices($user);
        }
    }
}

