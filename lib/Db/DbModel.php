<?
/**
 * 
 * base class DbModel
 *
 * @author akalend
 * @package quickly
 */

/**
 * extended class from template engine (blitz)
 * for DB helpers
 *
 */
class blitzDb extends blitz {
	private $db=null;
	
	public function __construct( $db ) {
		parent::__construct();
		$this->db = $db;
	}
	
	/**
	 * ������ ���������� � ������
	 *
	 * @param string $str
	 * @return string - ��������� �������� real_escape_string($str); 
	 */
	public function s($str) {
		return $this->db->real_escape_string($str); 
	}

	/**
	 * ������ ���������� � �����
	 *
	 * @param  string $str - ��������� �������� �������� ����������
	 * @return int - ����������� � �����
	 */
	public function i($str) {
		return (int)$str;
	}
}

/**
 * ����� ������ � ��
 *
 */
abstract class DbModel {
		
	protected $db = null;
	private $isntCall = true;
	private $conf = null;
	private $sqlCache = array();
	private $tpl = null;
	private $rows =0;
	private $res;
	private $encoding = false;
	
	/**
	 * ����������� ������
	 */
	public function __construct() {
		$conf = new Config();
		$this->conf = $conf->get('db');
	}
		
	public function setEncoding($encoding) {
		$this->encoding = $encoding;
	}
	
	/**
	 * protected function, check argument for not null
	 * using for check mysql paramers
	 *
	 * @param unknown_type $arg
	 * @return true if argument is good
	 */
	protected  function check($arg){
		if (is_null($arg))
			return false;
		if (is_string($arg) && trim($arg) == '')
			return false;
			
		if (!$arg)
			return false;
			
		return true;		
	}
	
	public function initialize(){
		
	}
	
	/**
	 * ����������� 
	 *
	 */
	public function finalize () {
		if ( count($this->sqlCache) ) {
			return $this->getStat();
		}
		
	}

	/**
	 * ���������� ���������� �� ������� ���������� ��������
	 *
	 * @return array  sql/time - ����� ���������� ������� ��������������� �������
	 * 
	 */
	public function getStat() {
		return $this->sqlCache;
	}
	
	/**
	 * ������������� ������  db
	 * ���������� � ��, ������������ � ������������
	 *
	 */
	protected function init () {
		if ( $this->isntCall ) {
			$this->isntCall=false;
			$this->db = new mysqli( $this->conf['host'], $this->conf['user'],$this->conf['password'], $this->conf['dbname']);
			$this->db->query("SET NAMES 'cp1251'");
			$this->encoding = 'UTF-8';
			if (mysqli_connect_error() ){
				throw new Exception('Conection error '.mysqli_connect_error());
			}

		}
	
	}
	
	/**
	 * ��������� SQL ������
	 * ������������� ������� �� ����������
	 *
	 * @param string $sql - ������
	 * @param array $data - �� ������ 
	 * @return array - ��������� ���������� �������
	 */
	protected function exec ( $sql , array $data =array() ) {
			$this->init();
			
			$this->tpl = new blitzDb( $this->db );
			$this->tpl->load( $sql );
			
			$sql = $this->tpl->parse($data);
			unset($this->tpl);
//			var_dump($data);
//			echo "<font color=blue>$sql</font><br>";

			$time_start = microtime();
			$res = $this->db->query( $sql );
			
			if (!$res) {
				//echo $this->db->
				echo "<font color=blue>$sql</font><br>";
				echo 'mysql error: '.$this->db->error;
				$result = false;				
				} 
	//			var_dump( $this->db,$res );
				$time = microtime()-$time_start;
			
//			var_dump( $sql, $res );
			$this->sqlCache[] = $toSave = array( 'sql' =>$sql , 'time'=>$time );
			
			//var_dump($toSave);
			$log = Log::getInstance();
			$log->toLog($toSave, log::DEBUG);
			
			//$this->rows = $this->db->affected_rows();
			if (!is_object($res)) return true;

			while ($row = $res->fetch_assoc()) {
     		    if ($this->encoding) {
     		         foreach ( $row as $key => $value) {     		             
     		             if($value)
     		                $row[$key] = iconv('CP1251',$this->encoding,$value);
     		         }       
			    }  
			    $result[]=$row;     		  
			}
    		
    		return $result;
	}

	
	/**
	 * ��������� SQL ������, 
	 * but not return data
	 * ������������� ������� �� ����������
	 *
	 * @param string $sql - ������
	 * @param array $data - �� ������ 
	 * @return array - ��������� ���������� �������
	 */
	public function query( $sql , array $data =array() ) {
			$this->init();
			
			$this->tpl = new blitzDb( $this->db );
			$this->tpl->load( $sql );
			
			$sql = $this->tpl->parse($data);
			unset($this->tpl);

			$time_start = microtime();
			$this->res = $this->db->query( $sql );
			
			if (!$this->res) {
				echo 'mysql error: '.$this->db->error;
				$result = false;				
			} 
//				var_dump( $this->db,$res );
			$time = microtime()-$time_start;
			
//			var_dump( $sql, $res );
			$toSave = array( 'sql' =>$sql , 'time'=>$time );
			
			$this->sqlCache[] = $toSave;
			//$this->rows = $this->db->affected_rows();
			if (!is_object($res)) return true;			
	}
	
	/**
	 * return one row as assoc array
	 *
	 * @return array result of one row
	 */
	public function iterate() {
		if (!$this->res) throw new Exception('the mysql result is null');
		return $this->res->fetch_array(MYSQLI_ASSOC);
	}
	
	
	/**
	 * ���������� ���-�� ����� ���������� ��������
	 * UPDATE/DELETE
	 *
	 * @return unknown
	 */
	protected function getRowCount() {
		return $this->db->affected_rows();
	}
	
	
	
	/**
	 * START TRANSACTION
	 *
	 */
	protected function start() {
		$this->db->query('START TRANSACTION;');		
	}
	/**
	 * ROLLBACK TRANSACTION
	 *
	 */
	protected function rollback() {
		$this->db->rollback();
	}
	/**
	 * COMMIT TRANSACTION
	 *
	 */
	protected function commit() {
		$this->db->commit();
	}
	
}
