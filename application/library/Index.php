<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-5-7
 * Time: 下午5:20
 */

class IndexController extends Yaf_Controller_Abstract {
    public function indexAction() {//默认Action
        echo '默认action';die;
        $this->getView()->assign("content", "Hello World");
    }
}