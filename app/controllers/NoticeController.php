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
    }

    private function getNotices() {
        $user = $this->getUserBySession();
        $param = "schoolId = " . $user->schoolId;
        if($user->isStudent()) { $param .= " and userType = 'P'"; }

        return NoticeBoard::find($param);
    }
}

