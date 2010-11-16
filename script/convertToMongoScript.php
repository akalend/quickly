<?php
/**
 * usage:
 *	php run_script.php converToMongo [parameters]
 *
 * parameters:
 *		--table=<MySql source table name>
 *		--columns=<MySql table columns list, default='*': all columns>
 *		--collection=<MongoDb destination collection name, default = MySQL table name>
 *		--show=<MongoDb collection name> - only show all collection
 *
 * examples:
 *	php run_script.php converToMongo --table=users --columns='name,lastname,birthday,city,interes' --collection=person
 *	php run_script.php converToMongo --show=person
 *
 */
class ConvertToMongoScript extends baseScript {
	protected $args=array(
				  'table'=>null,
				  'collection'=>null,
				  'columns'=>null,
				  'show' => null,
				  'iconv' => null,
	);

	
	/**
	 * @param IRequest $Request - данные запроса
	 */
	public function __construct(Request $Request=null ) {
		parent::__construct($Request);		
	}

	/**
	 * call for all scripts
	 *
	 */
	public function run() {		
		if ( $this->Request->getServer('argc') < 3 ) {
			$this->output();			
		}
		
		if ( $this->args['show'] != null ) {
		   $this->show();
		   exit;
		}   
		   
		if ($this->args['table'] != null){
			$this->create();
			exit;
		}
		
		$this->output();			
	}
	
	/**
	 * print description utility
	 *
	 */
	private function output() {
	  echo "usage:\n\tphp run_script.php converToMongo [parameters]\n\n";
	  echo "parameters:\n";
	  echo "\t\t--table=<MySql source table name>\n";
	  echo "\t\t--columns=<MySql table columns list, default='*': all columns>\n";
	  echo "\t\t--collection=<MongoDb destination collection name, default = MySQL table name>\n";
	  echo "\t\t--show=<MongoDb collection name> - only show all collection\n";
	  echo "\t\t--iconv=<encoding Db> from convert to UTF-8\n\n";
	  echo "examples:\n";
	  echo "\tphp run_script.php converToMongo --table=users --columns='name,lastname,birthday,city,interes' --collection=person\n";
	  echo "\tphp run_script.php converToMongo --show=person\n\n";
	  exit;
	}
	
	/**
	 * show collections
	 *
	 */
	function show() {
		$collection =  $this->args['collection'] ? $this->args['collection'] : $this->args['show'];
		if ($collection == null) 
			$this->output();
		
		$db_new = new DbMongo();
		$res = $db_new->find( array(), $collection);
		foreach ( $res as $item) {			
			var_dump( $item);
//			echo(iconv( 'UTF-8', 'CP1251',$item['city'] ) ."\n");
		}
	}
	
	function create() {
		
		$table = $this->args['table'];
		
		if (!$this->args['columns'])
			$sql_columns = 	'*';
		else 
			$sql_columns = $this->args['columns'];
			
		$sql = "SELECT $sql_columns FROM $table";	
		//var_dump( $this->args['columns'] );
		echo "$sql\n";
		
		$collection = $this->args['collection'] ?  $this->args['collection'] : $table;
		
		$db = new DbConvert();
		$db->query( $sql );
		$db_new = new DbMongo();
		$db_new->setCollection($collection);
		$i=0;
		$from=null;
		if ($this->args['iconv']) 
			$from=$this->args['iconv'];
		while ( ($row = $db->iterate()) != null ) {			
			$i++;
			if ( $from )
				$this->encode($row, $from);
			$db_new->insert( $row );	
//			var_dump( $row );
		}
		echo "inserted into $collection $i items\n\n";
	}
	
	private function encode( &$row, $from ) {
		if (!$from) return;
		foreach ($row as $key=>$value) {
			$row[$key] = iconv($from, 'UTF-8', $value );
		}
	}
	
	/*
		$data = json_decode( $row['data'] , true);
			$data['city'] && $row['city'] =  $data['city'];
			$data['interes'] && $row['interes'] = $data['interes'];
			$row['name'] = iconv( 'CP1251','UTF-8', $row['name']);
			unset ($row['data']);
			$db_new->insert( $row );	
			var_dump( $row );
	
	*/
	
}