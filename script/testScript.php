<?php

class DbRealModel extends DbModel {
	public function exec($sql) {
		return parent::exec($sql);
	}
	public function getCnn() {
		return $this->db;
	}

} ;

/**
 * the example test script
 *
 */
class testScript extends baseScript {
	
	/**
	 * @param IRequest $Request - ������ �������
	 */
	public function __construct(Request $Request=null ) {
		parent::__construct($Request);		
	}

	
	
	
	/**
	 * call for all scripts
	 *
	 */
	public function run() {
	    
	    $s='песня года';
	    $res = UtilConverter::transLiteral($s);
	    echo "$res\n";
		//$this->pagerTest();
	}
	
	public function run2() {		
		$classesHash = array();
		$db = new DbRealModel();
		$classes = $db->exec("SELECT spec_id,class_innername FROM spec WHERE NOT ISNULL(class_innername)");
		
		foreach ( $classes as $row ){
			$classesHash[$row[spec_id]] = $row[class_innername];
		}
		unset($classes);
		
		/*
		$spec = $db->exec("SELECT spec_id,class_id from spec");
		foreach ($spec as $row) {
			$innermame =  $classesHash[$row[class_id]];
			$sql = "UPDATE spec SET class_innername='$innermame' WHERE spec_id={$row[spec_id]}; \n";
			$db->exec($sql);
		}
		*/
		
		//$spec = $db->exec("SELECT id,spec_id from goods limit 20");
		$cnn = $db->getCnn();

		$res = $cnn->query("SELECT id,spec_id from goods" );
		
		while ($row = $res->fetch_array(MYSQLI_ASSOC)) {			
			$innermame =  $classesHash[$row[spec_id]];
			if ($innername=='') continue;
			$sql = "UPDATE goods SET class_innername='$innermame' WHERE id={$row[id]}; \n";
			$cnn->query($sql);
		}
		
		
	}
	
	public function runOld() {
		/*
		 * example for logging 
		 */
		//$log = Log::getInstance()->toLog('zzzz', Log::ERROR );
		
		$CM = new CategoryModel();
		$res = $CM->getTree();
		//$this->m1();
		print_r($res);
		echo "Ok\n";		
		
	}
	
	/**
	 * test of limit & offset
	 *
	 */
	private function pagerTest() {

		$db_new = new DbMongo();
		
		$db_new->limit(10);
		$res = $db_new->find(array(), 'goods');
		//var_dump($res);
//		foreach ( $res as $it ) {
//			print_r( $it['_id'] ); echo "\n";	
//		}
	}
	
	private function m1() {
		//$db_new = new DbMongo();
		
		
		//$res = $db->find(array(), 'second');
		//var_dump( $res );	
		
		 // $db->update( array('_id'=> new MongoId('4bffd4d28ead0e076a000000')),
		 //				 array( '$set' => array( 'price' => 21)) , 'goods' );
		
	}
	
}