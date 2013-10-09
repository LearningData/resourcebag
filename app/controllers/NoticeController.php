<?php

class NoticeController extends ControllerBase {
    public function indexAction(){
        $this->view->notices = $this->getNotices();
    }

    public function jsonNoticesAction() {
        $notices = $this->getNotices();
        $json = array();

        foreach ($notices as $notice) {
            $json []= array("date" => $notice->date, "text" => $notice->text);
        }

        header('Content-Type: application/json');
        $response = new Phalcon\Http\Response();
        $content = array('status' => 'success', 'notices' => $json);
        $response->setJsonContent($content);

        return $response;
    }

    public function newAction() {
        $user = $this->getUserBySession();
        if ($user->isStudent()) { $this->response->redirect("notice/index"); }

        if($user->isTeacher()) {
            $classesList = ClassList::getClassesByTeacherId($user->id);
        } else {
            $classesList = ClassList::find("schoolId = " . $user->schoolId);
        }

        $classes = array();

        foreach ($classesList as $classList) {
            $classList->name = $classList->subject->name;
            $classes[$classList->id] = $classList->subject->name;
        }
        $this->view->classes = $classes;
    }

    public function editAction($noticeId) {
        $user = $this->getUserBySession();
        $classesList = ClassList::getClassesByTeacherId($user->id);
        $classes = array();

        foreach ($classesList as $classList) {
            $classes[$classList->id] = $classList->subject->name;
        }

        $this->view->classes = $classes;
        $this->views->types = array("T" => "T", "P" =>"P");
        $notice  = NoticeBoard::findFirstById($noticeId);

        $this->tag->setDefault("notice", $notice->text);
        $this->tag->setDefault("type", $notice->type);
        $this->tag->setDefault("class-id", $notice->classId);

        if ($user->isStudent()) { $this->response->redirect("student/notice/index"); }
    }

    public function createAction() {
        $user = $this->getUserBySession();

        $notice = new NoticeBoard();
        $notice->date = date("Y-m-d");
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

        return $this->dispatcher->forward(array("action" => "new"));
    }

    private function getNotices() {
        $user = $this->getUserBySession();
        $param = "schoolId = " . $user->schoolId;
        if($user->isStudent()) { $param .= " and userType = 'P'"; }

        return NoticeBoard::find($param);
    }
}

