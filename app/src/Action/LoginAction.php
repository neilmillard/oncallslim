<?php
namespace App\Action;

use App\Authentication\Authenticator;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\Twig;
use Monolog\Logger;

final class LoginAction
{
    private $view;
    private $logger;
    private $router;
    private $authenticator;

    public function __construct(Twig $view, Logger $logger, Router $router, Authenticator $authenticator)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->router = $router;
        $this->authenticator = $authenticator;
    }

    public function login(Request $request, Response $response, Array $args)
    {
        $this->logger->info("Login page action dispatched");
        $username = null;

        $urlRedirect = $this->router->pathFor('homepage');

        if ($request->getAttribute('r') && $request->getAttribute('r') != '/logout' && $request->getAttribute('r') != '/login') {
            $_SESSION['urlRedirect'] = $request->getAttribute('r');
        }

        if (isset($_SESSION['urlRedirect'])) {
            $urlRedirect = $_SESSION['urlRedirect'];
        }

        if ($request->isPost()) {
            $username = $request->getAttribute('username');
            $password = $request->getAttribute('password');

            $result = $this->authenticator->authenticate($username, $password);

            if ($result->isValid()){
                $response->withRedirect($urlRedirect);
            } else {
                $messages = $result->getMessages();
                // TODO: display messages in a flash object
            }
        }

        $this->view->render($response, 'login.twig',['username'=> $username]);
        return $response;
    }

    public function logout(Request $request, Response $response, Array $args)
    {
        $this->logger->info("Logout request action");
        $this->authenticator->clearIdentity();
        $response->withRedirect($this->router->pathFor('homepage'));
    }
}
