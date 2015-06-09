<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-6-5
 * Time: 下午5:43
 */
class MemberModel extends Base_Model_Abstract{

    protected $dbname = 'outfun';

    public function get(){
        $where = array();
        return $this->db->select('outfun_member', $where);
    }
}