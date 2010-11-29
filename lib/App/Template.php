<?
/**
 * ����� ������� Blitz
 *
 * @author akalend
 * @package quickly
 */

/**
 * ����� ������� Blitz
  *
 */
class Template extends blitz {
	private $Request=null;	
	private $Session=null;	
	
	function __construct($T) {
		parent::__construct($T);
	}
	
	public function dump($context ,  $mode =0) {
		if ($mode)
			return "<pre>".htmlspecialchars( var_export( $context,true))."</pre>";;
		return "<pre>". var_export( $context,true)."</pre>";;	
	}
	
	public function setRequest(Request $Request,Session $Session) {
		
		$this->Request=$Request;
		$this->Session=$Session;
	}
	

	public function __call($name, $args) {
		$name[0] = strtoupper( $name[0]);
		$className = 'Block'.$name;
		
		$class = new $className($this->Request, $this->Session);
		$class->init();
		$class->run();
		return $class->getHtml();
		
	}
}
