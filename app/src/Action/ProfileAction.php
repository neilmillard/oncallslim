<?php
namespace App\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\Twig;
use Monolog\Logger;

final class ProfileAction
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

    public function dispatch(Request $request, Response $response, Array $args)
    {
        $this->logger->info("Profile page action dispatched");


        $this->view->render($response, 'profile.twig');
        return $response;
    }

    public function addUser(Request $request, Response $response, Array $args)
    {
        if ($request->isPost()) {
            $username = $request->getParam('username');
            $password = $request->getParam('password');
            $fullname = $request->getParam('fullname');
            $shortdial = $request->getParam('shortdial');
            $longdial = $request->getParam('longdial');
            $pass = password_hash($password, PASSWORD_DEFAULT);
            /**
             * PDO example of creating a user
             */
            $dsn = "";
            $db = new \PDO($dsn);
            $member = 'INSERT INTO `users` (`name`, `fullname`, `password`, `hash`, `colour`, `shortdial`, `longdial`, `mobile`, `home`, `ins_mf`, `ins_win`, `health_mf`, `health_win`, `life_mf`, `life_win`, `wealth_mf`, `wealth_win`, `uk_shift`, `atss`) VALUES '
                . "($username, $fullname, :pass, '', 'FAD2F5', $shortdial, $longdial, '', '', '1', '0', '0', '1', '0', '0', '0', '1', '0', '0');
                ";
            $member = $db->prepare($member);
            $member->execute(array('pass' => $pass));

        }

    }
}
