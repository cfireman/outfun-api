<?php

function pp($d){
    echo '<pre>'; var_dump($d);die;
}

define("APP_PATH",  realpath(dirname(__FILE__) . '/../')); /* 指向public的上一级 */

try{
    $app  = new Yaf_Application(APP_PATH . "/conf/application.ini");
    $app->bootstrap()->run();
}catch (Exception $ee){
    echo $ee->getMessage();
}