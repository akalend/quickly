<?php
/**
 * the example test page
 *
 */
class blockPage extends basePage {
	
	protected $args = array(
		'blocknum' => null,
	);
	
	protected $template_name='';
	protected $URL = '/block/';
	
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);
		
	}
	
	public function run() {

	    $text = "this block text # {$this->args['blocknum']}";
	    $conf = new Config();
	    
	    $mc = Mc::getInstance($conf->get('mc'))->set( $this->args['blocknum'], $text);
	    echo $text;
	    echo '<br>write to chache';
	    exit;
	}
	

	
}