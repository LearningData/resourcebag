<?php

class NoticeController extends ControllerBase {
    public function indexAction(){
        $this->view->notices = $this->getNotices();
    }

    public function showAction($noticeId) {
        $notice = NoticeBoard::findFirstById($noticeId);

        $this->view->notice = $notice;
    }

    public function jsonNoticesAction() {
        $notices = $this->getNotices();
        $json = array();

        foreach ($notices as $notice) {
            $json []= array("id" => $notice->id, "date" => $notice->date,
                "text" => $notice->text);
        }

        header('Content-Type: application/json');
        $response = new Phalcon\Http\Response();
        $content = array('status' => 'success', 'notices' => $json);
        $response->setJsonContent($content);

        return $response;
    }

    public function newAction() {
        $user = $this->getUserBySession();
        $this->setTokenValues();

        if ($user->isStudent()) { $this->response->redirect("notice/index"); }

        $classes = ClassListService::getClassesByUser($user);
        $this->view->classes = $classes;
    }

    public function editAction($noticeId) {
        $user = $this->getUserBySession();
        $this->setTokenValues();

        if ($user->isStudent()) { $this->response->redirect("student/noticeboard"); }


        $classes = ClassListService::getClassesByUser($user);
        $this->view->classes = $classes;
        $this->view->types = array("A" => "Teachers/Students",
             "P" => "Students", "T" => "Teachers");

        $notice  = NoticeBoard::findFirstById($noticeId);
        $this->view->notice = $notice;

        $this->tag->setDefault("notice", $notice->text);
        $this->tag->setDefault("class-id", $notice->classId);
        $this->tag->setDefault("notice-id", $notice->id);
    }

    public function updateAction() {
        if($this->isValidPost()) {
            $user = $this->getUserBySession();
            $noticeId = $this->request->getPost("notice-id");
            $notice = NoticeBoard::findFirstById($noticeId);

            $notice->text = $this->request->getPost("notice");
            $notice->userType = $this->request->getPost("type");
            $notice->classId = $this->request->getPost("class-id");

            if($notice->save()) {
                $this->flash->success("Notice was updated.");
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
            $notice->schoolId = $user->schoolId;
            $notice->uploadedBy = $user->id;

            if($this->request->getPost("class-id") != "") {
                $notice->classId = $this->request->getPost("class-id");
            }

            if($notice->save()) {
                foreach ($this->request->getUploadedFiles() as $file){
                    $noticeFile = new NoticeBoardFile();
                    $noticeFile->originalName = $file->getName();
                    $noticeFile->name = $file->getName();
                    $noticeFile->size = $file->getSize();
                    $noticeFile->type = $file->getType();
                    $noticeFile->file = file_get_contents($file->getTempName());
                    $noticeFile->noticeId = $notice->id;

                    if ($noticeFile->save()) {
                        $this->flash->success("The file was uploaded.");
                    } else {
                        $this->flash->error("The file was not uploaded.");
                        foreach ($noticeFile->getMessages() as $message) {
                            $this->flash->error($message);
                        }
                    }
                }
            } else {
                foreach ($notice->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }

            return $this->dispatcher->forward(array("action" => "index"));
        }
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

