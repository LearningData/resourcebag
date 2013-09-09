<?php
use Phalcon\DI, Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View;

$config = new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => 'LD46marmita',
        'dbname'      => 'schoolbag_test',
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'libraryDir'     => __DIR__ . '/../../app/library/',
        'cacheDir'       => '/tmp/cache/',
        'baseUri'        => '/schoolbag/',
    )
));

ini_set('display_errors',1);
error_reporting(E_ALL);

define('ROOT_PATH', __DIR__);
define('PATH_LIBRARY', __DIR__ . '/../app/library/');
define('PATH_SERVICES', __DIR__ . '/../app/services/');
define('PATH_MODELS', __DIR__ . '/../app/models/');
define('PATH_CONTROLLERS', __DIR__ . '/../app/controllers/');
define('PATH_RESOURCES', __DIR__ . '/../app/resources/');

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

// required for phalcon/incubator
//include __DIR__ . "/../vendor/autoload.php";

// use the application autoloader to autoload the classes
// autoload the dependencies found in composer
$loader = new \Phalcon\Loader();

$loader->registerDirs(array(
    ROOT_PATH, PATH_CONTROLLERS
));

$loader->register();

$di = new FactoryDefault();
$di->set('db', function() use ($config){
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname
    ));
});

$di->set('view', function() use ($config) {
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    $view->registerEngines(array(
        '.volt' => function($view, $di) {
            $volt = new VoltEngine($view, $di);
            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
}, true);

DI::reset();

DI::setDefault($di);
?>