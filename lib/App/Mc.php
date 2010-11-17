<?
/**
 * класс обертка memcache
 *
 * @author akalend
 * @package quickly
 */

/**
 * класс обертка memcache
 * реализован как синглентон
 *
 */
class Mc {
		
	private static $mc = null;
	private static $timeOut = 600; // set timeOut=10 min
	
	/**
	 * конструктор класса
	 * делаем его приватным
	 *
	 */
	private function __construct(){	}
		
	/**
	 * класс синглетона
	 *
	 * @param array $config - данные из конфига
	 * @return object Memcached
	 */
	public static function getInstance( array $config){
		if ( isset(self::$mc) ) return self::$mc;
		self::$mc = new Memcache();
		self::$mc->connect( $config['host'],$config['port'] );		
		return self::$mc;
	}

	
	
	/**
	 * возвращает значение переменной
	 *
	 * @param string $name
	 * @return mixed - значение переменной
	 */
	static public function get( $name ) {
		return self::$mc->get($name);
	}
	
	/**
	 * устанавливает значение переменной
	 *
	 * @param string $name - ключ переменной 
	 * @param mixed $date
	 * @param integer $time - время в секундах - на сколько мы устанавливаем время жизни переменной
	 *
	 */
	static public function set( $name, $date, $time = null) {
		if ( is_null($time))
			$time = self::$timeOut;
		return self::$mc->set($name, $date, $time);
	}
	
	
}
