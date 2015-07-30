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

final class ProfileAction
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

        //grab identity id.
        $id=$this->authenticator->getIdentity();
        $user = R::findOne('users',' name = :username ',['username'=>$id['name']]);
        $this->view->render($response, 'profile.twig',$user->export());
        return $response;
    }

    public function editUser(Request $request, Response $response, Array $args)
    {
        $username = strtolower($args['username']);
        if(empty($username)){
            $this->flash->addMessage('flash','No user specified');
            return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('profile'));
        }
        $id=$this->authenticator->getIdentity();
        // restrict access to own profile or Admin user
        if($username!=strtolower($id['name'])){
            if(strtolower($id['name'])!='admin'){
                $this->flash->addMessage('flash','Access Denied');
                return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('profile'));
            }
        }
        if($username!='new'){
            $user = R::findOrCreate('users', [
                'name' => $username
            ]);
        } else {
            $user = R::dispense('users');
        }
        if ($request->isPost()) {
            $data = $request->getParams();
            //$username = $request->getParam('username');
            $user->import($data,'fullname,shortdial,longdial,colour,mobile,home');
            $user->name = $request->getParam('username');
            $password = $request->getParam('password');
            if(!empty($password)){
                $pass = password_hash($password, PASSWORD_DEFAULT);
                $user->hash = $pass;
            }

            $id = R::store($user);
            $this->flash->addMessage('flash',"$user->name updated");
            return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('edituser',['username'=>$username]));
//            $member = 'INSERT INTO `users` (`name`, `fullname`, `password`, `hash`, `colour`, `shortdial`, `longdial`, `mobile`, `home`, `ins_mf`, `ins_win`, `health_mf`, `health_win`, `life_mf`, `life_win`, `wealth_mf`, `wealth_win`, `uk_shift`, `atss`) VALUES '
//                . "($username, $fullname, :pass, '', 'FAD2F5', $shortdial, $longdial, '', '', '1', '0', '0', '1', '0', '0', '0', '1', '0', '0');
//                ";
        }
        $this->view->render($response, 'user.twig',$user->export());
        return $response;

    }
}
