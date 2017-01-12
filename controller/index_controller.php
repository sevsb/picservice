<?php
include_once(dirname(__FILE__) . "/../app/config.php");
include_once(dirname(__FILE__) . "/../app/picservice.class.php");

class index_controller {

    public function index_action() {
        $tpl = new tpl("index/header", "index/footer");
        $appservices = db_picservice::inst()->get_all_appservices();
        $tpl->set("appservices", $appservices);
        $tpl->display("index/index");
    }

}













