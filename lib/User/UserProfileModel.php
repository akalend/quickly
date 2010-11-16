<?

class UserProfileModel extends DbModel {
	
	const SQL_SELECT_WELL = 'SELECT user_id,name
			FROM userProfile 
			WHERE reiting > 0
			ORDER BY reiting 
			{{IF limit}}LIMIT {{limit}}{{END}}';
	
	const SQL_SELECT_CHECK = "SELECT user_id,name, nick 
		FROM userProfile 
		WHERE nick ='{{s(login)}}' AND `password` = '{{s(psw)}}'";
	
	const SQL_SELECT_PROFILE = "SELECT user_id,name, 
		last_name, nick,  birthdate , data, is_avatar 
		FROM userProfile 
		WHERE user_id = {{i(user_id)}}";

	const SQL_UPDATE = "UPDATE  userProfile
		SET 
		`name`='{{s(name)}}',
		 `data` ='{{s(data)}}'
		 {{IF birthdate}},`birthdate` = '{{s(birthdate)}}'{{END}}
		 {{IF is_avatar}},is_avatar=1{{END}}
		WHERE `user_id` ={{i(user_id)}};";
	
	
	protected $user_id=null;
	
	public function __construct( $user_id = null) {
		parent::__construct();
		$this->user_id = $user_id;
	}
	
	public function getPhotoWell() {
		return $this->exec( self::SQL_SELECT_WELL  );		
 	}
	
 	public function checkPassword( $data) { 		
 		return $this->exec( self::SQL_SELECT_CHECK  , $data );	
 	}
 	
 	
 	public function save($data) {
 		
 		$cfg = new Config('profile', 'fields');
 		$fields = $cfg->getSection();
 		
 		$profileData = array();
 		foreach ( $fields as $key ) {
 			if ( array_key_exists( $key, $data ) )
 				$profileData[$key] = iconv('CP1251', 'UTF8',$data[$key]);	
 		}
 		
 		if ( ! isset( $data['user_id']) )
 			$data['user_id'] = $this->user_id;
 		$data['data'] = json_encode( $profileData );
 		
 		if ($data['birthdate'] == ' 0-00-00')
 			$data['birthdate'] = false;
 		
 		return $this->exec( self::SQL_UPDATE  , $data );	
 		
 	}
 	
 	public function getProfile($user_id = null) {
 		if ( is_null( $user_id))
 			$user_id = $this->user_id;

 		if ( !is_numeric( $user_id  ))
 			throw new Exception( 'the absent user_id');  
 		
 		 $res = $this->exec(  self::SQL_SELECT_PROFILE , array( 'user_id'=> $user_id )  );

		 if (!isset($res[0]))
		 	return $res;
 		 
 		$birthdate = $res[0]['birthdate'];
 		
 		$dt = new FormDate( $birthdate );
 		$res[0]['birthdate'] = $dt->build();

 		$res[0]['years'] = $dt->getY();

 		 if ( $res[0]['is_avatar'] )
 		 	$res[0]['avatar'] = $user_id .'.jpg';
 		
 		
 		 $json = $res[0]['data'];
 		 if ( !$json)
 		 	return $res;
 		 	
 		 $data = json_decode( $json );
 		 
 		 foreach (  $data as $k=>$v ){
 		 	$res[0][$k] =  iconv( 'UTF8', 'CP1251', $v);	
 		 }
 		 unset($res[0]['data']);
 
 		 
 		 return $res;
 	}
}