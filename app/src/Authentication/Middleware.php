<?php

namespace App\Authentication;

use App\Authentication\Exception\HttpUnauthorizedException;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

class Middleware {

    private $auth;
    private $router;

    public function __construct(Authenticator $authenticator, Router $router)
    {
        $this->auth= $authenticator;
        $this->router= $router;
        return;
    }

    public function auth(Request $request, Response $response, callable $next)
    {

        $auth = $this->auth;
        $role = $this->getRole($auth->getIdentity());
        $hasIdentity = $auth->hasIdentity();

        if (!$hasIdentity) {
            //throw new HttpUnauthorizedException();
            $_SESSION['urlRedirect'] = $request->getUri();
            //$app->flash('error', 'Login required');
            $response->withRedirect($this->router->pathFor('login'));

        }

        /* Everything ok, call next middleware. */
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
            $role = $identity->getRole();
        }
        if (is_array($identity) && isset($identity['role'])) {
            $role = $identity['role'];
        }
        if (!$role) {
            $role = 'guest';
        }
        return $role;
    }
}