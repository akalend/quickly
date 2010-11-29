<?php
/**
 * the example test page
 *
 */
class contentPage extends basePage {
	
	protected $args = array(
		'blocknum' => null,
	);
	
	protected $template_name='';
	protected $URL = '/block/';
	
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);
		
	}
	
	public function run() {
	    
	    echo '<br>some content page';
	    echo '<pre>uri='.$this->Request->getUri();
	    
	    exit;
	}
	

	
}