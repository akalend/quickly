<?
/**
 * ����������� ����� ��������
 * ����� ������� ����������
 * 
 *  
 */
abstract class  basePage {

	protected 	$Request, 
				$Session,
				$View,
				$mc,
				$Model,
				$BindGlobalData=array(),
				$_Cached = false,
				$layout = 'main',
				$blockNames = null,
				$URL;

	
	/**
	 * ����������� ������
	 *
	 * @param Request $Request - ������ �������
	 * @param Session $Session	- ����� ������
	 */
	public function __construct( Request $Request, Session $Session) {
		$this->Request=$Request;		
		$this->Session = $Session;
		$this->View= new View($Request,$Session);
	}
	
	
	/**
	 * �������� ������ � ����������� �������
	 *
	 * @param string $block - ������������ �����
	 * @param array $set - ������ ��� �������� 
	 */
	function bindGlobal( $block, array $set ) {
		
		$this->BindGlobalData[$block] = array($set);
	}

	/**
	 * ���� ����� ������ ���� �������������
	 *
	 */
	abstract  function run();
	
	/**
	 * �������������� ��������
	 *
	 */
	public  function init($args=null) {
		//$this->args = $args;
		
		if ( $args && isset( $this->args )) {
			foreach (  $this->args as $key => $value) {
		 	if (array_key_exists( $key, $args ))
		 		$this->args[$key] = $args[$key];
		 }
		}
		/*
		 if (isset( $this->args ))
		  foreach (  $this->args as $key => $value) {
		 	if (array_key_exists( $key, $_SERVER ))
		 		$this->args[$key] = $_SERVER[$key];
		 }
		*/
		 if ( isset( $this->template_name ) )
		 	$this->View->setTemplateName($this->template_name);
		 
		/*	mc �� �����
		 $conf = new Config();
		 $mc_conf = $conf->get('mc');
		 
		 Mc::getInstance($mc_conf);
		 */
		 
	}
	/**
	 * return the layout name without extention
	 *
	 * @return string Layout name
	 */
	public function getLayoutName() {
		return $this->layout;
	}
	
	/**
	 * return the bind data for layout template
	 *
	 * @return array BindGlobalData
	 */
	public function getBindGlobal() {
		return $this->View->getGlobal();
	}

	/**
	 * return block names for layout
	 *
	 * @return array blockNames
	 */
	public function getBlockNames() {
		return $this->blockNames;
	}
	
	/**
	 * �finalize the page
	 *
	 */
	public  function finalize() {
		$res = $this->View->finalize();

		// fix db 
		if ($this->Model)
			$res['db'] = $this->Model->finalize();			
		$res = $res + $this->BindGlobalData;

		return $res;
		
	}

	/**
	 * redirect �� ����� ��������
	 *
	 * @param string $url - ��� �������� ��������
	 * @param string $query - �������� ������ �������
	 */
	protected function redirectTo($url, $query = '') {
		
		$class = new $url($this->Request, $this->Session);

		if ( is_string( $query) ) {
			if ($query != '') 
			  $query = '?'. $query;

			  $header = 'Location: http://'. $_SERVER['SERVER_NAME'] .'/'. $class->getUrl .$query;

		}
		elseif (is_array($query))  {

			$query['server'] = $_SERVER['SERVER_NAME'];
			$b = new blitz();
			$TPL = '{{BEGIN url}}Location: http://{{server}}'.$class->getUrl().'{{IF error}}?error=&login={{login}}&psw=&{{psw}}{{END}}{{END}}';

			$b->load($TPL);
			$b->block('url', $query);
			$header = $b->parse();	
			
		} else 	{
//			var_dump(  $url, $query );
			throw new Exception( 'not corerct url data' );
		}
		/*
		echo '<pre>';
		print_r( 
		debug_backtrace()
		);
		*/
		//echo $header; exit;
		
		header( $header );
		//@TODO
		//�������� ���� ���-�� ��������������
		exit();
	}
	
	public function  getCacheKey() {
		$this->CachingKey;
	}
	
	/**
	 * ���������� true ���� ���������� ���������� ��������
	 *
	 * @return �������� true/false
	 */
	public function isCached() {
		if ($this->_Cached) {
			try {
				return $this->cachingRule();
			} catch (Exception $e) {
				return true;
			}			
		}
		return false;
	}

	/**
	 * ���������� URL�� ������� ��������� ��������
	 *
	 * @return unknown
	 */
	public function getUrl() {
		return $this->URL;
	}
	

	protected function checkIsEmpty(&$data, $field){
		if ( trim($data[$field]) == '' ) {
			$data['error_'.$field] = 'пустое поле';
			return true;
		}
		return false;
	}

	protected function checkIsEQ(&$data, $field1, $field2){
		if ( trim($data[$field1]) != trim($data[$field2]) ) {
			$data['error_'.$field1] = 'не равно';
			return true;
		}
		return false;
	}

	protected function isAutentificate($user_id) {
		$webUser = $this->Session->get('webUser');
		if ( !isset( $webUser['user_id']) ) return false;
		return ($webUser['user_id'] == $user_id);
	}
	
	protected function checkEmail(&$data, $field){
		if ( !preg_match('/^([a-z1-9\-\.]+)@([a-z1-9\-\.]+)\.([a-z]{2,4})$/' , $data[$field])) {
			$data['error_'.$field] = 'ошибка email формата';
			return true;
		}
		return false;
	}
	
	
	
}