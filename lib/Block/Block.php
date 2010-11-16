<?php
/**
* the base class for show blocks
*
*/

abstract class Block {
	
	protected 	$Request,
				$Session,
				$bindData=array(),
				$isCached=false;
	
	/**
	 * the constructor of Block class
	 *
	 * @param Request $request - the Request object
	 * @param Session $Session - the Session object
	 */
	function  __construct(Request $request , Session $Session) {
		$this->Request=$request;
		$this->Session=$Session;
	}
	
	/**
	 * this abstract method, must be redefined into derived class
	 *
	 */
	abstract  function run();
	
	/**
	 * the return html block
	 *
	 * @return string HTML code for template
	 */
	public function getHtml() {
		$filename = TPL_PATH . 'block/'.$this->template_name.'.tpl';
		$this->template = new Template( $filename );		

		$this->template->set( $this->bindData );		
		return $this->template->parse();

	}
	
	/**
	 * initialize block
	 *
	 */
	public function init() {
		if ( !isset( $this->template_name ) ) {
			$name = get_class($this);
			if (  substr( $name,0,5 ) == 'Block'  ) {				
				$name = substr( $name,5 );
				$name[0] = strtolower($name[0]);
			}
			
			$this->template_name = $name;
		} 			
	}
	
	/**
	 * bind data to template named block
	 *
	 * @param string $block - blockname
	 * @param mixed $set - iteration set
	 */
	function bind( $block, $set ) {
		
		$this->bindData[$block] = $set;
	}
	
	
}