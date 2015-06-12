<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-6-8
 * Time: 下午7:51
 */
class Base_Controller_Sign extends Base_Controller_Abstract{


    public function init(){


        if(!isset($this->body['sign'])){
            Msg::Err('400', '缺少参数sign');
        }
        if(!$this->validSign()){
            Msg::Err('400', 'sign验证失败');
        }
    }

    public function getSign(){
        $req = $this->body;

        ksort($req);
        unset($req['sign']);

        $device_key = 'cfireman';
        $str = $device_key;
        foreach($req as $k=>$v){
            if(!Util_Valid::emptyStr($v)){
                $str .=$k.$v;
            }
        }
        $m = strtoupper(md5($str));
        return $m;
    }

    public function validSign(){

        return $this->body['sign'] == 'debugSign' || $this->body['sign'] == $this->getSign();
    }

}