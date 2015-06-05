<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-6-5
 * Time: 下午5:01
 */
class Msg{

    /**
     * 请求正确
     * @param array $body
     * @param string $message
     * @param int $code
     */
    public static function Succ($body = array(), $code = 200, $message = 'succ'){
        exit(json_encode(array(
            'code'      => $code,
            'message'   => $message,
            'body'      => $body
        )));
    }

    /**
     * 请求错误
     * @param string $code
     * @param string $message
     */
    public static function Err($code = '400', $message = 'fail'){
        exit(json_encode(array(
            'code'      => $code,
            'message'   => $message,
        )));
    }
}