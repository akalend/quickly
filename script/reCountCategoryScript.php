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
 * пересчет ко-ва спек в каждом классе
 * по крону
 *
 */
class reCountCategoryScript extends baseScript {
	
	/**
	 * @param IRequest $Request - пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ
	 */
	public function __construct(Request $Request=null ) {
		parent::__construct($Request);		
	}

	/**
	 * call for all scripts
	 *
	 */
	public function run() {
		
		$classesHash = array();
		$db = new DbRealModel();
		$classes = $db->exec("SELECT class_id FROM classes");
		
		foreach ( $classes as $row ){
			$classesHash[$row[class_id]] = 0;
		}
		unset($classes);
		
		
		$cnn = $db->getCnn();
		$res = $cnn->query("SELECT  s.class_id 
							FROM spec s,goods g 
							WHERE s.spec_id=g.spec_id");
		
		while ($row = $res->fetch_array(MYSQLI_ASSOC)) {			
			$classesHash[$row[class_id]]++;
		}
		
		foreach ( $classesHash as $class_id => $count ){
			if (!$count) continue;
			$sql = "UPDATE classes SET spec_count=$count WHERE class_id=$class_id\n";
			$db->query($sql);			
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
	
}