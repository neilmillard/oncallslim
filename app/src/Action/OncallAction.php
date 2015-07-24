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

final class OncallAction
{
    private $view;
    private $logger;
    private $router;
    private $authenticator;
    private $flash;

    public function __construct(Twig $view, Logger $logger, Router $router, Messages $flash, Authenticator $authenticator)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->router = $router;
        $this->flash = $flash;
        $this->authenticator = $authenticator;
    }

    public function dispatch(Request $request, Response $response, Array $args)
    {
        $this->logger->info("Oncall page action dispatched");
        $rota = strtolower($args['rota']);
        $display = isset($args['display']) ? $args['display'] : 6;
        $prev = $request->getParam('prev', 0);
        $dis = 5;
        $loggedIn = $this->authenticator->hasIdentity();
        $comments = "";
        $rotaBean = R::findOne('rotas',' name = :name ', [':name'=>$rota] );
        if(empty($rotaBean)){
            $this->flash->addMessage('flash',"sorry $rota not found");
            return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('homepage'));
        }
        $title = $rotaBean->title;

        $users = $rotaBean->sharedUsersList;

        $months = [];
        $colour = [];
        $data = [];
        if(!empty($prev)){
            $thisMonth = date("n") - 2;
        } else {
            $thisMonth = date("n") - 1;
        }
        $thisYear = date("Y");

        if ($thisMonth < 1) {
            $thisMonth = $thisMonth + 12;
            $thisYear = $thisYear - 1;
        }
        for ($i = 1; $i < ($display + 1); $i++) {
            $thisMonth++;
            if ($thisMonth == 13) {
                $thisMonth = 1;
                $thisYear++;
            }
            $months[$i] = $thisYear . "-" . $thisMonth . "-1";

            if ($loggedIn) {
                foreach (range(1, 31) as $dayCount) {
                    $data[$i][$dayCount] = "<a href=\"".$request->getUri()->getBaseUrl()."/change/$rota?day=$dayCount&month=$thisMonth&year=$thisYear&prev=$prev\">$dayCount</a>";
                }
            } else {
                $data[$i] = range(0, 31);
            }
            foreach (range(1, 31) as $dayCount) {
                $rotaDay = R::findOne($rota,' month = :month AND year = :year AND day = :day ', [':day' => $dayCount, ':month' => $thisMonth , ':year' => $thisYear] );
                if(!empty($rotaDay)){
                    $onCallUser = $rotaDay->fetchAs( 'users' )->name;
                    $colour[$i][$dayCount] = $onCallUser->colour; //"#6622" . ($dayCount + 10);
                } else {
                    $colour[$i][$dayCount] = "#fefefe";
                }

            }
        }

        $onCallNow = $this->getOnCallNow($rota);

        $this->view->render($response, 'oncall.twig', [
            'rota' => $rota,
            'title' => $title,
            'comments' => $comments,
            'months' => $months,
            'data' => $data,
            'colour' => $colour,
            'users' => $users,
            'formatDate' => date("l jS F Y,  g:ia"),
            'onCallNow' => $onCallNow
        ]);
        return $response;
    }

    public function change(Request $request, Response $response, Array $args)
    {
        $this->logger->info("Oncall Change page action dispatched");
        $rota = strtolower($args['rota']);
        $display = 6;
        $name = $request->getParam('name', '');
        $prev = $request->getParam('prev', 0);
        $day = $request->getParam('day');
        $month = $request->getParam('month');
        $monthObj = \DateTime::createFromFormat('!m', $month);
        $monthName = $monthObj->format('F');
        $year = $request->getParam('year');
        $title = "Please select who is oncall for - $day $monthName $year";
        if(!empty($name)) {
            $rotaUser = R::findOne('users',' name = :username ',['username'=>$name]);
            if(empty($rotaUser)){
                $this->flash->addMessage('flash',"$name not found");
                return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('oncall',['rota'=>$rota]));
            }
            $oldDay = (int) $day;
            $oldMonth = (int) $month;
            $oldYear = (int) $year;

            $whatDay = (8 - date('w', mktime(0, 0, 0, $oldMonth, $oldDay, $oldYear)));
            if (($whatDay == 8) || ($request->getParam('allweek') == null)) {
                $whatDay = 1;
            }
            for ($x = 0; $x < $whatDay; $x++) {
                $day = date('j', mktime(0, 0, 0, $oldMonth, ($oldDay + $x), $oldYear));
                $month = date('n', mktime(0, 0, 0, $oldMonth, ($oldDay + $x), $oldYear));
                $year = date('Y', mktime(0, 0, 0, $oldMonth, ($oldDay + $x), $oldYear));

                $rotaDay = R::findOrCreate($rota, [
                    'day' => $day,
                    'month' => $month,
                    'year' => $year
                ]);
                $rotaDay->name = $rotaUser;
                $id=$this->authenticator->getIdentity();
                $whoUser = R::load('users',$id['id']);
                $rotaDay->who = $whoUser;
                $rotaDay->stamp = date("Y-m-d H:i:s");
                R::store($rotaDay);
            }

            $this->flash->addMessage('flash',"Rota updated");
            return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('oncall',['rota'=>$rota]));
        }
        $rotaBean = R::findOne('rotas',' name = :name ', [':name'=>$rota] );
        if(empty($rotaBean)){
            $this->flash->addMessage('flash',"sorry $rota not found");
            return $response->withRedirect($request->getUri()->getBaseUrl().$this->router->pathFor('homepage'));
        }
        $userlist = [];
        $users = $rotaBean->sharedUsersList;
        foreach ($users as $user){
            $userlist[] = [
                'colour'=>$user['colour'],
                'linkday'=>'<a href="?name='.$user['name']."&day=$day&month=$month&year=$year\">".$user['fullname']."</a>",
                'linkweek'=>'<a href="?name='.$user['name']."&day=$day&month=$month&year=$year&allweek=Y\">".$user['fullname']."</a>"
            ];
        }



        $this->view->render($response, 'change.twig', [
            'rota' => $rota,
            'title' => $title,
            'userlist' => $userlist
        ]);

        return $response;

    }

    protected function getOnCallNow($rota)
    {
        $thisHour  = date('G');
        $nowDay    = date("j");
        $nowMonth  = date("n");
        $nowYear   = date("Y");
        $thisOnCall = 'Not set';

        $yesterday = new \DateTime();
        $yesterday->modify('-1 day');
        $day = $yesterday->format('j');
        $month = $yesterday->format('n');
        $year = $yesterday->format('Y');
        $lastOnCall = 'Not set';

        $rotaDay = R::findOne($rota,' month = :month AND year = :year AND day = :day ', [':day' => $nowDay, ':month' => $nowMonth , ':year' => $nowYear] );
        if(!empty($rotaDay)) {
            $thisOnCall = $rotaDay->fetchAs('users')->name->fullname;
        }
        $rotaYesterday = R::findOne($rota,' month = :month AND year = :year AND day = :day ', [':day' => $day, ':month' => $month , ':year' => $year] );
        if(!empty($rotaYesterday)) {
            $lastOnCall = $rotaDay->fetchAs('users')->name->fullname;
        }


        if ($thisOnCall == $lastOnCall) {
            $OncallNow = $thisOnCall;
        }else{
            if (8 > $thisHour){
                $OncallNow = $lastOnCall;
            }else{
                $OncallNow = $thisOnCall;
            }
        }

        return $OncallNow;
    }
}