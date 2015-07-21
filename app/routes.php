<?php
// Routes

$app->get('/', 'App\Action\HomeAction:dispatch')
    ->setName('homepage');

$app->get('/oncall/{rota}[/{display:\d+}]', 'App\Action\OncallAction:dispatch')
    ->setName('oncall');

/** @noinspection PhpUndefinedMethodInspection */
$app->get('/change/{rota}', 'App\Action\OncallAction:change')
    ->setName('change')
    ->add('Authenticator\Middleware:auth');

/** @noinspection PhpUndefinedMethodInspection */
$app->get('/profile', 'App\Action\ProfileAction:dispatch')
    ->setName('profile')
    ->add('Authenticator\Middleware:auth');

/** @noinspection PhpUndefinedMethodInspection */
$app->map(['GET','POST'],'/edituser/{username}', 'App\Action\ProfileAction:edituser')
    ->setName('edituser')
    ->add('Authenticator\Middleware:auth');

/** @noinspection PhpUndefinedMethodInspection */
$app->get('/rotas', 'App\Action\RotaAction:dispatch')
    ->setName('rotas')
    ->add('Authenticator\Middleware:auth');

/** @noinspection PhpUndefinedMethodInspection */
$app->map(['GET','POST'],'/editrota/{name}', 'App\Action\RotaAction:editRota')
    ->setName('editrota')
    ->add('Authenticator\Middleware:auth');

/** @noinspection PhpUndefinedMethodInspection */
$app->get('/deleterota/{name}', 'App\Action\RotaAction:deleteRota')
    ->add('Authenticator\Middleware:auth');

/** @noinspection PhpUndefinedMethodInspection */
$app->get('/admin', 'App\Action\AdminAction:dispatch')
    ->setName('admin')
    ->add('Authenticator\Middleware:auth');

/** @noinspection PhpUndefinedMethodInspection */
$app->get('/users', 'App\Action\UserAction:dispatch')
    ->setName('users')
    ->add('Authenticator\Middleware:auth');


$app->map(['GET', 'POST'], '/login', 'App\Action\LoginAction:login')
    ->setName('login');

$app->get('/logout', 'App\Action\LoginAction:logout')
    ->setName('logout');
