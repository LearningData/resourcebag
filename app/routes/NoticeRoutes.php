<?php

class NoticeRoutes extends Phalcon\Mvc\Router\Group {
    public function initialize() {
        /* NOTICEBOARD */
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