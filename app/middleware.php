<?php
// Application middleware
// e.g: $app->add(new \Slim\Csrf\Guard);

$container['Authenticator\Middleware'] = function ($c) {
    return new \App\Authentication\Middleware($c['authenticator'],$c['router'],$c['view']);
};

//authenticator to populate twig view
$app->add('Authenticator\Middleware:addViewData');

