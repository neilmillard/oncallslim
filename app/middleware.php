<?php
// Application middleware
// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "path"  =>"/profile",
    "secure"    => false,
    "authenticator" => new \Slim\Middleware\HttpBasicAuthentication\PdoAuthenticator([

    ])
]));
