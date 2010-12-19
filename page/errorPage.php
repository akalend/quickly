<?php
/**
 * the example test page
 *
 */
class errorPage extends ajaxPage {
	
	public function run() {
        header('Status: 404 Not Found');
        exit;				
	}
}