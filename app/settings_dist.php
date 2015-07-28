<?php
return [

    // View settings
    'view' => [
        'template_path' => __DIR__ . '/templates',
        'twig' => [
            'cache' => __DIR__ . '/../cache/twig',
            'debug' => true,
            'auto_reload' => true,
        ],
    ],

    // monolog settings
    'logger' => [
        'name' => 'app',
        'path' => __DIR__ . '/../log/app.log',
    ],

    // database settings
    'database' => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'database',
        'username'  => 'username',
        'password'  => 'Pas5wrd',
        'charset'   => 'utf8',
        'collation' => 'utf8_general_ci',
        'prefix'    => '',
    ],

    // authentication settings
    'authenticator' => [
        'tablename' => 'users',
        'usernamefield' => 'name',
        'credentialfield' => 'hash'
    ]
];
