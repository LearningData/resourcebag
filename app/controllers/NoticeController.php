<?php

class NoticeController extends ControllerBase {
    public function indexAction(){
        $user = $this->getUserBySession();
        $param = "schoolId = " . $user->schoolId;
        if($user->isStudent()) { $param .= " and userType = 'P'"; }

        $this->view->query = $param;
        $this->view->notices = NoticeBoard::find($param);
    }

    public function newAction() {
        $user = $this->getUserBySession();
    }
}

