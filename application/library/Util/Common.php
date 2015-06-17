<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-6-17
 * Time: 下午1:35
 */
class Util_Common{

    public static function pwdEncode($pwd, $salt){
        return md5($salt.$pwd.$salt);
    }

}