<?php
require __DIR__ ."/../routes/NoticeRoutes.php";
require __DIR__ ."/../routes/HomeworkRoutes.php";
require __DIR__ ."/../routes/UserRoutes.php";
require __DIR__ ."/../routes/CalendarRoutes.php";
require __DIR__ ."/../routes/PoliciesRoutes.php";

$router = new Phalcon\Mvc\Router();
$router->mount(new NoticeRoutes());
$router->mount(new HomeworkRoutes());
$router->mount(new UserRoutes());
$router->mount(new CalendarRoutes());
$router->mount(new PoliciesRoutes());


return $router;
?>
