<?php
include_once(dirname(__FILE__) . "/../app/config.php");
include_once(dirname(__FILE__) . "/../app/picservice.class.php");

class picservice_controller {

    public function show_action() {
        picservice::load_access_allows();
        
        $token = get_request("token");
        $filename = get_request("filename");
        $refer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
        
        $ret = picservice::auth_token($token);
        $refer_host = explode('?',$refer);
        $refer_host = $refer_host[0];
        $img_path = UPLOAD_DIR . "/" . MYSQL_PREFIX . 'access/' .$ret["namespace"];
        $img_file = $img_path . "/" . $filename;
       
        if (!$ret) {
            echo 'token authorise failed';
            logging::e("token authorise failed:", $ret);
            return;
        }
        if ($refer_host != $ret['host']) {
            echo "http_referer failed";
            logging::e("http_referer failed ", $ret['host'] . "|" . $refer_host);
            return;
        }
        if (!file_exists($img_file)) {
            echo "img_show failed.file not existed";
            logging::e("img_show failed.file not existed:", $img_file);
            return;
        }
        
        header ('Content-Type: image/png');
        $c = file_get_contents($img_file);
        echo $c;
    }

    public function add_host_ajax() {
        $host = get_request('host');
        $namespace = get_request('namespace');
        $prefix = get_request('prefix');
        
        $ret = picservice::add_host($host, $namespace, $prefix);
        return $ret;
    }
    
    public function request_token_ajax() {
        picservice::load_access_allows();
        
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
        return $udate_token_ret ? array("ret"=> "success" ,'token' => $token, 'expired' => $expired) : array("ret"=> "fail" ,'reason' => "request_token_failed");
    }
    
    public function upload_image_ajax() {
        picservice::load_access_allows();
        
        $token = get_request('token');
        $img_src = get_request('img_src');

        $ret = picservice::auth_token($token);
        if (!$ret) {
            return array("status" => "fail","info" => 'token_fail');
        }
        
        $upload_path = UPLOAD_DIR . "/". MYSQL_PREFIX . "access/".$ret['namespace']."/";
        logging::e("upload_image_path:", $upload_path);
        $ret = uploadImageViaFileReader($img_src, $upload_path);
        logging::e("upload_image_ret:", $ret);
        return $ret;
    }

}













