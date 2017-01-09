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
    
    public function add_host($host, $code, $namespace ,$prefix) {
        $this->create_table($prefix . '_access',  array("host" => "TEXT", "code" => "TEXT", "token" => "TEXT", "expired" => "TEXT", "namespace" => "TEXT"));

        return $this->insert($prefix.'_access' , array("host" => $host, "code" => $code, "namespace" => $namespace));
    }
    
    public function get_access($table) {
        return $this->get_all_table($table);
    }
    
    public function get_all_prefix() {
        return $this->show_all_tables();
    }
    
    public function update_token($host, $code, $token, $expired) {
        return $this->update(MYSQL_PREFIX . 'access', array("token" => $token, "expired" => $expired), "host = '$host' and code = '$code'");
    }
    

    
};


