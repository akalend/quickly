<?


/**
 * ����� ������� ���������� ������������
 *
 * @author akalend
 * @package quickly
 */

/**
 *  ����� ������� ���������� ������������
 *
 */
class Config {
		
	private $db;
	private $mc;
	private $mongo;
	private $name = null;
	private $data = null;
	//private $ngx = null;
	/**
	 * ����������� ������ 
	 * �� ��������� ������ ��������� �������
	 *
	 */
	function __construct( $name = null, $section = null ){
		require( APP_PATH.'/conf/app.conf.php' );
		if ( is_null( $name ) ) {			
			$this->db=$db_conf;
			$this->mc=$mc_conf;
			$this->mongo=$mongo_conf;
			//$this->ngx=$ngx_conf;
			return $this;
		} 
		
		require( APP_PATH."/conf/$name.conf.php"  );
		$this->name = $name;
		$section_name = $name.'_'.$section;
		$this->data = $$section_name;		
		return $this;
	}

	/**
	 * �������� �������� ����������
	 *
	 * @param  string $name - ��� ���������� ���������� 
	 * @return mixed - ���������� ������ ������ ���� �� ���������� 
	 */
	public function get( $name ) {	    
//	    var_dump( $this->name, $this->data );
		if ( !is_null( $this->name )  &&  !is_null( $this->data)) {
//		    echo '----------';
			if ( isset( $this->data['name'] ))
				return $this->data['name'];
		}
		
		if (!isset($this->{$name}) )
			throw new Exception('unknow section in config file'); 
		return $this->{$name};
	}
	/**
	 * �������� �� ������� ������ ���������� 
	 *
	 * @param string $name ��� ������
	 * @return array - ������ ����������
	 */
	public function getSection($name=NULL) {
		if ( $name) {
			$section_name = $this->name.'_'.$name;
			$this->data = $$section_name;			
		}
		return $this->data;
	}
	
	
}
