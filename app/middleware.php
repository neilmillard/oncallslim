<?php
// Application middleware
// e.g: $app->add(new \Slim\Csrf\Guard);

$container['Authenticator\Middleware'] = function ($c) {
    return new \App\Authentication\Middleware($c['authenticator'],$c['router'],$c['view']);
};

$app->add( function (\Slim\Http\Request $request, \Slim\Http\Response $response, callable $next)use($container){
    /** @var Slim\Views\Twig $twig */
    $twig = $container['view'];
    /** @var Slim\Flash\Messages $flash */
    $flash = $container['flash'];
    $messages = $flash->getMessage('flash');
    $twig->offsetSet('flash',$messages);
    $response = $next($request,$response);

    return $response;
});

//authenticator to populate twig view
$app->add('Authenticator\Middleware:addViewData');

