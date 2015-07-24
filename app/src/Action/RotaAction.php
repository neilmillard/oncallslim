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

final class RotaAction
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
        $data = [];
        $rotas = R::findAll( 'rotas' );

        $this->view->render($response, 'rotas.twig',['rotas'=> $rotas]);
        return $response;
    }

    public function editRota(Request $request, Response $response, Array $args)
    {
        $id=$this->authenticator->getIdentity();
        if(strtolower($id['name'])!='admin'){
            $this->flash->addMessage('flash','Access Denied');
            return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('homepage'));
        }
        $name = $args['name'];
        if(empty($name)){
            $this->flash->addMessage('flash','No rota specified');
            return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('rotas'));
        }
        if($name!='new'){
            $rota = R::findOrCreate('rotas', [
                'name' => $name
            ]);
        } else {
            $rota = R::dispense('rotas');
        }
        if ($request->isPost()) {
            $data = $request->getParams();
            //$username = $request->getParam('username');
            $rota->import($data,'name,fullname,title,comment');
            $rota->sharedUsersList = [];
            foreach($data['users'] as $checkUserID){
                $rotaUser = R::load('users',$checkUserID);
                $rota->sharedUsersList[] = $rotaUser;
            }
            $id = R::store($rota);

            try{
                $fieldtest = R::inspect($rota->name);
            } catch( \Exception $e) {
                //thaw for creation
                R::freeze(['users']);
                $rotaUser = R::load('users',1);
                $rotaDay = R::findOrCreate($rota->name, [
                    'day' => 29,
                    'month' => 2,
                    'year' => 2015
                ]);
                $rotaUser = R::load('users',1);
                $rotaDay->name = $rotaUser;
                $rotaDay->who = $rotaUser;
                $rotaDay->stamp = date("Y-m-d H:i:s");
                R::store($rotaDay);
                R::freeze(true);
            }

            $this->flash->addMessage('flash',"$rota->name updated");
            return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('rotas'));
        }
        $userList = R::findAll('users');
        $data = $rota->export();
        $data['userList'] = $userList;
        $users = [];
        $userRota = $rota->sharedUsersList;
        foreach( $userRota as $userCheck){
            $users[$userCheck->id]='checked';
        }
        $data['userCheck']=$users;
        $this->view->render($response, 'rota.twig',$data);
        return $response;

    }

    public function deleteRota(Request $request, Response $response, Array $args)
    {
        $name = $args['name'];
        if(empty($name)){
            $this->flash->addMessage('flash','No rota specified');
            return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('rotas'));
        }
        $rota = R::findOne('rotas', ' name = ? ',[ $name ]);
        if(!empty($rota)){
            R::trash($rota);
            R::wipe($name);
            $this->flash->addMessage('flash',"$name deleted");
        } else {
            $this->flash->addMessage('flash',"$name Rota not found");
        }
        return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('rotas'));
    }
}
