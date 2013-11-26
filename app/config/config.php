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
    )
));
