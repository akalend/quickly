<?php
class Application {
	
	private $Request,
		$beginsTime,
		$beginmTime,
		$page,
		$Session,
		$className,
		$filename,
		$mode,
		$bindBlockData=array();
			
	public function  __construct( $name , $mode=null ){
		$this->Request = new Request();
		
		$this->beginmTime = microtime();
		$this->beginsTime = time();
		
		$this->pageName =  $name;
		$this->mode = $mode;
		include(APP_PATH.'/lib/App/Config.php' );
		// include(APP_PATH.'/script/baseScript.php');

		switch ($mode) {
			case 'web' 		: $this->className = "{$this->pageName}Page";
							  $this->fileName = "page/{$this->className}.php";	
							  require_once('../lib/App/Template.php' );
							  require_once('../lib/App/View.php' );

							  require_once('../page/basePage.php' );
//							  var_dump($this->filename);
							  require_once( APP_PATH.'/'.$this->fileName );
							  
							  $this->Session = new Session();
							  break;
			case 'script' 	: $this->className = "{$this->pageName}Script";
							  $this->Session = null;
							  $this->fileName = "script/{$this->className}.php";	
							  include(APP_PATH.'/script/baseScript.php');
							  include(APP_PATH.'/'. $this->fileName );			
							  break;
			case 'test' 	: $this->className = "{$this->pageName}Test";			
							  $this->fileName = "test/{$this->className}.php";	
							  break;			
			default:		throw new Exception('undefined mode');
		}
		

		try {			
		    $class = new ReflectionClass( $this->className );
		    $this->page = $class->newInstance( $this->Request, $this->Session );			
		} catch ( Exception $e ) {
			$this->page = new NotFound ( $this->Request, $this->Session);
		}
	}

	public function run( $args=null ) {		
        
	    register_shutdown_function('saveClassCache');
        
		$this->page->init($args);
		$this->page->run();
		
		if ($this->mode != 'web') return;
				
		$htmlBlocks = $this->page->finalize();

		$this->blockonize();
		
		$res = $this->templonize( $htmlBlocks);
		
		if ( $this->page->isCached() ) {
			//echo 'ceching page...';
			$conf = new Config();
			$mc_conf = $conf->get('mc');
			$mc =  Mc::getInstance($mc_conf);
			
			$v = get_class_vars( $className);
		
			if ( isset( $v['CachingKey'])) {
				$key = $this->page->CachingKey;
				$mc->set( $key, $res );
			} 
		}
		echo $res;
		echo '<font color=blue>produce time=' .(  time() - $this->beginsTime + microtime() - $this->beginmTime) . ' in sec </font>';		
	}
		
	/**
	 * the processing blocks
	 *
	 */
	private function blockonize() {
		if (is_array($this->page->getBlockNames() ))
		foreach($this->page->getBlockNames() as $blockName  ) {
			$classfile = LIBLK_PATH.'Block'. $blockName.'.php';
//		echo $classfile;	
			if ( file_exists( $classfile ) ) {
				require_once( $classfile ); //die( $classfile );
				$name = 'Block'.$blockName;
				
				$class = new ReflectionClass( $name );
		        $blockClass = $class->newInstance( $this->Request, $this->Session );			
//				var_dump($blockClass);
				$blockClass->init();
				$blockClass->run();
				//echo "<font color=\"red\">". htmlspecialchars(var_export($blockClass->getHtml(), true)) ."</font>"; 
				$this->bindBlockData[$blockName] = $blockClass->getHtml();
//				var_dump($blockName);
			} else {
				$filename = TPL_PATH.'block/'.$blockName.'.tpl';
//				echo $filename;
				if ( file_exists( $filename ))	 {
					$this->bindBlockData[$blockName] = file_get_contents($filename);
				} else {
					throw new Exception( "template [$blockName] not found in the $filename" );
					//$this->bindBlockData[$blockName] = "template [$blockName] not found in the $filename";	
				}
			}
		}
	}
	
	
	private function templonize( $htmlBlocks) {
		
		//$tpl = new blitz( TPL_PATH.'main.tpl' );
		$tpl = new Template( TPL_PATH.'layout/'. $this->page->getLayoutName().'.tpl' );

		//var_dump( array_keys($this->page->getBindGlobal()) );
		$out = $this->bindBlockData + $this->page->getBindGlobal();
//
//		foreach ( $out as $key => $item  ){
//		  $tpl->block($key, $item);    
//		}
		
        $tpl->set($this->bindBlockData);
        
		foreach ( $htmlBlocks as $key => $item  ){
		
			if (  is_array( $item ) ) {
				foreach ( $item as $subitem ) {
//				    echo "$key<br>\n";
					$tpl->block($key  , $subitem );
				}
			} else {
				$tpl->block($key  ,array( $key=> $item) );
			
			}
		}		

//		$tpl->iterate('/');
		
		return $tpl->parse();
	}
	
	
}
