<?
/**
 * ����������� ����� ��������
 * ����� ������� ����������
 * 
 *  
 */
abstract class  ajaxPage {

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
	public function __construct( Request $Request = null , Session $Session = null) {
		$this->Request=$Request;
		$this->Session = $Session;		
		$this->View = array();
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

		/*	mc �� �����
		 $conf = new Config();
		 $mc_conf = $conf->get('mc');
		 
		 Mc::getInstance($mc_conf);
		 */
		 
	}

	protected function redirectTo($url, $query = '') {
		
		$class = new $url($this->Request, $this->Session);

		if ( is_string( $query) ) {
			if ($query != '') 
			  $query = '?'. $query;

			  $header = 'Location: http://'. $_SERVER['HTTP_HOST'] .'/'. $class->getUrl() .$query;

		}
		elseif (is_array($query))  {

			$query['server'] = $_SERVER['HTTP_HOST'];
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
//		echo $header;
		Header( $header );
		//@TODO
		//�������� ���� ���-�� ��������������
		exit();
	}	
		
	public function getUrl() {
		return $this->URL;
	}
	
	/**
	 * �finalize the page
	 *
	 */
	public  function finalize() {
		echo  json_encode($this->View);
        exit;
		// fix db 
		
	}
	
}