<?

class GoodMongoModel extends DbMongo {
	
	protected $title;
	
	public function __construct() {
		parent::__construct();
		$this->setCollection('goods');
	}
	
	public function getByCategoryName($innername) {
		
		$this->limit(10);
		$res = $this->find(array('cat_innername'=>$innername));

		$goods_id = array();
		
		foreach ($res as $item) {			
			$goods = json_decode($item['goods'], true);
			$request = array();
			
			if (is_array($goods))
				foreach ($goods as $ob )
				array_push($goods_id , $ob['_id']);
		}

		$this->limit();
		$description = $this->find(array('_id' => array( '$in' => $goods_id)), 
									'good_description');
		$goods = array('goods'=>array()) ;			
		foreach ($res as $good) {
			$items = bson_decode($good['goods']);
			//var_dump($items);
			$i = 0;
			foreach ($items as &$item) {
				$dscr = $description[$item['_id']];
				$item['description'] = $dscr['description']; 		
			}	
			
			$good['offers'] = $items;	
			unset($good['goods']);
			array_push($goods['goods'], $good);
		}
		
		//var_dump($goods);			
		return $goods;
	}
	
	public function getTitle() { 		
		return $this->title;
	}
	
}