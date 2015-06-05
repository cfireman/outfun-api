<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-6-5
 * Time: 下午5:23
 */
class Base_Model_Abstract {

    protected $dbname;
    protected static $instances = array();

    public static function create() {
        $className = get_called_class();
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new $className();
        }
        return self::$instances[$className];
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

    public function select(){
        return $this->db->select('dili_admins');
    }

}