<?

class GoodModel extends DbModel {
		
	const SQL_SELECT_GOODS_BY_SPEC = "SELECT s.spec_id, shop_id, good_price as price, offer_description as description,  offer_name as title, s.spec_name 
									  FROM goods g, spec s 
									  WHERE g.spec_id = s.spec_id 
									    AND class_id={{class_id}}";
	
	const SQL_SELECT_BY_CLASSID = "SELECT spec_name as name,spec_id as id 
									FROM spec where class_id={{class_id}}";

	const SQL_SELECT_BY_INNERNAME = "SELECT spec_name as name,spec_id as id 
									FROM spec where class_innername='{{s(innername)}}'
									LIMIT {{top}},{{limit}}";

	const SQL_SELECT_COUNT_BY_INNERNAME = "SELECT count(spec_id) as count
									FROM spec where class_innername='{{s(innername)}}'";
	
	
	const SQL_SELECT_BY_IDS = "SELECT spec_name as name,spec_id as id, class_innername as class  
									FROM spec 
									WHERE spec_id IN ({{ids}})";
	
	public function getByClassIdOld($id) {
		return $this->exec( self::SQL_SELECT_BY_CLASSID , array( 'class_id'=> $id ) );
	}
	
	public function getByIds($ids) {
		return $this->exec( self::SQL_SELECT_BY_IDS , array( 'ids'=> $ids ) );
	}

	private $pages, $pageNum, $recCount;
	
	public function getByCategoryName($innername, $pageNum = 1, $pageSize = 25) {
	    
	    
	    $res = $this->exec( self::SQL_SELECT_COUNT_BY_INNERNAME  , array( 'innername'=> $innername ) );
	    $count = (int)$res[0]['count'];
	    
	    $this->recCount = $count;
	    
	    if(!$count)
	       return false;
	    $this->pageNum = (int)$pageNum;
	    if (!$this->pageNum )   
	       $this->pageNum  = 1;

	    $pageCount = ceil($count / $pageSize);
	    if ($this->pageNum  > $pageCount-1 )
	       $this->pageNum  = $pageCount;
	       
	    $top = ($this->pageNum - 1) * $pageSize;
	    //echo "top=$top limit=$pageSize<br>";
	    //return false;      
		$spec = array();
		$res = $this->exec( self::SQL_SELECT_BY_INNERNAME  , 
		                  array('innername'=> $innername,
		                        'limit' => $pageSize,
		                        'top' => $top ));
		if (!$res)
			return false;
		
		$this->pages = $pageCount;
			return $res;		
	}
	
	public function makePages($url) {	    
	   $PB = new PagerBuilder($this->recCount, $this->pageNum); 
	   return $PB->build($url,NULL, false); 
	}
	
	public function getByClassId($id) {
		if (!$this->check($td)) 
			return;
		
		$spec = array();
		$res = $this->exec( self::SQL_SELECT_GOODS_BY_SPEC  , array( 'class_id'=> $id ) );
		$spec_id = 0;
		if (!$res)
			return false;
	
		foreach ($res as $row) {
			if ($row['spec_id'] != $spec_id) {				
				if ($spec_id) {
					$spec[] = $arr;
					unset($arr);
				}
				$spec_id = $row['spec_id'];				
				$arr = array('id' => $spec_id, 'name'=>$row['spec_name'],'items'=>array());
			}
			$arr['items'][] = $row;			 
		}
		if ( count($arr))
			$spec[] = $arr;
		
		return $spec;
	}
}