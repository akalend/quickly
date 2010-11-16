<?php
/**
 * the example test script
 *
 */
abstract class baseScript {
	
	protected $Request;
	protected $args = array();
	
		
	/**
	 * @param IRequest $Request - data request
	 */
	public function __construct(Request $Request=null ) {
		$this->Request=$Request;
	}
	
	public  function init($args=null) {
		if ( $args && isset( $this->args )) {
			foreach (  $this->args as $key => $value) {
		 	if (array_key_exists( $key, $args ))
		 		$this->args[$key] = $args[$key];
		 }
		}
		
	}
	
	/**
	 * call for all scripts
	 *
	 */
	abstract function run();
}