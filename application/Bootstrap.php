<?php
/**
 * @name Bootstrap
 * @author root
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract{

    public function _initConfig() {
        Yaf_Registry::set('config', Yaf_Application::app()->getConfig());
	}

	public function _initLoader(Yaf_Dispatcher $dispatcher) {
	}

	public function _initPlugin(Yaf_Dispatcher $dispatcher) {
	}

	public function _initSession(Yaf_Dispatcher $dispatcher) {
	}

	public function _initRoute(Yaf_Dispatcher $dispatcher) {
	}
	
	public function _initView(Yaf_Dispatcher $dispatcher){
//       $dispatcher->autoRender(FALSE);
//        pp($dispatcher);
	}

}