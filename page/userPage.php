<?php

class userPage extends basePage {
		
	protected  $template_name='user';
	protected $URL = '/user/{{user_id}}';

	protected $args = array(
		'user_id' => null,
	);
	
	protected  $_Cached = true;
	
	public  $CachingKey = '/user/$user_id';

	/**
	 * конструктор страницы User
	 *
	 * @param IRequest $Request - данные запроса
	 * @param Session $Session  - сессионные данные
	 */
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);;
		
	}
	
	
	/**
	 * данный метод только у тех страниц
	 * которые необходимо кешировать
	 * задает кешировать стр или нет
	 * и прочие правила кеширования.
	 *
	 * @return true/false
	 */
	protected  function cachingRule() {
		$pos = strpos( $this->CachingKey , '$');
		if ( $pos ) {
			$this->CachingKey = str_replace( '$user_id',$this->args['user_id'] ,$this->CachingKey );
		}
		return true;
	}

	
	/**
	 * вызывается для каждой страницы
	 *
	 */
	public function run() {
		
		$this->Model = new UserProfileModel( $this->args['user_id']);
		$data = $this->Model->getProfile();   
		$data[0]['access'] = $this->isAutentificate($this->args['user_id'] );
		$data[0]['server'] = $this->Request->getServer('SERVER_NAME');
		$this->View->bind('page',  $data);

	}
}