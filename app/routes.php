<?php
// Routes

$app->get('/', 'App\Action\HomeAction:dispatch')
    ->setName('homepage');

$app->get('/oncall/{rota}', 'App\Action\OncallAction:dispatch')
    ->setName('oncall');

$app->get('/profile', 'App\Action\ProfileAction:dispatch')
    ->setName('profile');

$app->map(['GET', 'POST'], '/login', 'App\Action\LoginAction:login')
    ->setName('login');

$app->get('/logout', 'App\Action\LoginAction:logout')
    ->setName('logout');
