<?php

namespace App\Authentication;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\Twig;

class Middleware {

    private $authenticator;
    private $router;
    private $view;

    public function __construct(Authenticator $authenticator, Router $router, Twig $view)
    {
        $this->authenticator = $authenticator;
        $this->router = $router;
        $this->view = $view;
        return;
    }

    public function auth(Request $request, Response $response, callable $next)
    {

        $auth = $this->authenticator;
        $role = $this->getRole($auth->getIdentity());
        $hasIdentity = $auth->hasIdentity();
        $identity = $auth->getIdentity();

//        $data = array(
//            'hasIdentity' => $hasIdentity,
//            'role' => $role,
//            'identity' => $identity
//        );

        if (!$hasIdentity) {
            //throw new HttpUnauthorizedException();
            $_SESSION['urlRedirect'] = (string) $request->getUri();
            //$app->flash('error', 'Login required');
            return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('login'));

        }

        /* Everything ok, call next middleware. */
        $response = $next($request, $response);
        return $response;
    }

    public function addViewData(Request $request, Response $response, callable $next)
    {
        $auth = $this->authenticator;
        $role = $this->getRole($auth->getIdentity());
        $identity = $auth->getIdentity();
        $hasIdentity = $auth->hasIdentity();
        $data = array(
            'hasIdentity' => $hasIdentity,
            'role' => $role,
            'identity' => $identity
        );

        // inject data into view object
        /** @var \Twig_Environment $twig_environment */
        foreach ($data as $key => $value) {
            $this->view->offsetSet($key,$value);
        }

        $response = $next($request, $response);
        return $response;
    }
    /**
     * Gets role from user's identity.
     *
     * @param mixed $identity User's identity. If null, returns role 'guest'
     *
     * @return string User's role
     */
    private function getRole($identity = null)
    {
        $role = null;
        if (is_object($identity)) {
            $role = empty($identity->getRole())? 'user': $identity->getRole();
        }
        if (is_array($identity)){
            $role = 'User';
        }
        if (is_array($identity) && isset($identity['role'])) {
            $role = $identity['role'];
        }
        if (empty($role)) {
            $role = 'guest';
        }
        return $role;
    }
}