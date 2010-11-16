<?


/**
 * класс обертка параметров конфигурации
 *
 * @author akalend
 * @package quickly
 */

/**
 *  класс обертка параметров конфигурации
 *
 */
class Config {
		
	private $db;
	private $mc;
	private $mongo;
	private $name = null;
	private $data = null;
	/**
	 * конструктор класса 
	 * по умолчанию грузит системные конфиги
	 *
	 */
	function __construct( $name = null, $section = null ){
		require( APP_PATH.'/conf/app.conf.php' );
		if ( is_null( $name ) ) {			
			$this->db=$db_conf;
			$this->mc=$mc_conf;
			$this->mongo=$mongo_conf;
			return $this;
		} 
		
		require( APP_PATH."/conf/$name.conf.php"  );
		$this->$name = $name;
		$section_name = $name.'_'.$section;
		$this->data = $$section_name;		
		return $this;
	}

	/**
	 * Получить значение параметров
	 *
	 * @param  string $name - имя сессионной переменной 
	 * @return mixed - возвращает данные секции если ни существуют 
	 */
	public function get( $name ) {
		if ( !is_null( $this->name )  &&  !is_null( $this->data)) {
			if ( isset( $this->data['name'] ))
				return $this->data['name'];
		}
		
		if (!isset($this->{$name}) )
			throw new Exception('unknow section in config file'); 
		return $this->{$name};
	}
	/**
	 * получить из конфига секцию параметров 
	 *
	 * @param string $name имя секции
	 * @return array - секция параметров
	 */
	public function getSection($name=NULL) {
		if ( $name) {
			$section_name = $this->name.'_'.$name;
			$this->data = $$section_name;
		}
		return $this->data;
	}
	
	
}
