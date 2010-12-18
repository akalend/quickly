<?php
/**
 * the example test page
 *
 */
class uploadPage extends ajaxPage {
	
	protected $args=array(
	               'upload_file_name' => null,
	               'filename' => null,
	               );
	
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);
		
	}
	
	public function run() {
	    $log = Log::getInstance();
	    $log->toLog($_POST);
	    $log->toLog($this->args);
	    
	    die('{"success":true}');
	}
	
	
}