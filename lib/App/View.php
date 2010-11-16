<?
/**
 * ����� �����������, ����� ������� ��� �������
 * �� ���� ������������� � ���
 *
 * @author akalend
 * @package quickly
 */

/**
 * ����� View
 * �������� � �������
 * ������ ������ ������ �����������
 *
 */
class View {
		
	private $scalarData,
			$template,
			$template_name,
			$bindData=array(),
			$bindGlobalData=array(),
			$Request, $Session,
			$parsed = array();
	

	/**
	 * ����������� ������ View
	 *
	 */
	function __construct( Request $Request, Session $Session){
		$this->Request = $Request;
		$this->Session=$Session;
	}

	/**
	 * �������� ������ � �������
	 *
	 * @param string $block - ������������ �����
	 * @param  $set - ������ ��� �������� 
	 */
	function bind( $block, $set ) {
		
		if (is_array( $set))
			$this->bindData[$block] = $set;
		else 
			$this->scalarData[$block] = $set;
	}
	
	/**
	 * �������� ������ � ������ (layout) �������
	 *
	 * @param string $block - ������������ ���������
	 * @param $set - ������ 
	 */
	function bindGlobal( $block,  $set ) {
		
		$this->bindGlobalData[$block] = $set;
	}

	/**
	 * return the bind data for layout template
	 *
	 * @return array bind global data
	 */
	function getGlobal() {
		return $this->bindGlobalData;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param string $template_name - ��� �������
	 * 
	 */
	public function setTemplateName($template_name) {

		$this->template_name=$template_name;
	}

	/**
	 *  ����������� template
	 *  ������������ ������� bind 
	 *
	 */
	public function finalize() {
		$this->template = new Template( TPL_PATH.$this->template_name.'.tpl' );		
		$this->template->setRequest($this->Request, $this->Session);
//		
		if ($this->scalarData)
			$this->template->set($this->scalarData);		
		
		foreach ( $this->bindData as $key=>$data ) {
			$this->template->context('/'.$key);		
			$this->template->set( $data );		

//			echo "<b>$key</b><br>\n";		
	
			$this->parsed[$key] =  $this->template->parse();		
		
			$this->template->clean();
		}		
		
		return $this->parsed ;
		
	}
	
}