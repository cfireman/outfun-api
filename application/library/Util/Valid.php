<?php
/**
 * 验证工具类
 * User: bee
 * Date: 15-6-12
 * Time: 上午11:20
 */
class Util_Valid {

    /**
     * 验证是否空串
     */
    public static function isEmptyStr($value){
        return $value === null || trim($value) === "";
    }
}