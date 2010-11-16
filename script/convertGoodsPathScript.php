<?php
/**
 * usage:
 *	php run_script.php converToMongo [parameters]
 *
 */
class ConvertGoodsPathScript extends baseScript {
	
	protected $args = array( 'show' =>null, 'add'=>null, 'create'=>null, 'cat_id'=>null);
	protected $dbM,$maxId,$good_id;
	protected $db;
	/**
	 * @param IRequest $Request - ������ �������
	 */
	public function __construct(Request $Request=null ) {
		parent::__construct($Request);		
	}

	public function run() {		
				
		if ($this->args[show] ) {
			$this->show(); exit;
		}
//		var_dump(); exit;

	
		if ($this->args[create] ) {
			$this->create();
		}	
	}
	
	private function show() {
		
	}
	
	function create() {
		$sql = "SELECT class_id, class_innername FROM classes;";	
		///?			spec_innername,,	
		$this->db = new DbConvert();
		$db = new DbConvert();
		$db->query( $sql );
		while ( ($row = $db->iterate()) != null ) {			
			$this->updateGoods($row);
		}
		
	}
	
	private function updateGoods($row){
		$sql = "UPDATE spec SET class_innername='{$row[class_innername]}' WHERE class_id=$row[class_id];\n";
		echo $sql;
		//$this->db->query( $sql );
	}
	
	private function encode( &$row, $from ) {
		if (!$from) return;
		foreach ($row as $key=>$value) {
			if (is_string( $row[$key] ))
				$row[$key] = iconv($from, 'UTF-8', $value );
		}
	}
	
	
}