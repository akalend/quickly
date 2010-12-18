<?php

class ApplicationSsi {
	
	private $Request,
		$beginsTime,$beginmTime,
		$page,
		$className,
		$Session,
		$filename,
		$bindBlockData=array();
			
	public function  __construct( $name ){
		$this->Request = new Request;
		
		$this->beginmTime = $this->microtime(microtime());
		$this->beginsTime = time();
		$this->pageName =  $name;
		
		
		include(APP_PATH.'/lib/App/Config.php' );
		// include(APP_PATH.'/script/baseScript.php');

		$this->className = "{$this->pageName}Page";
		$this->fileName = "page/{$this->className}.php";	
  	    require_once('../lib/App/Template.php' );
	    require_once('../lib/App/View.php' );

	    require_once('../page/basePage.php' );
	    require_once( APP_PATH.'/'.$this->fileName );
	    $this->Session = new Session;
		try {						
			$this->page = new $this->className( $this->Request, $this->Session);
		} catch ( Exception $e ) {
//			$this->page = new NotFound ( $this->Request, $this->Session);
		}
		
		
	}
	
	public function run( $args=null ) {
	    
		register_shutdown_function('saveClassCache');

		$this->page->init($args);
		$this->page->run();

		$htmlBlocks = $this->page->finalize();	

		if ( $this->page->isCached() ) {
			//echo 'ceching page...';
			$conf = new Config();

			$mc =  Mc::getInstance($conf->get('mc'));
			$v = get_class_vars( $this->className);
		
			if ( isset( $v['CachingKey'])) {
				$key = $this->page->CachingKey;
				$mc->set( $key, $res );
			} 
		}
		
		echo $htmlBlocks['page'];
		$delta = $this->microtime(microtime()) - $this->beginmTime;
		echo '<!-- produce time=' .( $this->microtime(microtime()) - $this->beginmTime) . ' in sec -->';				
	}
	
	
	function microtime($microtime)
	{
	    list($usec, $sec) = explode(" ", $microtime);
	    return ((float)$usec + (float)$sec);
	}	
	
}
