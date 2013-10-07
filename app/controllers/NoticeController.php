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

    public function createAction() {
        $user = $this->getUserBySession();

        $notice = new NoticeBoard();
        $notice->date = date("Y-m-d");
        $notice->text = $this->request->getPost("notice");
        $notice->userType = $this->request->getPost("type");
        $notice->schoolId = $user->schoolId;
        $notice->uploadedBy = $user->id;

        if($notice->save()) {
            $this->flash->success("The notice was saved");
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

