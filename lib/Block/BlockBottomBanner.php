<?php
/**
* the base class for blocks
*
*/

class BlockBottomBanner extends Block {
		
	// if $template_name is't set the template name 
	// set the class name without word 'Block'
	// $template_name = 'leftBanner';
	
	/**
	 * the some actions depended Data and url path
	 *
	 */
	public function run() {
		
		$this->bind('url', $this->Request->getUri());	
		
	}
		
}