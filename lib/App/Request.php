<?
/**
 * ����� ������� POST
 *
 * @author akalend
 * @package quickly
 */
/**
 * ����� ������� ������� ����� POST
 *
 */
class Request {
		
	private $Data;
	private $server;
	private $files;
	private $cookies;
	/**
	 * ����������� ������
	 *
	 */
	function __construct( ){
		$this->Data = $_REQUEST;
		$this->server = $_SERVER;
		$this->files = $_FILES;
		$this->cookies = $_COOKIE;
	}

	public function getCookie($name) {
	    return array_key_exists( $name, $this->cookies) ? $this->cookies[$name] : null;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param  string $name - ��� ����������
	 * @return bool ���� ����������  ���������� - true 
	 *              ��� ���� ���� POST ������ 
	 */
	public function hasVar( $name = null) {
		if (is_null( $name ))
		  return ($_SERVER['REQUEST_METHOD']=== 'POST');
		return array_key_exists( $name, $this->Data);
	}
	
	/**
	 * ���������� �������� ����������
	 *
	 * @param string $name
	 * @return mixed - �������� ����������
	 */
	public function get( $name ) {
		return array_key_exists( $name, $this->Data) ? $this->Data[$name] : null;
	}
	
	/**
	 * ���������� �������� ��������� ����������
	 *
	 * @param string $name
	 * @return mixed - �������� ����������
	 */
	public function getServer( $name ) {
		return array_key_exists( $name, $this->server) ? $this->server[$name] : null;
	}	
	
	/**
	 * ���������� �������� ��������� ����������  QUERY_STRING
	 *
	 * @return string - �������� ����������
	 */
	public function getUri() {
	    return array_key_exists('REQUEST_URI', $this->server) ? $this->server['REQUEST_URI'] : null;
	}	


	/**
	 * return internal uri$_SERVER[DOCUMENT_URI]
	 *
	 * @return string internel uri
	 */
	public function getIntUri() {
		return array_key_exists('DOCUMENT_URI', $this->server) ? $this->server['DOCUMENT_URI'] : null;
	}	
	
	
	/**
	 * ���������� �������� ���� ����������
	 *
	 * @return mixed - �������� ����������
	 */
	public function getVars() {
		return $this->Data;
	}
	
	/**
	 * ���������� �������� ���� ����������
	 *
	 * @return array - ������ � ����������� ����:
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
	 * this method use only for nginx_upload_module
	 *
	 */
	public function getImageFile( ) {
	     return array(
    	"name" => $this->Data['fileToUpload_name']  ,
    	"type" => $this->Data['fileToUpload_content_type'] ,
    	"tmp_name" => $this->Data['fileToUpload_path'] ,
    	"error" => '',
    	"size"=> $this->Data['fileToUpload_size'] );
	}
	
/**
 
 */
	
}
