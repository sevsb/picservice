<?php
include_once(dirname(__FILE__) . "/../app/config.php");
include_once(dirname(__FILE__) . "/../app/picservice.class.php");

class index_controller {

    public function index_action() {
        $tpl = new tpl("index/header", "index/footer");
        $all_tables = picservice::get_all_prefix();
        $tpl->set("all_tables", $all_tables);
        $tpl->display("index/index");
    }

}













