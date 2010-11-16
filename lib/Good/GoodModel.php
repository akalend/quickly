<?

class GoodModel extends DbModel {
		
	const SQL_SELECT_GOODS_BY_SPEC = "SELECT s.spec_id, shop_id, good_price as price, offer_description as description,  offer_name as title, s.spec_name 
									  FROM goods g, spec s 
									  WHERE g.spec_id = s.spec_id 
									    AND class_id={{class_id}}";
	
	const SQL_SELECT_BY_CLASSID = "SELECT spec_name as name,spec_id as id 
									FROM spec where class_id={{class_id}}";

	const SQL_SELECT_BY_INNERNAME = "SELECT spec_name as name,spec_id as id 
									FROM spec where class_innername='{{s(innername)}}'";
	
	public function getByClassIdOld($id) {
		return $this->exec( self::SQL_SELECT_BY_CLASSID , array( 'class_id'=> $id ) );
	}
	
	public function getByCategoryName($innername) {
		$spec = array();
		$res = $this->exec( self::SQL_SELECT_BY_INNERNAME  , array( 'innername'=> $innername ) );
		if (!$res)
			return false;
		
			return $res;		
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