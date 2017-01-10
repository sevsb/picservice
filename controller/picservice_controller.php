<?php
include_once(dirname(__FILE__) . "/../app/config.php");
include_once(dirname(__FILE__) . "/../app/picservice.class.php");

class picservice_controller {

    public function add_ajax() {
        $host = get_request('host');
        //$host = rtrim($host, '/') . '/';
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
            $token = md5($host . $code . time());
            $expired = time() + EXPIRED_TIME;

            $udate_token_ret = picservice::update_token($host, $code, $token, $expired);
            logging::e("token refresh:", $token);
            logging::e("token udate_token_ret:", $udate_token_ret);
        }
        return $udate_token_ret ? array('token' => $token, 'expired' => $expired) : 'failed';
    }
    
    public function upload_image_ajax() {
        $token = get_request('token');
        $img_src = get_request('img_src');

        $namespace = picservice::auth_token($token);
        if (!$namespace) {
            return 'token authorise failed';
        }
        
        $upload_path = UPLOAD_DIR . "/$namespace/";
        logging::e("upload_image_path:", $upload_path);
        $ret = uploadImageViaFileReader($img_src, $upload_path, 'callback', null);
        logging::e("upload_image_ret:", $ret);
        return $ret;
    }

}













