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
	
	private $spec = array();
	private $classes = array();
	
	function create() {
        $this->getClasses();
        
		$sql = "SELECT class_id , spec_id as id FROM spec";	
		///?			spec_innername,,	
		$db = new DbConvert();
		$db->query( $sql );
		while ( ($row = $db->iterate()) != null ) {			
//			var_dump($row);
		    $this->updateGoods($row);
		}		
	}

    private function getClasses() {
		$sql = "SELECT rubric_id, class_id as id FROM classes;";	
		///?			spec_innername,,	
		$db = new DbConvert();
		$db->query( $sql );
		while ( ($row = $db->iterate()) != null ) {			
			$this->classes[(int)$row[id]] = $row[rubric_id];
		}		
	}
		
	private function getSpec() {
		$sql = "SELECT spec_id as id, class_id  FROM spec;";	
		///?			spec_innername,,	
		$db = new DbConvert();
		$db->query( $sql );
		while ( ($row = $db->iterate()) != null ) {			
			$this->spec[(int)$row[id]] = $row[class_id];
		}		
	}
	
	
	
	private function updateGoods($row){
		$rubric_id = $this->classes[$row[class_id]];
		if (!$rubric_id) return;
	    $sql = "UPDATE spec SET rubric_id=$rubric_id WHERE spec_id=$row[id];\n";
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