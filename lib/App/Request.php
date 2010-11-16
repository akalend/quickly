<?
/**
 * класс обертка POST
 *
 * @author akalend
 * @package quickly
 */
/**
 * класс обертка входных даных POST
 *
 */
class Request {
		
	private $Data;
	private $server;
	private $files;
	
	/**
	 * конструктор класса
	 *
	 */
	function __construct( ){
		$this->Data = $_REQUEST;
		$this->server = $_SERVER;
		$this->files = $_FILES;
	}

	/**
	 * Enter description here...
	 *
	 * @param  string $name - имя переменной
	 * @return bool если переменная  существует - true 
	 *              или если есть POST запрос 
	 */
	public function hasVar( $name = null) {
		if (is_null( $name ))
		  return ($_SERVER['REQUEST_METHOD']=== 'POST');
		return array_key_exists( $name, $this->Data);
	}
	
	/**
	 * возвращает значение переменной
	 *
	 * @param string $name
	 * @return mixed - значение переменной
	 */
	public function get( $name ) {
		return array_key_exists( $name, $this->Data) ? $this->Data[$name] : null;
	}
	
	/**
	 * возвращает значение серверной переменной
	 *
	 * @param string $name
	 * @return mixed - значение переменной
	 */
	public function getServer( $name ) {
		return array_key_exists( $name, $this->server) ? $this->server[$name] : null;
	}	
	
	/**
	 * возвращает значение серверной переменной  QUERY_STRING
	 *
	 * @return string - значение переменной
	 */
	public function getUri() {
		return array_key_exists('DOCUMENT_URI', $this->server) ? $this->server['DOCUMENT_URI'] : null;
	}	

	/**
	 * возвращает значение всех переменных
	 *
	 * @return mixed - значение переменной
	 */
	public function getVars() {
		return $this->Data;
	}
	
	/**
	 * возвращает значение всех переменных
	 *
	 * @return array - данные о загруженном файл:
	["userfile"]=>  array(5) {
    	["name"]=  "2.jpg" 
    	["type"]=> "image/jpeg"
    	["tmp_name"]=> "/private/tmp/phpMJORpt"
    	["error"]=> ''
    	["size"]=> 10784
	}
	 */
	public function getFile($name=null) {
		if (is_null( $name ))
			return $this->files;
		else 
		  return key_exists( $name, $this->files )? $this->files[$name] : null ;
		
	}
	
	
/**
 
 */
	
}
