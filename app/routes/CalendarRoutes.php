<?php

class CalendarRoutes extends Phalcon\Mvc\Router\Group {
    public function initialize() {
        $this->add(
            "/student/calendar",
            array(
                "controller" => "calendar",
                "action" => "index"
            )
        );

        $this->add(
            "/student/calendar/new",
            array(
                "controller" => "calendar",
                "action" => "new"
            )
        );

        $this->add(
            "/teacher/calendar",
            array(
                "controller" => "calendar",
                "action" => "index"
            )
        );

        $this->add(
            "/teacher/calendar/new",
            array(
                "controller" => "calendar",
                "action" => "new"
            )
        );
    }
}
?>
