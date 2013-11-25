<?php

use Phalcon\DI\FactoryDefault\CLI as CliDI, Phalcon\CLI\Console as ConsoleApp;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

define('VERSION', '1.0.0');

$di = new CliDI();

defined('APPLICATION_PATH') ||
    define('APPLICATION_PATH', realpath(dirname(__FILE__)));

$loader = new \Phalcon\Loader();

if(is_readable(APPLICATION_PATH . '/../app/config/config.php')) {
 $config = include APPLICATION_PATH . '/../app/config/config.php';
 $di->set('config', $config);
}

$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->servicesDir,
        APPLICATION_PATH
    )
)->register();

$console = new ConsoleApp();

$di->set('db', function() use ($config) {
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname
    ));
});

$console->setDI($di);

$arguments = array();
$params = array();

foreach($argv as $k => $arg) {
 if($k == 1) {
     $arguments['task'] = $arg;
 } elseif($k == 2) {
     $arguments['action'] = $arg;
 } elseif($k >= 3) {
    $params[] = $arg;
 }
}
if(count($params) > 0) {
 $arguments['params'] = $params;
}

define('CURRENT_TASK', (isset($argv[1]) ? $argv[1] : null));
define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

try {
 $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
 echo $e->getMessage();
 exit(255);
}