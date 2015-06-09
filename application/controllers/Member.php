<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-6-5
 * Time: 下午3:55
 */
class MemberController extends Base_Controller_Sign {

    public function addAction() {
//        $config = Yaf_Registry::get("config"); pp($config);
        pp(MemberModel::create()->get());

        Msg::Succ();
    }


    public function registerAction(){
        Msg::Succ();
    }

    public function loginAction(){
        Msg::Succ();
    }

    public function getAction(){
        $members = MemberModel::create()->get();

        Msg::Succ($members);
    }
}