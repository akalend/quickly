<?

class UserModel extends DbModel {

	const DAY = 86400; // 24 * 3600 sec in day
	
	const salt = '#@u2Z',
		code_salt = '\a12w';
	
	const SQL_ADD = "INSERT INTO user ( login,password,email,code,created )
					VALUES ( '{{s(login)}}', '{{s(password)}}', '{{s(email)}}', '{{s(code)}}' , {{time}} )";
	
	const SQL_UserProfile_ADD = "INSERT INTO userProfile ( nick )
					VALUES ( '{{s(login)}}' );";
	
	const SQL_AFFECTED = "SELECT found_rows() as rows";
	
	const SQL_SELECT_CHECK = "SELECT user_id
		FROM user
		WHERE  is_active AND  login ='{{s(login)}}' AND `password` = '{{s(psw)}}'";
		
	const SQL_UPDATE_ACTIVATE = "UPDATE  user
		SET 
		`is_active`=1,
		code=''
		WHERE `code` ='{{s(code)}}' AND `created` < {{i(expire)}};";
	

	protected $user_id=null;
	
	public function __construct( $user_id = null) {
		parent::__construct();
		$this->user_id = $user_id;
	}
	
 	public function add(array &$data) { 		
 		$data['code'] = $this->getCode( $data );
 		$data['password'] = $this->getMd5( $data['psw'] );	 
 		$data['time'] = time();
 		
 		$this->init();
 		$this->start();
 		if (!$this->exec( self::SQL_ADD , $data )) {
 			$this->rollback();
 			return;
 		}
 		   
 		if (!$this->exec( self::SQL_UserProfile_ADD ,$data )) {
 			$this->rollback();
 			return ;
 		}
 		$this->commit();
 		
 		return ;
 	}

	public function activate( $data) {
		$data['expire'] = time()+self::DAY ;
		$this->exec(  self::SQL_UPDATE_ACTIVATE , $data);
		return true;
	}
 	
 	
 	public function checkPassword( $data) { 		
 		$data['psw'] = $this->getMd5( $data['psw'] );
 		$res = $this->exec(  self::SQL_SELECT_CHECK, $data); 
 		return $res;
 	}
 	
 	public  function getMd5( $str ) {
 		return md5( self::salt . $str );
 	}
 	
 	private function getCode(array $data ) {
 		return sprintf('%x', crc32( $data['login'] . self::code_salt . $data['email']));
 	}

}