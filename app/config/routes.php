<?php
require __DIR__ ."/../routes/NoticeRoutes.php";
require __DIR__ ."/../routes/HomeworkRoutes.php";
require __DIR__ ."/../routes/UserRoutes.php";

$router = new Phalcon\Mvc\Router();
$router->mount(new NoticeRoutes());
$router->mount(new HomeworkRoutes());
$router->mount(new UserRoutes());


return $router;
?>
