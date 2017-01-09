<?php
include_once(dirname(__FILE__) . "/config.php");

class picservice {
    
    public static function add_host ($host, $namespace, $prefix) {
        $code = md5(uniqid());
        $ret = db_picservice::inst()->add_host($host, $code, $namespace, $prefix);
        return $ret ? $code : false;
    }

    public static function get_all_prefix () {
        $ret = db_picservice::inst()->get_all_prefix();
        return $ret;
    }
    
    public static function get_access ($table) {
        $ret = db_picservice::inst()->get_access($table);
        return $ret;
    }
    
    public static function auth_code($host, $code) {
        $count = db_picservice::inst()->get_count(MYSQL_PREFIX .'access',"host = '$host' and code = '$code'");
        return $count ? true : false;
    }

    public static function update_token($host, $code, $token, $expired) {
        $ret = db_picservice::inst()->update_token($host, $code, $token, $expired);
        return $ret;
    }
    
    
    
    
    
    
    
}



?>