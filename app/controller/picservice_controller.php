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

}













