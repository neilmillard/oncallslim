<?php
namespace App\Action;

use Slim\Http\Request;
use Slim\Http\Response;
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

    public function dispatch(Request $request, Response $response, Array $args)
    {
        $this->logger->info("Oncall page action dispatched");
        $rota = strtolower($args['rota']);
        $display = isset($args['display'])?$args['display']:6;
        $prev = $request->getParam( 'prev',0 );
        $dis = 5;

        $title="";
        $comments="";
        switch($rota)
        {
            case "healthmf":
                $title = "Health and Insurance Mainframe Shared";
                break;
            case "healthwin":
                $title = "Health and Insurance Windows Apps";
                break;
            case "wealthmf":
                $title = "Wealth Mainframe Apps";
                break;

        }

        $months = [];
        $thismonth = date("n") - 1;
        $thisyear = date("Y");

        if ($thismonth <1) {
            $thismonth = $thismonth + 12;
            $thisyear = $thisyear - 1;
        }
        for($i = 1; $i < ($display + 1) ; $i++) {
            $thismonth++;
            if ($thismonth == 13) {
                $thismonth = 1;
                $thisyear++;
            }
            $months[$i] = $thisyear."-".$thismonth."-1";
        }
        $this->view->render($response, 'oncall.twig', [
            'rota'=>$rota,
            'title'=>$title,
            'comments'=>$comments,
            'months'=>$months
        ]);
        return $response;
    }
}
