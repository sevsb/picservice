<?php

include_once(dirname(__FILE__) . "/../config.php");
include_once(FRAMEWORK_PATH . "logging.php");
include_once(FRAMEWORK_PATH . "cache.php");
include_once(FRAMEWORK_PATH . "database.php");

class db_picservice extends database {
    private static $instance = null;
    
    public static function inst() {
        if (self::$instance == null)
            self::$instance = new db_picservice();
        return self::$instance;
    }

    private function __construct() {
        try {
            $this->init(MYSQL_DATABASE);
        } catch (PDOException $e) {
            logging::e("PDO.Exception", $e, false);
            die($e);
            // $this->init();
        }
    }
    
    private function create_table($name, $data) {
        $s = array();
        foreach ($data as $k => $v) {
            $s []= "$k $v";
        }
        $s = implode(", ", $s);
        $s = "id INT AUTO_INCREMENT PRIMARY KEY, $s";

        $query = "CREATE TABLE IF NOT EXISTS $name ($s) DEFAULT CHARSET utf8";
        // logging::d("Database", $query);
        $res = $this->exec($query);
        $res = str_replace("\n", " ", print_r($res, true));
        logging::d("Database", $res);
    }
    
    public function add_host($host, $code, $namespace) {
        $this->create_table(MYSQL_PREFIX . 'access',  array("host" => "TEXT", "code" => "TEXT", "token" => "TEXT", "expired" => "TEXT", "namespace" => "TEXT"));
        return $this->insert(MYSQL_PREFIX . 'access' , array("host" => $host, "code" => $code, "namespace" => $namespace));
    }
    
    public function get_access($table) {
        return $this->get_all_table($table);
    }
    
    public function get_all_prefix() {
        return $this->show_all_tables();
    }
    
    public function get_all_appservices() {
        return $this->get_all_table(MYSQL_PREFIX . 'access');
    }
    
    public function get_all_appserviceips () {
        $appservices = $this->get_all_appservices();
        $appservice_ips = array();
        foreach ($appservices as $appservice) {
            $ip = $appservice['host'];
            $ip = explode('//',$ip);
            $ip = $ip[1];
            $ip = explode('/', $ip);
            $ip = "http://" . $ip[0];
            array_push($appservice_ips,$ip);
        }
        return $appservice_ips;
    }
    
    
    public function update_token($host, $code, $token, $expired) {
        return $this->update(MYSQL_PREFIX . 'access', array("token" => $token, "expired" => $expired), "host = '$host' and code = '$code'");
    }
    
    public function auth_code($host, $code) {
        $count = $this->get_count(MYSQL_PREFIX .'access',"host = '$host' and code = '$code'");
        return $count ? true : false;
    }
    
    public function auth_token($token) {
        $ret = $this->get_one_table(MYSQL_PREFIX .'access',"token = '$token'");
        return $ret;
    }


    
};


