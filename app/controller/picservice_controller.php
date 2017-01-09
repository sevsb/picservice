<?php
include_once(dirname(__FILE__) . "/../app/config.php");
include_once(dirname(__FILE__) . "/../app/picservice.class.php");

class picservice_controller {

    public function add_ajax() {
        $host = get_request('host');
        $namespace = get_request('namespace');
        $prefix = get_request('prefix');
        $ret = picservice::add_host($host, $namespace, $prefix);
        return $ret;
    }
    
    public function request_token_ajax() {
        $host = get_request('host');
        $code = get_request('code');

        $auth_ret = picservice::auth_code($host, $code);
        logging::e("token auth_ret:", $auth_ret);
        if ($auth_ret) {
            $token = md5($host . $code);
            $expired = time() + EXPIRED_TIME;

            $udate_token_ret = picservice::update_token($host, $code, $token, $expired);
            logging::e("token refresh:", $token);
            logging::e("token udate_token_ret:", $udate_token_ret);
        }
        return $udate_token_ret ? array('token' => $token, 'expired' => $expired) : 'failed';
    }

}













