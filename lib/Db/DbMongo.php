<?
/**
 * 
 * base class DbMongo
 *
 * @author akalend
 * @package quickly
 */


/**
 * work with MongoDb
 *
 */
class DbMongo {
		
	private $db = null;
	private $cnn=null;
	private $collection=null;
	private $collectionName=null;
	private $isntCall = true;
	private $conf = null;
	private $sqlCache = array();
	private $sort = null;
	private $skip = null;
	
	/**
	 * constructor
	 */
	public function __construct() {
		$conf = new Config();
		$this->conf = $conf->get('mongo');
	}
			
	/**
	 * finalization
	 * show sql cache
	 *
	 */
	public function finalize () {
		if ( count($this->sqlCache) ) {
			return $this->getStat();
		}		
	}

	/**
	 * возвращает статистику по времени выполнени€ запросов
	 *
	 * @return array  sql/time - врем€ выполнени€ каждого задействоанного запроса
	 * 
	 */
	public function getStat() {
		return $this->sqlCache;
	}
	
	/**
	 * инициализаци€ класса  db
	 * соединение с Ѕƒ, используетс€ с транзакци€ми
	 *
	 */
	protected function init () {
		//echo( 'init() connection');
		//var_dump($this->isntCall);
		if ( $this->isntCall ) {
			$this->isntCall=false;
	
			if (isset($this->conf['user']) && isset($this->conf['password']) ) {
				$cnnStr = "mongodb://{$this->conf['user']}:{$this->conf['password']}@".($this->conf['host'] ? $this->conf['host']:'localhost').( $this->conf['port'] ? ':'. $this->conf['port'] : '');
				$this->cnn = new Mongo( $cnnStr );
			} else 
				$this->cnn = new Mongo();
	
			$this->db = $this->cnn->selectDB($this->conf['dbname']);
			// $db = $connection->dbname;

		}	
	}
		
	/*	
	$code = new MongoCode(
		"function() { return 'hello, '+name; }",
			array("name" => "Fred"));
			$db->execute($code);
	
	$cursor = $results->find()
		->sort(array("ts" => -1))
		->skip($page_num* $results_per_page)
		->limit($results_per_page);
	
	$cursor = $c->find(array("foo" => "bar"))
	foreach($cursor as $id => $value) {
		...
	}
	$a = iterator_to_array($cursor);
	
	while( $cursor->hasNext() ) {
 	   var_dump( $cursor->getNext() );
	}
	
	*/
	
	/**
	 * set collection name
	 *
	 * @param string $name
	 */
	public function setCollection($name) {
		$this->init();
		if ($this->collectionName != $name ) {
			$this->collection = $this->db->selectCollection($name);
			$this->collectionName = $name;
		}			
	}	
	
	
	/**
	 * set limit
	 *
	 * @param int $limit
	 * @param int $skip - offset (skip)
	 */
	public function limit($limit=false, $skip=false) {
		if (!$limit) $this->limit=false;
		if (!$skip) $this->skip = false; // сброс если нет параметров
		if ($this->limit != $limit ) {   // установка параметра, если он сущетвует
			$this->limit = $limit;
		}			
		if ($this->skip != $skip ) {   // установка параметра, если он сущетвует
			$this->skip = $skip;
		}			
		
	}	

	
	/**
	 * update data into collection
	 *
	 * @param array $where - the position data for updating
	 * @param array $data - the new data 
	 * @param string $collection - the collection name
	 * @param string $label - - the some label for profiling
	 */
	public function update( $where, $data, $collection = null , $label = null) {		
		$collection && $this->setCollection( $collection);
		if (!$this->collection) throw new Exception('The mongo collection is undefined');	
		$time_start = microtime();
		$this->collection->update($where, $data);
		$label && $this->setTime( $time_start ,$label);
	}

	/**
	 * set sort attribute
	 * 
	 * @param array $data - the sorting data object 
	 */
	public function sort(Array $data) {
		$this->sort=$data;
	}
	/**
	 * find data into collection
	 *
	 * @param array $data - the finging data object 
	 * @param string $collection - the collection name
	 * @param string $label - - the some label for profiling
	 */
	public function find( $data, $collection = null , $label = null) {
	//protected function find( $collection, $data , $label = null) {

		$collection && $this->setCollection( $collection);	
		if (!$this->collection) throw new Exception('The mongo collection is undefined');	
		$time_start = microtime();

		$cursor = $this->collection->find($data);
		$this->limit && $cursor->limit($this->limit);
		$this->skip && $cursor->skip($this->skip);

		//var_dump($this->limit);
		is_array($this->sort) && $cursor->sort($this->sort);
		
		$result=array();
		
		foreach($cursor as $id => $value) {
			print $id."\n";
			$result[$id] = $value; 
		}
		
		$label && $this->setTime( $time_start ,$label);		
		return $result;
	}
	
	/**
	 * insert data into collection
	 *
	 * @param array $data - the data for inserting
	 * @param string $collection - the collection name
	 * @param string $label - - the some label for profiling
	 */
	public function insert( $data, $collection = null , $label=null) {
		$collection && $this->setCollection( $collection);	
		if (!$this->collection) throw new Exception('The mongo collection is undefined');	
		$time_start = microtime();
		$this->collection->insert($data);
		unset($data);
		$label && $this->setTime( $time_start );		
	}
	
	/**
	 * Enter description here...
	 *
	 * @param int $time_start in sec
	 * @param string $label - the some label for profiling
	 */
	private function setTime($time_start, $label) {
		$time = microtime()-$time_start;		
		if ($label) {
			$this->sqlCache[] = array( 'sql' =>$label , 'time'=>$time );
		}				
	}
	
}
