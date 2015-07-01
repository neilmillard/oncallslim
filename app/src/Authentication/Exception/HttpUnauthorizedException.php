<?php
/**
 * Created by PhpStorm.
 * User: neil millard
 * Date: 01/07/2015
 * Time: 15:21
 */

namespace App\Authentication\Exception;
/**
 * HTTP 401 Exception.
 */

class HttpUnauthorizedException extends AuthException{

    public function __construct()
    {
        $message = 'You must authenticate to access this resource.';
        $code = 401;
        parent::__construct($message, $code);
    }
}