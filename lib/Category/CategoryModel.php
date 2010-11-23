<?

class CategoryModel extends DbModel {
		
	const SQL_SELECT = "SELECT id,parent_id,h2_id,fullname, innername 
					FROM category c
					WHERE is_hidden=0
					order by parent_id";
	
	const SQL_SELECT_BY_NAME = "SELECT id,fullname as title,parent_id
								FROM category c
								WHERE is_hidden=0 AND innername = '{{s(name)}}'";
					
	const SQL_SELECT_BY_ID = "SELECT fullname,innername
								FROM category c
								WHERE id = {{id}}";

	const SQL_SELECT_ID_BY_CLASSNAME = "SELECT class_id, class_name as title
								FROM classes c
								WHERE  class_innername = '{{s(name)}}'";
	
	const SQL_SELECT_CLASSES = "SELECT class_name as name, class_innername as shortname , spec_count as count
								FROM classes
								WHERE class_isdeleted=0 AND rubric_id={{cat_id}}"; 
	
	const SQL_SELECT_CHILD_CATEGORY = "SELECT id, fullname, innername, parent_title as title  
									FROM category c 
									WHERE parent_name = '{{s(name)}}'";
	const SQL_SELECT_BY_IDS = "SELECT fullname,innername
								FROM category c
								WHERE id = in {{ids}}";

	protected $title;
	protected $parent_id;
	
	public function getClasses($categoryName) { 		
	
		$res = $this->getIdByName($categoryName);
		$id = $res['id'];
		$rows = $this->exec( self::SQL_SELECT_CLASSES, array('cat_id'=> $id) );
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

	public function getByIds(Array $ids) {
	    if (!count($ids)) 
	       return NULL;
	    if (count($ids) == 1)
	       return $this->exec(self::SQL_SELECT_BY_ID, array('id'=>$ids));		
	       
	    return  $this->exec(self::SQL_SELECT_BY_IDS, array('ids'=>$ids));		
	}

	
	public function getChildCategory($name) {
		$res = $this->exec(self::SQL_SELECT_CHILD_CATEGORY, array('name'=>$name));		
		if (isset($res[0])) 
			$this->title = $res[0]['title'];
		return $res;
	}
	
	
	private function getIdByName($name) {
		/* @TODO в обязательно порядке сделать кеширование */
		
		$rows = $this->exec( self::SQL_SELECT_BY_NAME , array( 'name'=> $name ) );
		return isset($rows[0]) ? $rows[0] : NULL;
	}
		
	public  function getClassIdByName($name) {
		/* @TODO в обязательно порядке сделать кеширование */
		
		$rows = $this->exec( self::SQL_SELECT_ID_BY_CLASSNAME , array( 'name'=> $name ) );
		$this->title = isset($rows[0]['title']) ? $rows[0]['title']: '';
		return isset($rows[0]['class_id']) ? $rows[0]['class_id'] : NULL;
	}

	public function getTree() { 		
 		$rows = $this->exec( self::SQL_SELECT );
 		$level=array(array(),array(),array());
 		$parent_id = 0;
 		$pparent_id = 0;
 		foreach ($rows as $row) {
 			if ($row['parent_id'] == 0) {
 				$level[0][$row['id']] = $row;
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