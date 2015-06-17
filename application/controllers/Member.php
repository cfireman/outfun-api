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

        $type = isset($req['type']) ? $req['type'] : 'username';
        //验证参数是否合法
        if(!Util_Valid::existParams($req, array('username', 'password'))){
            Msg::Err('1000', Util_Valid::$msg['existParams']);
        }
        if(!Util_Valid::minLength($req, array('username' => 5, 'password' => 6))){
            Msg::Err('1000', Util_Valid::$msg['minLength']);
        }
        if($type == 'phone' && !Util_Valid::phoneNumber($req['username'])){
            Msg::Err('1000', Util_Valid::$msg['phoneNumber']);
        }

        $member = MemberModel::create()->getFirst(array($type => $req['username']));
        if($member){
            Msg::Err('400', $req['username'].':此帐号已存在！');
        }

        $salt = $salt = substr(str_shuffle(uniqid()),0, 8);
        $data = array(
            $type       => $req['username'],
            'password'  => md5($salt.$req['password'].$salt),
            'salt'      => $salt,
            'add_time'  => time(),
        );
        $res = MemberModel::create()->add($data);
        if(!$res){
            Msg::Err('400', '注册失败！');
        }

        Msg::Succ(array(), 200, '注册成功');
    }

    public function loginAction(){
        $req = $this->body;

        //验证参数是否合法
        if(!Util_Valid::existParams($req, array('phone', 'password'))){
            Msg::Err('1000', Util_Valid::$msg['existParams']);
        }
        if(!Util_Valid::minLength($req, array('phone' => 5, 'password' => 6))){
            Msg::Err('1000', Util_Valid::$msg['minLength']);
        }
        if(!Util_Valid::phoneNumber($req['phone'])){
            Msg::Err('1000', Util_Valid::$msg['phoneNumber']);
        }

        $member = MemberModel::create()->getFirst(array('phone' => $req['phone']));
        if(!$member){
            Msg::Err('400', $req['phone'].':此帐号不存在！');
        }
        if(Util_Common::pwdEncode($req['password'], $member['salt']) != $member['password']){
            Msg::Err('400', '密码错误！');
        }
        MemberModel::create()->addLastLogin($member['id']);

        Msg::Succ(array(), 200, '登录成功');
    }

    public function getListAction(){
        $req = $this->body;

        !isset($req['size']) && $req['size'] = 20;
        !isset($req['page']) && $req['page'] = 1;

        $where = array();
        $order = array('add_time' => 'desc');
        $limit = (($req['page'] - 1) * $req['size']) . ',' . $req['size'];
        $members = MemberModel::create()->getList($where, $order, $limit);
        if(!$members){
            Msg::Err('400', '获取数据失败');
        }
        $total = MemberModel::create()->total($where);

        $data = array(
            'list' => $members,
            'pagination' => array(
                'size' => $req['size'],
                'page' => $req['page'],
                'total' => $total,
            ),
        );
        Msg::Succ($data);
    }

    public function getDetailAction(){
        $req = $this->body;

        //验证参数是否合法
        if(!Util_Valid::existParams($req, array('id', 'username', 'phone'), false)){
            Msg::Err('1000', Util_Valid::$msg['existParams']);
        }

        $where = array();
        isset($req['id']) && $where['id'] = $req['id'];
        isset($req['username']) && $where['username'] = $req['username'];
        isset($req['phone']) && $where['phone'] = $req['phone'];
        $member = MemberModel::create()->getFirst($where);

        Msg::Succ($member);
    }

    public function updateAction(){
        $req = $this->body;

        //验证参数是否合法
        if(!Util_Valid::existParams($req, array('id', 'username', 'phone'), false)){
            Msg::Err('1000', Util_Valid::$msg['existParams']);
        }

        Msg::Succ();
    }

    public function delAction(){
        $req = $this->body;

        //验证参数是否合法
        if(!Util_Valid::existParams($req, array('id', 'username', 'phone'), false)){
            Msg::Err('1000', Util_Valid::$msg['existParams']);
        }

        $where = array();
        isset($req['id']) && $where['id'] = $req['id'];
        isset($req['username']) && $where['username'] = $req['username'];
        isset($req['phone']) && $where['phone'] = $req['phone'];
        $member = MemberModel::create()->getFirst($where);
        if(!$member || $member['delete_time']){
            Msg::Err('400', '用户不存在或已删除！');
        }
        $res = MemberModel::create()->update(array('delete_time' => time()), $where);
        if(!$res){
            Msg::Err('400', '删除失败！');
        }

        Msg::Succ(array(), 200, '删除成功');
    }
}