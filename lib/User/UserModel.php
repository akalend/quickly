<?

class UserModel extends DbModel {

	const DAY = 86400; // 24 * 3600 sec in day
	
	const salt = '#@u2Z',
		code_salt = '\a12w';
	
	const SQL_ADD = "INSERT INTO user ( login,password,email,code,ip,created )
					VALUES ( '{{s(login)}}', '{{s(password)}}', '{{s(email)}}', '{{s(code)}}', '{{ip}}', NULL )";
	
	const SQL_UserProfile_ADD = "INSERT INTO userProfile ( nick )
					VALUES ( '{{s(login)}}' );";
	
	const SQL_AFFECTED = "SELECT found_rows() as rows";
	
	const SQL_SELECT_CHECK = "SELECT id,name,login,code
		FROM user
		WHERE  is_active AND  login ='{{s(login)}}' AND `password` = '{{s(psw)}}'";
		
	const SQL_SELECT_CHECK_CODE = "SELECT name,login
		FROM user
		WHERE  is_active AND `id` = '{{i(id)}}' AND code ='{{s(code)}}'";

	const SQL_SELECT_CHECK_EMAIL = "SELECT email,login
		FROM user
		WHERE  `email` = '{{s(email)}}' OR login = '{{s(login)}}'";

	const SQL_UPDATE_ACTIVATE = "UPDATE  user
		SET 
		`is_active`=1
		WHERE `code` ='{{s(code)}}' AND UNIX_TIMESTAMP(`created`) < {{i(expire)}};";
	

	protected $user_id=null;
	private $result;
	
	public function __construct( $user_id = null) {
		parent::__construct();
		$this->user_id = $user_id;
	}
	
 	public function add(array &$data) { 		
 		$data['code'] = $this->getCode( $data );
 		$data['password'] = $this->getMd5( $data['psw'] );	 
// 		var_dump($data); exit;
 		$this->init();
 		$this->start();
 		if (!$this->exec( self::SQL_ADD , $data )) {
 		    $data['error_login'] = 'дублирование данных';
 			$this->rollback();
 			return false;
 		}
 		
 		$this->commit();
 		
 		return true;
 	}

	public function activate( $data) {
		$data['expire'] = time()+self::DAY ;
		$this->exec(  self::SQL_UPDATE_ACTIVATE , $data);
//		var_dump($this->getStat());
//		exit;
		return true;
	}
 	
 	
 	public function checkPassword( $data) { 		
 		$data['psw'] = $this->getMd5( $data['password'] );
 		return $this->exec( self::SQL_SELECT_CHECK, $data); 
 	}
 	
 	public function checkEmailAndLogin( $data) {
 	    $this->result = $this->exec( self::SQL_SELECT_CHECK_EMAIL, $data);
 		return is_null($this->result); 
 	}
    public function testLogin($data) {       
        return $data['login'] == $this->result[0]['login'];
    } 
 	
    public function testEmail($data) {
        return $data['email'] == $this->result[0]['email'];
    } 

    public function checkCode( $data) {
 		return $this->exec( self::SQL_SELECT_CHECK_CODE, $data); 
 	}

 	public  function getMd5( $str ) {
 		return md5( self::salt . $str );
 	}
 	
 	private function getCode(array $data ) {
 		return sprintf('%x%x', crc32( $data['login'] . self::code_salt ), crc32(time()));
 	}

	/**
	 * Email exists
	 *
	 * @return true если существует
	 */
	public function testEmailExist ($email) {
		echo "adsfsadas";
	}

}