<?php

class NoticeRoutes extends Phalcon\Mvc\Router\Group {
    public function initialize() {
        $this->add("/teacher/noticeboard",
            array(
                "controller" => "notice",
                "action"     => "index"
            )
        );

        $this->add(
            "/teacher/noticeboard/new",
            array(
                "controller" => "notice",
                "action" => "new"
            )
        );

        $this->add("/teacher/noticeboard/edit/{noticeId}",
            array(
                "controller" => "notice",
                "action"     => "edit"
            )
        );

        $this->add(
            "/student/noticeboard",
            array(
                "controller" => "notice",
                "action"     => "index"
            )
        );


        $this->add(
            "/school/noticeboard",
            array(
                "controller" => "notice",
                "action"     => "index"
            )
        );

        $this->add(
            "/school/noticeboard/new",
            array(
                "controller" => "notice",
                "action"     => "new"
            )
        );
    }
}
?>