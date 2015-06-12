<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-6-5
 * Time: 下午5:43
 */
class MemberModel extends Base_Model_Abstract{

//    普通的单表增删改查可直接通过基类中的方法进行
//
//    public function getList($where = array()){
//        return $this->db->select($this->tblname, $where);
//    }
//
//    public function getFirst($where = array()){
//        return $this->db->get($this->tblname, $where);
//    }
//
//    public function add($data){
//        return $this->db->insert($this->tblname, $data);
//    }
//
//    public function update($data, $where){
//        return $this->db->update($this->tblname, $data, $where);
//    }

    //这个为示例函数
    public function getLastLogin($username){
        $sql = "SELECT
                    *
                FROM
                    outfun_member AS mem
                JOIN outfun_member_last AS mla ON mem.id = mla.userid
                WHERE
                    mem.username = '$username'";

        return $this->db->selectBySql($sql);
    }

}