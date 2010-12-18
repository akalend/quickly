<?
/**
 * ����� ������� memcache
 *
 * @author akalend
 * @package quickly
 */

/**
 * ����� ������� memcache
 * ���������� ��� ����������
 *
 */
class Mc {
		
	private static $mc = null;
	private static $timeOut = 600; // set timeOut=10 min
	
	/**
	 * ����������� ������
	 * ������ ��� ���������
	 *
	 */
	private function __construct(){	}
		
	/**
	 * ����� ����������
	 *
	 * @param array $config - ������ �� �������
	 * @return object Memcached
	 */
	public static function getInstance( array $config){
		if ( isset(self::$mc) ) return self::$mc;
		self::$mc = new Memcache();
		self::$mc->connect( $config['host'],$config['port'] );		
		return self::$mc;
	}

	
	
	/**
	 * ���������� �������� ����������
	 *
	 * @param string $name
	 * @return mixed - �������� ����������
	 */
	static public function get( $name ) {
		return self::$mc->get($name);
	}
	
	/**
	 * ������������� �������� ����������
	 *
	 * @param string $name - ���� ���������� 
	 * @param mixed $date
	 * @param integer $time - ����� � �������� - �� ������� �� ������������� ����� ����� ����������
	 *
	 */
	static public function set( $name, $date, $time = null) {
		if ( is_null($time))
			$time = self::$timeOut;
		return self::$mc->set($name, $date, $time);
	}
	
    /**
	 *  delete the data from cache 
	 *
	 * @param string $name
	 * @return mixed -  
	 */
	static public function delete( $name ) {
		return self::$mc->delete($name);
	}

	/**
	 * Flush the cache
	 *
	 * @return bool the result operation
	 */
	static public function flush() {
		return self::$mc->flush();
	}
	
}
