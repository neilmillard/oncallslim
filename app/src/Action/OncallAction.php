<?php
namespace App\Action;

use Slim\Router;
use Slim\Views\Twig;
use Monolog\Logger;

final class OncallAction
{
    private $view;
    private $logger;
    private $router;

    public function __construct(Twig $view, Logger $logger, Router $router)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->router = $router;
    }

    public function dispatch($request, $response, $args)
    {
        $this->logger->info("Oncall page action dispatched");
        $rota = $args['rota'];

        $this->view->render($response, 'oncall.twig');
        return $response;
    }
}
