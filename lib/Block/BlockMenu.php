<?php
/**
* the base class for blocks
*
*/

class BlockMenu extends Block {

	public function run() {
		
		$NM = new NewsModel();
		$menu = $NM->getMenu();
		$this->bind('block',array('menu' =>$menu));
	}
		
}