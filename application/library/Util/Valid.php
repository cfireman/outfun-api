<?php
/**
 * 验证工具类
 * User: bee
 * Date: 15-6-12
 * Time: 上午11:20
 */
class Util_Valid {

    public static $msg = array();

    /**
     * 验证是否空串
     */
    public static function emptyStr($value){
        return $value === null || trim($value) === "";
    }

    /**
     * 检验数组中的键是否存在
     * @param array $input_params
     * @param array $required_params
     * @return bool
     * @throws Exception
     */
    public static function existParams($input_params = array(), $required_params = array()){
        if($required_params) {
            foreach($required_params as $param) {
                if(!array_key_exists($param,$input_params)) {
                    self::$msg['existParams'] = '缺少'.$param.'参数！';
                    return false;
                }
            }
            return true;
        }

        throw new Exception(__METHOD__ . ':参数传递错误');
    }

    /**
     * 验证最少字符数
     * @param string $input
     * @param null $required 当为数组时，格式为：array('username' => 5, 'password' => 6)
     * @return bool
     * @throws Exception
     */
    public static function minLength($input = '', $required = NULL){
        if(is_string($input)){
            return strlen($input) >= $required;
        }else if(is_array($input) && is_array($required)){
            $i = 0;
            foreach($input as $key => $val){
                if(array_key_exists($key,$required)){
                    $len = $required[$key];
                    if(strlen($val) < $len){
                        self::$msg['minLength'] = $key.'的长度不能少于'.$len.'个字符！';
                        return false;
                    }
                }
                $i++;
            }
            return true;
        }

        throw new Exception(__METHOD__ . ':参数传递错误');
    }
}