<?php
// DIC configuration
/**
 * @var \Slim\Container $container
 */
$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$view = new \Slim\Views\Twig(
    $app->settings['view']['template_path'],
    $app->settings['view']['twig']
);
/**
 * @var \Twig_Environment $twig
 */
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

$container['dsn'] = function ($c) {
    $settings = $c['settings']['database'];
    $dsn = $settings['driver'] .
        ':host=' . $settings['host'] .
        ((!empty($settings['port'])) ? (';port=' . $settings['port']) : '') .
        ';dbname=' . $settings['database'];
    return $dsn;
};

R::setup($container['dsn'], $container['settings']['database']['username'], $container['settings']['database']['password'],TRUE);

// database mysqli connection
$container['database'] = function ($c) {
    $settings = $c['settings']['database'];
    $connection = new \App\Database\Mysqldbo($c['dsn'], $settings);
    //$connection = new mysqli($settings['host'], $settings['username'], $settings['password'], $settings['database']);
    return $connection;
};

// authentication
$container['authenticator'] = function ($c) {
    $settings = $c['settings']['authenticator'];
    $connection = $c['database'];
    $adapter = new \App\Authentication\Adapter\Db\EloAdapter(
        $connection,
        $settings['tablename'],
        $settings['usernamefield'],
        $settings['credentialfield']
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
    return new App\Action\LoginAction($c['view'], $c['logger'], $c['router'], $c['authenticator'], $c['flash']);
};
