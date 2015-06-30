<?php
// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$view = new \Slim\Views\Twig(
    $app->settings['view']['template_path'],
    $app->settings['view']['twig']
);
$twig = $view->getEnvironment();
$twig->addExtension(new Twig_Extension_Debug());
$container->register($view);

// Flash messages
$container->register(new \Slim\Flash\Messages);

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// monolog
$container['logger'] = function ($c) {
    $settings = $c['settings']['logger'];
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], \Monolog\Logger::DEBUG));
    return $logger;
};

// capsule database
$container['database'] = function ($c) {
    $settings = $c['settings']['database'];
    $capsule = new \Illuminate\Database\Capsule\Manager();
    $capsule->addConnection( $settings );
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};

$container['authenticator'] = function ($c) {
    $settings = $c['settings']['PDO'];
    $db= new \PDO($settings);
    $adapter = new \App\Authentication\Adapter\Db\PdoAdapter(
        $db,
        'users',
        'username',
        'hash',
        new \JeremyKendall\Password\PasswordValidator()
    );
    $authenticator = new \App\Authentication\Authenticator($adapter);
    return $authenticator;
};

// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------

$container['App\Action\HomeAction'] = function ($c) {
    return new App\Action\HomeAction($c['view'], $c['logger'], $c['router']);
};

$container['App\Action\OncallAction'] = function ($c) {
    return new App\Action\OncallAction($c['view'], $c['logger'], $c['router']);
};

$container['App\Action\ProfileAction'] = function ($c) {
    return new App\Action\ProfileAction($c['view'], $c['logger'], $c['router']);
};

$container['App\Action\LoginAction'] = function ($c) {
    return new App\Action\LoginAction($c['view'], $c['logger'], $c['router'], $c['authenticator']);
};