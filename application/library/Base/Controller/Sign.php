<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-6-8
 * Time: 下午7:51
 */
class Base_Controller_Sign extends Base_Controller_Abstract{


    public function init(){

        if(!$this->validSign()){
            Msg::Err('400', 'sign验证失败');
        }
    }

    public function getSign(){

        return 'xxxxxxxxxxxx';
    }

    public function validSign(){

        return $this->body['sign'] != 'debugSign' && $this->body['sign'] == $this->getSign();
    }

}