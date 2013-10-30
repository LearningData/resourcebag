<?php

class PoliciesRoutes extends Phalcon\Mvc\Router\Group {
    public function initialize() {
        $this->add(
            "/student/policies",
            array(
                "controller" => "policies",
                "action" => "index"
            )
        );

        $this->add(
            "/teacher/policies",
            array(
                "controller" => "policies",
                "action" => "index"
            )
        );

        $this->add(
            "/school/policies",
            array(
                "controller" => "policies",
                "action" => "index"
            )
        );
    }
}
?>