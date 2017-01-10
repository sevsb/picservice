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
        return db_picservice::inst()->auth_code($host, $code);
    }
    
    public static function auth_token($token) {
        $ret = db_picservice::inst()->auth_token($token);
        logging::e("token_auth_ret:", $ret);
        if (empty($ret['namespace']) || (time() > $ret['expired'])) {
            return false;
        }
        return $ret;
    }

    public static function update_token($host, $code, $token, $expired) {
        return db_picservice::inst()->update_token($host, $code, $token, $expired);
    }
    
    
    
    
    
    
    
}



?>