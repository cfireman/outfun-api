<?php

die('this is outfun-api');

define("APP_PATH",  realpath(dirname(__FILE__) . '/../')); /* 指向public的上一级 */

try{
    $app  = new Yaf_Application(APP_PATH . "/conf/application.ini");
    $app->run();
}catch (Exception $ee){
    echo $ee->getMessage();
}