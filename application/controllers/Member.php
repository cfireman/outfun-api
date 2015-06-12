<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-6-5
 * Time: 下午3:55
 */
class MemberController extends Base_Controller_Sign {

//    public function addAction() {
//        $config = Yaf_Registry::get("config"); pp($config);
//        pp(MemberModel::create()->get());
//
//        Msg::Succ();
//    }


    public function registerAction(){
        $req = $this->body;

        //验证参数是否合法
        if(!Util_Valid::existParams($req, array('username', 'password'))){
            Msg::Err('400', Util_Valid::$msg['existParams']);
        }
        if(!Util_Valid::minLength($req, array('username' => 5, 'password' => 6))){
            Msg::Err('400', Util_Valid::$msg['minLength']);
        }

        $member = MemberModel::create()->getFirst(array('username' => $req['username']));
        if($member){
            Msg::Err('400', $req['username'].':此帐号已存在！');
        }

        $data = array(
            'username' => $req['username'],
            'password' => $req['password'],
            'add_time' => date('Y-m-d H:i:s'),
        );
        $res = MemberModel::create()->add($data);
        if(!$res){
            Msg::Err('400', '注册失败！');
        }

        Msg::Succ(array(), 200, '注册成功');
    }

    public function loginAction(){
        $req = $this->body;

        $lastLogin = MemberModel::create()->getLastLogin($req['username']);

        Msg::Succ($lastLogin);
    }

    public function getAction(){
        $members = MemberModel::create()->getList();

        Msg::Succ($members);
    }
}