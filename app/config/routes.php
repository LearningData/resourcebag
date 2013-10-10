<?php
require __DIR__ ."/../routes/NoticeRoutes.php";
require __DIR__ ."/../routes/HomeworkRoutes.php";

$router = new Phalcon\Mvc\Router();
$router->mount(new NoticeRoutes());
$router->mount(new HomeworkRoutes());


return $router;
?>
