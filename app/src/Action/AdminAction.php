<?php
namespace App\Action;

use App\Authentication\Authenticator;
use RedBeanPHP\R;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\Twig;
use Monolog\Logger;

final class AdminAction
{
    private $view;
    private $logger;
    private $router;
    private $flash;
    private $authenticator;

    public function __construct(Twig $view, Logger $logger, Router $router, Messages $flash,Authenticator $authenticator)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->router = $router;
        $this->flash = $flash;
        $this->authenticator = $authenticator;
    }

    public function dispatch(Request $request, Response $response, Array $args)
    {
        $this->logger->info("Profile page action dispatched");

        $this->view->render($response, 'admin.twig');
        return $response;
    }

}
