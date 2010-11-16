<?php
/**
 * usage:
 *	php run_script.php converToMongo [parameters]
 *
 */
class ConvertGoodsToMongoScript extends baseScript {
	
	protected $args = array( 'show' =>null, 'add'=>null, 'create'=>null, 'cat_id'=>null);
	protected $dbM,$maxId,$good_id;
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
//		
	
		if ($this->args[create] ) {
			$this->create();
		}	
	}
	
	private function show() {
		
		$db_new = new DbMongo();
		
		$res = $db_new->find( $parm, 'spec');
		foreach ( $res as $item) {			
			var_dump( $item);
		}
	}
	
	function create() {
		
		$this->dbM = new DbMongo();
		
		$this->maxId=0;	
		$res = $this->dbM->find( array( '$where' => "this.old_id > 0" ), 'category');
		$category = array();
		foreach ( $res as $item) {			
			++$this->maxId;
			$category[(int)$item['old_id']] = array( (int)$item['_id'],$item['innername'], $this->maxId);
		}
		
	//var_dump( $category);
		$this->good_id = 1;
		$this->spec_id = 1;
		foreach ( $category as $id=>$item ) {
			//print_r("rubric_id=$id\n");
			//print_r($item);
			$this->addGoods($id,$item);
		}
	}
	
	private function addGoods($id, $category) {
		$sql = "SELECT  id , shop_id, g.class_innername as class_name, 
						spec_status, good_price, offer_name as title, 
						spec_name,spec_description, offer_description as description
			FROM spec s, goods g 
			WHERE s.spec_id = g.spec_id and 
				 class_id=$id\n";	
		///?			spec_innername,,	
		
		$db = new DbConvert();
		$db->query( $sql );
		$i=0;
		$this->dbM->setCollection('goods');
		
		$items = array();
		
		$spec_name = '';
		while ( ($row = $db->iterate()) != null ) {			
			echo "$this->good_id\n";
//			var_dump($row);
		
			$row['_id'] = $this->good_id++;			
			$this->encode($row, 'CP1251');
			$row['good_price'] = (float)$row['good_price'];
			$row['shop_id'] = (int)$row['shop_id'];
			
			if( $spec_name != $row['spec_name'] )  {				
				if($spec_name != '') {
					$this->spec_id++;
					$bson =  bson_encode($items);
					$goods = array (
						'_id' => $this->spec_id, //$category[2],
						'spec_description' => $spec_description,
						'spec_name' => $spec_name,
						'class_id' => $id, 
						'cat_id' => $category[0],	
						'cat_num' => $category[2],	
						
						'cat_innername' => $category[1],
						'goods' => $bson,
					);
					
					$this->dbM->insert( $goods , 'goods');			
					//var_dump($goods);
					unset($items);
					unset($goods);			
					
				}
				$items = array();

				$spec_name = $row['spec_name'];
				$spec_description = $row['spec_description'];
				$spec_old = $row['spec_old'];
				$class_name = $row['class_name'];
			}

				$row2 = array(
					'_id' =>  $row['_id'],
					'title' => $row['title'], 
					//'description' => $row['description'], 
				);				
				if ($row['description']) {
					$row2['description'] = $row['description'];
					//var_dump( $row2);	
					$this->dbM->insert( $row2 ,'good_description');			
				}

				unset($row['description']);
				unset($row['spec_description']);
				unset($row['spec_status']);
				unset($row['spec_name']);
				unset($row['class_name']);
				unset($row['class_id']);
				
				$items[] = $row;
				
				
		}
		
		$this->dbM->setCollection('goods');
		$this->dbM->insert( $goods );			
		
		//print_r(   $goods);
	}
	
	private function encode( &$row, $from ) {
		if (!$from) return;
		foreach ($row as $key=>$value) {
			if (is_string( $row[$key] ))
				$row[$key] = iconv($from, 'UTF-8', $value );
		}
	}
	
	
}