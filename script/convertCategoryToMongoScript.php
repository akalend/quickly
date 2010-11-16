<?php
/**
 * usage:
 *	php run_script.php converToMongo [parameters]
 *
 */
class ConvertCategoryToMongoScript extends baseScript {
	
	protected $args = array( 'show' =>null, 'add'=>null, 'create'=>null, 'cat_id'=>null);
	protected $dbM,$maxId;
	/**
	 * @param IRequest $Request - ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½
	 */
	public function __construct(Request $Request=null ) {
		parent::__construct($Request);		
	}

	/**
	 * call for all scripts
	 *
	 */
	public function run() {		
		
		if ($this->args[show] ) {
			$this->show(); exit;
		}
//		var_dump(); exit;
//		
		if ($this->args[add] ) {
			$this->addClasses(); exit;
		}
	
		if ($this->args[create] ) {
			$this->create();
			$this->createParentName();
		}	
	}
	
	private function show() {
		
		$db_new = new DbMongo();
		if ( isset($this->args[cat_id]) && $this->args[cat_id])
			$parm = array('parent_id' => (int)$this->args[cat_id]);
		else 
			$parm = array();	
			
		$res = $db_new->find( $parm, 'category');
		foreach ( $res as $item) {			
			var_dump( $item);
//			echo(iconv( 'UTF-8', 'CP1251',$item['city'] ) ."\n");
		}
	}
	
	function addClasses() {
		$this->dbM = new DbMongo();
		$res = $this->dbM->find( array(), 'category');
		$category = array();
		foreach ( $res as $item) {			
			$this->maxId = (int)$item[_id];
			$category[$this->maxId] = $item;
//			var_dump( $item);
		}
		
		foreach ( $category as $id=>$item ) {
			print_r("rubric_id=$id\n");
			$this->addClassByRubric($id,$item);
		}
	}
	/*
	[class_id] => 2601
    [class_isdeleted] => 0
    [rubric_id] => 1722
    [class_name] => þÊÝÀÍËØ, ÓÍÊÄÅÏØ, ÉÞÎÑßÊØ
    [class_fullname] => þÊÝÀÍËØ, ÓÍÊÄÅÏØ, ÉÞÎÑßÊØ
    [class_innername] => albums_capsules
    [class_ishidden] => false
    [class_spechasclassname] => 0
    [spec_count] => 41
	
    "_id" : "55", Category
	"parent_id" : "0",
	"h2_id" : "0",
	"fullname" : "ï ÿ?ï?ÿ?ï?ÿ?ï? ï? ï?ï?ï?ÿ?ï?ï?ÿ?ï?",
	"shortname" : "ï ÿ?ï?ÿ?ï?ÿ?ï? ï? ï?ï?ï?ÿ?ï?ï?ÿ?ï?",
	"innername" : "health_and_beauty",
	"parent_name" : "",
	"aliases" : "",
	"parenthidden" : "0",
	"is_hidden" : "0",
	"path" : "",
	"parent_title" : "",
	"count" : ""

    */
	
	private function addClassByRubric($rubric_id, $parent) {
		$sql = "select * from classes where rubric_id=$rubric_id;\n";					
		$db = new DbConvert();
		$db->query( $sql );
		$i=0;
		$category = array();
		
		while ( ($row = $db->iterate()) != null ) {			
			echo "{$this->maxId}\n";
			$this->maxId++;
			print_r($row);
			$item = array(
			"_id" => $this->maxId,
			"parent_id" =>$rubric_id,
			"h2_id" =>$parent['parent_id'],
			"fullname" => iconv( 'CP1251','UTF-8',$row['class_fullname']), //iconv( 'CP1251','UTF8',
			"shortname" => iconv( 'CP1251','UTF-8',$row['class_name']),
			"innername" => $row['class_innername'],
			"parent_name" => $parent['innername'],
			"aliases" =>'', // @TODO delete next step
			"parenthidden" => $parent['is_hidden'],
			"is_hidden"  => $row['class_ishidden'],
			"path" => $parent['path'].'|'.$parent['shortname'],
			"parent_title" =>$parent['shortname'],
			"old_id" => $row['class_id'],
			);
			print_r($item);
			$this->dbM->insert( $item );
		}
		
	}
	
	function createParentName() {
		$sql = "select * from category";	
				
		$db = new DbConvert();
		$db->query( $sql );
		$i=0;
		$category = array();
		
		while ( ($row = $db->iterate()) != null ) {			
			$i++;
			//print_r( $row );
			$category[$row['id']] = $row;
		}
		
		foreach ($category as &$item) {
			if ($item['parent_id']) {
				$item['parent_name'] = $category[$item['parent_id']]['innername'];
				$item['parent_title'] = $category[$item['parent_id']]['shortname'];
				
				$item['path'] = $category[$item['parent_id']]['shortname'];
				if ( $category[$item['parent_id']]['parent_id'] )
					$item['path'] = $category[$category[$item['parent_id']]['parent_id']]['shortname'] .'|'. $category[$item['parent_id']]['shortname'];
				
				
			$db->query( "UPDATE category 
						SET parent_name='{$item['parent_name']}',
						    parent_title='{$item['parent_title']}',
						    path='{$item['path']}'
						WHERE id={$item['id']}" );
				
			}	
		}
		
	}
	
	function create() {
		
			
		$sql = "select * from category";	
		//var_dump( $this->args['columns'] );
		//echo "$sql\n";
				
		$db = new DbConvert();
		$db->query( $sql );
		$db_new = new DbMongo();
		$db_new->setCollection('category');
		$i=0;

		while ( ($row = $db->iterate()) != null ) {			
			$i++;
			$this->encode($row, 'CP1251');
			$row['_id'] = (int)$row['id'];
			$row['h2_id'] = (int)$row['h2_id'];
			$row['parent_id'] = (int)$row['parent_id'];
			$row['is_hidden'] = (int)$row['is_hidden'];
			unset($row["parenthidden"]);			
			unset($row['id']);
			$db_new->insert( $row );	
		}
		
		echo "inserted into collections $i items\n\n";
	}
	
	private function encode( &$row, $from ) {
		if (!$from) return;
		foreach ($row as $key=>$value) {
			$row[$key] = iconv($from, 'UTF-8', $value );
		}
	}
	
	
}