<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-6-5
 * Time: 下午5:43
 */
class MemberModel extends Base_Model_Abstract{

    protected $member_last;

    public function __construct(){
        parent::__construct();
        $this->member_last = $this->prefix.'_member_last';
    }

    //这个为示例函数
//    public function getLastLogin($username){
//        $sql = "SELECT
//                    *
//                FROM
//                    outfun_member AS mem
//                JOIN outfun_member_last AS mla ON mem.id = mla.userid
//                WHERE
//                    mem.username = '$username'";
//
//        return $this->db->selectBySql($sql);
//    }

    public function addLastLogin($userid){
        $data = array(
            'userid' => $userid,
            'add_time' => time(),
        );
        return $this->db->insert($this->member_last, $data);
    }

//    public function getDetail($where){
//        $param = array();
//        $sql = "SELECT
//                    mem.*, mla.last_city,
//                    mla.last_province,
//                    mla.last_site,
//                    mla.`status`,
//                    mla.add_time AS login_time
//                FROM
//                    outfun_member AS mem
//                JOIN outfun_member_last AS mla ON mem.id = mla.userid"
//                .$where.
//                "ORDER BY
//                    mla.add_time DESC
//                LIMIT 1";
//
//        return $this->db->selectBySql($sql);
//    }

}