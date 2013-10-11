<?php

class UserRoutes extends Phalcon\Mvc\Router\Group {
    public function initialize() {
        $this->add("/school/users/new",
            array(
                "controller" => "users",
                "action"     => "new"
            )
        );
    }
}
?>