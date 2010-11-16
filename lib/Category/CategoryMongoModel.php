<?

class CategoryMongoModel extends DbMongo {
	
	protected $title;
	protected $parent_id;
	
	public function __construct() {
		parent::__construct();
		$this->setCollection('category');
	}
	public function getClasses($categoryName) { 		
	
	//	$res = $this->getIdByName($categoryName);
	//	$id = $res['id'];
	//	$rows = $this->exec( self::SQL_SELECT_CLASSES, array('cat_id'=> $id) );
	
		$res = $this->find(array('innername'=>$name, 'is_hidden'=>0));
		
		$this->title = $res['title'];
		$this->parent_id = $res['parent_id'];
		return $rows;
	}
	
	public function getTitle() { 		
		return $this->title;
	}
	
	public function getParentId() { 		
		return $this->parent_id;
	}

	public function getChildCategory($name) {		
		$res = $this->find(array('parent_name'=>$name));//, 'is_hidden'=>0
		if (!is_null($res)) {
			$first = current($res);
			$this->title = $first['parent_title'];
		}	
		return $res;
	}
	
	
	private function getIdByName($name) {
		/* @TODO в обязательно порядке сделать кеширование */
		
		//$rows = $this->exec( self::SQL_SELECT_BY_NAME , array( 'name'=> $name ) );
		return isset($rows[0]) ? $rows[0] : NULL;
	}
		
	public  function getClassIdByName($name) {
		/* @TODO в обязательно порядке сделать кеширование */
		
		//$rows = $this->exec( self::SQL_SELECT_ID_BY_CLASSNAME , array( 'name'=> $name ) );
		$this->title = isset($rows[0]['title']) ? $rows[0]['title']: '';
		return isset($rows[0]['class_id']) ? $rows[0]['class_id'] : NULL;
	}

	public function getTree() { 		
		
		$this->sort(array("parent_id" => 1)); //  order by parent_id
		$rows = $this->find(array('h2_id'=>0, 'is_hidden'=>0));
					 
		
		$level=array(array(),array(),array());
 		$parent_id = 0;
 		$pparent_id = 0;
 		foreach ($rows as $row) {
 			if ($row['parent_id'] == 0) {
 				$level[0][$row['_id']] = $row;
	 		}
	 			 		
	 		if ($row['parent_id'] > 0 && $row['h2_id'] == 0) {
	 			if ( $parent_id != $row['parent_id'] ) {
	 				$parent_id = $row['parent_id'];
	 				$level[1][$row['parent_id']] = array();
	 			}
 				$level[1][$row['parent_id']][] = $row;
	 		}
	 		
	 		if ($row['h2_id'] > 0) {
	 			if ( $pparent_id != $row['parent_id'] ) {
	 				$pparent_id = $row['parent_id'];
	 				$level[2][$row['parent_id']] = array();
	 			}
 				$level[2][$row['parent_id']][] = $row;
	 		}	 		
 		}
 		
 		$tree = array();

 		foreach ( $level[0] as $id => $item ) {
 			$item['level'] = '0';
 			$tree[$id] = array( 'root' => $item, 'child' => null );	

 			foreach ($level[1][$id] as $item2) {
				if ( is_null($tree[$id]['child'] ) )
					 $tree[$id]['child'] = array();				 				
 				$tree[$id]['child'][] = array( 'item' =>$item2);
 			} 		 			
 		}
 		return $tree;
 		
 	}
}