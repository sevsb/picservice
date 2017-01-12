<?php

include_once(dirname(__FILE__) . "/config.php");

function uploadImageViaFileReader($imgsrc = null,$upload_path = UPLOAD_DIR, $callback = null, $args = null) {
    $whitelist = array("image/jpeg", "image/pjpeg", "image/png", "image/x-png", "image/gif");

    if ($imgsrc == null) {
        $imgsrc = get_request_assert("imgsrc");
    } else if (substr($imgsrc, 0, 5) != "data:") {
        $imgsrc = get_request_assert($imgsrc);
    }

    // data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAIBAQIBAQICAgICAgIC…gAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA//Z
    $arr = explode(";", $imgsrc);
    if (count($arr) != 2) {
        return callback('fail', '数据错误');
    }

    $arr1 = explode(":", $arr[0]);
    if (count($arr1) != 2) {
        return callback('fail', '数据错误');
    }
    $type = $arr1[1];
    if (!in_array($type, $whitelist)) {
        return callback('fail', "不支持的文件格式: $type");
    }

    $type = explode('/', $type);
    $extension = $type[1];

    $arr = explode('base64,', $imgsrc);
    $image_content = base64_decode($arr[1]);

    if (!file_exists($upload_path)) {
        $ret = @mkdir($upload_path, 0777, true);
        if ($ret === false) {
            return callback('fail', '上传目录创建失败');
        }
    }

    $filename = md5($image_content) . ".$extension";

    $filepath = $upload_path . "/$filename";
    if (!file_put_contents($filepath, $image_content)) {
        return callback('fail', '创建文件失败');
    }
    return callback('success', $filename);
}

function callback($status, $info) {
    return array("status"=>$status, "info"=>$info);
}

