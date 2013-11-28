<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => 'LD46marmita',
        'dbname'      => 'schoolbag',
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'servicesDir'      => __DIR__ . '/../../app/services/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'libraryDir'     => __DIR__ . '/../../app/library/',
        'filesDir'     => __DIR__ . '/../../public/files/',
        'cacheDir'       => '/tmp/cache',
        'baseUri'        => '/schoolbag/',
    ),
    'ldap' => array(
        'server' => 'ldap://127.0.0.1/',
        'user' => 'admin',
        'password' => 'LD46marmita',
        'dc1' => 'example',
        'dc2' => 'com',
        'userDomain' => "cn=admin,dc=example,dc=com",
        'pathLog' => "/tmp/ldap_synch.log"
    ),
    'microsoft' => array(
        'server' => 'Microsoft',
        'debug' => false,
        'debugHttp' => true,
        'scope' => 'wl.basic wl.emails',
        'api' => 'https://apis.live.net/v5.0/me',
        'clientId' => '000000004010EC5C',
        'clientSecret' => '1aiidbRFG8BYbHG-qeJwhJ3SAxbgqU2W'
    )
));
