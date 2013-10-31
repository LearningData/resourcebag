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

        $this->add("/teacher/noticeboard/show/{noticeId}",
            array(
                "controller" => "notice",
                "action"     => "show"
            )
        );

        $this->add(
            "/student/noticeboard",
            array(
                "controller" => "notice",
                "action"     => "index"
            )
        );

        $this->add("/student/noticeboard/show/{noticeId}",
            array(
                "controller" => "notice",
                "action"     => "show"
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
        $this->add("/school/noticeboard/edit/{noticeId}",
            array(
                "controller" => "notice",
                "action"     => "edit"
            )
        );
        $this->add("/school/noticeboard/show/{noticeId}",
            array(
                "controller" => "notice",
                "action"     => "show"
            )
        );
    }
}
?>