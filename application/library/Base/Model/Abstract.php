<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-6-5
 * Time: 下午5:23
 */
class Base_Model_Abstract {

    protected $dbname;
    protected $tblname;
    protected $prefix;
    protected static $instances = array();

    public static function create() {
        $className = get_called_class();
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new $className();
        }
        return self::$instances[$className];
    }

    public function __construct(){
        $config         = Yaf_Registry::get("config");
        $this->dbname   = $config['used_db'];
        $this->prefix   = $config['db'][$this->dbname]['prefix'];
        $this->tblname  = $this->prefix .'_'. lcfirst(str_replace('Model', '', get_called_class()));
    }

    /**
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function __get($name) {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) return $this->$getter();
        else if (Yaf_Registry::has($name)) return Yaf_Registry::get($name);

        throw new Exception("Property " . get_called_class() . ".{$name} is not defined.");
    }

    public function __set($name, $value) {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) return $this->$setter($value);
        else Yaf_Registry::set($name, $value);
    }

    public function __isset($name) {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) return $this->$getter() !== null;

        return Yaf_Registry::has($name);
    }

    public function __unset($name) {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) $this->$setter(null);
        else Yaf_Registry::del($name);
    }

    public function __call($name, $arguments) {
        if (method_exists($this, $name)) return call_user_method_array($name, $this, $arguments);
        else if (method_exists($this->getRequest(), $name)) return call_user_method_array($name, $this->getRequest(), $arguments);

        throw new Exception("Method " . get_called_class() . ".{$name} is not defined.");
    }

    public function getDb() {
        $key = 'db|' . $this->dbname;
        if (!Yaf_Registry::has($key)) Yaf_Registry::set($key, Db_Mysql::factory($this->dbname));

        return Yaf_Registry::get($key);
    }

    /**
     * @param array $where
     * @param array $order  array('add_time' => 'desc')
     * @param string $limit '10,20'
     * @return mixed
     */
    public function getList($where = array(), $order = array(), $limit = ''){
        return $this->db->select($this->tblname, $where, '*' , $order, $limit);
    }

    public function getFirst($where = array()){
        return $this->db->get($this->tblname, $where);
    }


    public function add($data){
        return $this->db->insert($this->tblname, $data);
    }

    public function update($data, $where){
        return $this->db->update($this->tblname, $data, $where);
    }

    public function del($where){
        return $this->db->delete($this->tblname, $where);
    }

    public function total($where){
        $res = $this->db->get($this->tblname, $where, 'count(*) as total');
        if($res){
            return intval($res['total']);
        }
        return 0;
    }
}