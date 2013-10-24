<?php

class HomeworkRoutes extends Phalcon\Mvc\Router\Group {
    public function initialize() {
        $this->add(
            "/student/homework",
            array(
                "controller" => "homework",
                "action" => "index"
            )
        );

        $this->add(
            "/student/homework/show/{homeworkId}",
            array(
                "controller" => "homework",
                "action" => "show"
            )
        );

        $this->add(
            "/student/homework/edit/{homeworkId}",
            array(
                "controller" => "homework",
                "action"     => "edit"
            )
        );

        $this->add(
            "/student/homework/start/{homeworkId}",
            array(
                "controller" => "homework",
                "action"     => "start"
            )
        );

        $this->add(
            "/student/homework/submit/{homeworkId}",
            array(
                "controller" => "homework",
                "action"     => "submit"
            )
        );

        $this->add(
            "/teacher/homework",
            array(
                "controller" => "homework",
                "action"     => "index"
            )
        );

        $this->add(
            "/teacher/homework/class/{classId}",
            array(
                "controller" => "homework",
                "action"     => "listByClass"
            )
        );

        $this->add(
            "/teacher/homework/new/{classId}",
            array(
                "controller" => "teacher",
                "action"     => "newHomework"
            )
        );

        $this->add(
            "/teacher/homework/review/{homeworkId}",
            array(
                "controller" => "homework",
                "action"     => "review"
            )
        );

        $this->add(
            "/teacher/homework/show/{homeworkId}",
            array(
                "controller" => "homework",
                "action"     => "show"
            )
        );
    }
}
?>