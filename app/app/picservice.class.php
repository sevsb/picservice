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
    
    
    
    
    
    
    
    
    
}



?>