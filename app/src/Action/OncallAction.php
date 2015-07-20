<?php
namespace App\Action;

use App\Authentication\Authenticator;
use RedBeanPHP\R;
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

    public function __construct(Twig $view, Logger $logger, Router $router, Authenticator $authenticator)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->router = $router;
        $this->authenticator = $authenticator;
    }

    public function dispatch(Request $request, Response $response, Array $args)
    {
        $this->logger->info("Oncall page action dispatched");
        $rota = strtolower($args['rota']);
        $display = isset($args['display']) ? $args['display'] : 6;
        $prev = $request->getParam('prev', 0);
        $dis = 5;
        //TODO check if logged in.
        $loggedIn = $this->authenticator->hasIdentity();
        $title = "";
        $comments = "";
        switch ($rota) {
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
        $colour = [];
        $data = [];
        $thisMonth = date("n") - 1;
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
                    $data[$i][$dayCount] = "<a href=\"/change/$rota?DAY=$dayCount&month=$thisMonth&year=$thisYear&prev=$prev\">$dayCount</a>";
                }
            } else {
                $data[$i] = range(0, 31);
            }
            //TODO grab rota from database
            // select user.colour, rota.name from rota,user where month=thismonth and year=thisyear and user.name = rota.name
            foreach (range(1, 31) as $dayCount) {
                $colour[$i][$dayCount] = "#6622" . ($dayCount + 10);
            }
        }
        // TODO get users array from database, fullname, colour, shortdial, longdial, mobile, home WHERE rota = 1
        $users = array(['fullname' => 'admin', 'colour' => '#893354', 'shortdial' => '7445652']);

        $this->view->render($response, 'oncall.twig', [
            'rota' => $rota,
            'title' => $title,
            'comments' => $comments,
            'months' => $months,
            'data' => $data,
            'colour' => $colour,
            'users' => $users
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
            $oldDay = $day;
            $oldMonth = $month;
            $oldYear = $year;

            $whatDay = (8 - date('w', mktime(0, 0, 0, $oldMonth, $oldDay, $oldYear)));
            if (($whatDay == 8) || ($request->getParam('allweek') == null)) {
                $whatDay = 1;
            }
            for ($x = 0; $x < $whatDay; $x++) {
                $day = date('j', mktime(0, 0, 0, $oldMonth, ($oldDay + $x), $oldYear));
                $month = date('n', mktime(0, 0, 0, $oldMonth, ($oldDay + $x), $oldYear));
                $year = date('Y', mktime(0, 0, 0, $oldMonth, ($oldDay + $x), $oldYear));

                $id = $this->authenticator->getIdentity();
                $loggedInName = $id['name'];
                $who = strtoupper($loggedInName);

                //TODO update or create database entry.
                // insert into $rota ($name,$day,$month,$year,now(),$who)
                $rotaDay = R::findOrCreate($rota, [
                    'day' => $day,
                    'month' => $month,
                    'year' => $year
                ]);
                $rotaDay->name = $name;
                $rotaDay->who = $who;
                $rotaDay->stamp = date("Y-m-d H:i:s");
                R::store($rotaDay);

            }
        }

        $userlist = [];
        // TODO get userlist from database for this $rota
        $user= ['name'=>'admin','fullname'=>'Administrator','colour'=>'#882245'];

        switch ($rota) {
            case "healthmf":
                $sql = "health_mf = 1";
                break;
            case "healthwin":
                $title = "health_win = 1";
                break;
            case "wealthmf":
                $title = "wealth_mf = 1";
                break;

        }

        $users = R::find('users', $sql );
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
}