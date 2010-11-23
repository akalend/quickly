<?php
/**
 * usage:
 *	php run_script.php converToMongo [parameters]
 *
 */
class ConvertGoodsPathToIdScript extends baseScript {
	
	protected $args = array( 'show' =>null, 'create'=>null);
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
		
		if ($this->args[create] ) {		    
			$this->create();
		}	
	}
	
	private function show() {
		
	}
	
	private $classes = array();
	private $category = array();
	
	function create() {
		$this->db = new DbConvert();

	    $this->getClasses();
	    $this->getCategory();
        
	    $sql = "SELECT id,class_innername as name FROM goods limit 10";	
		
		$this->db->query( $sql );
		while ( ($row = $this->db->iterate()) != null ) {			
			var_dump($row);
		}
	    
	}
	
	
	private function getClasses() {
		$sql = "SELECT class_id as id, class_innername as name, rubric_id FROM classes";	
		
		$this->db->query( $sql );
		while ( ($row = $this->db->iterate()) != null ) {			
			$this->classes[$row[name]] = $row[id].'.'.$row[rubric_id];
		}	    
	}

	private function getCategory() {
		$sql = "SELECT id, innername as name FROM category";	
		
		$this->db->query( $sql );
		while ( ($row = $this->db->iterate()) != null ) {			
			$this->category[$row[name]] = $row[id];
		}	    
	}
	
	private function updateGoods($row){
		
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