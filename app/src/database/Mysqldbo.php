<?php

namespace App\Database;


class Mysqldbo {

    public $dbo;
    private static $instance;

    public function __construct($dsn,$settings){
        //$settings = $c['settings']['database'];
//        $dsn = $settings['driver'] .
//            ':host=' . $settings['host'] .
//            ((!empty($settings['port'])) ? (';port=' . $settings['port']) : '') .
//            ';dbname=' . $settings['database'];
        $connection = new \PDO($dsn,$settings['username'],$settings['password']);
        //$connection = new mysqli($settings['host'], $settings['username'], $settings['password'], $settings['database']);
        $this->dbo = $connection;
        self::$instance = $this;
        return $connection;
    }

    public static function getInstance() {
        if (!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

}