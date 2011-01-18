<?php
/**
 * the example test page
 *
 */
class errorPage extends ajaxPage {
	
	public function run() {
        header('Status: 404 Not Found');
        echo '<div style="color:red; padding-top: 100px; text-align: center; font: 16pt bold; ">404 Not Found</div>';
        exit;				
	}
}