<?

class NewsModel extends DbModel {
	const ANONS_MIN = 512;
	const ANONS_MAX = 2048;
		
	const SQL_SELECT = "SELECT *
						FROM news
						WHERE  isPublish = 1
						ORDER BY date DESC
						LIMIT 4";

	const SQL_SELECT_MYNEWS = "SELECT *
						FROM news 
						WHERE user_id = {{id}}
						ORDER BY date desc";
	
	const SQL_DELETE_NEWS = "UPDATE news 
	                    SET isPublish = 0
						WHERE {{IF is_admin}}user_id = {{user_id}} AND {{END}}id = {{id}};";
	
	const SQL_ACTIVATE_NEWS = "UPDATE news 
	                    SET isPublish = 1
						WHERE user_id = {{user_id}} AND id = {{id}};";

	const SQL_SETHOT_NEWS = "UPDATE news 
	                    SET ishot = 1
						WHERE user_id = {{user_id}} AND id = {{id}};";
	/*
 CREATE TABLE `news` (
  `id` int(11) NOT NULL auto_increment,
  `news_category` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `text` tinytext NOT NULL,
  `user_id` int(11) default NULL COMMENT 'the author of news',
  `img_id` int(11) default NULL COMMENT '?????? ????? ??? ???? ?? ?????, img ???????? = id ???????.',
  `ishot` tinyint(4) default NULL,
  `date` datetime default NULL,
 
*/	
	const SQL_INSERT = "INSERT INTO news (title,text, newsCategory,date,user_id) 
						VALUES( '{{s(title)}}', '{{s(text)}}', {{i(newsCategory)}},NOW(), {{user_id}} )";
	
	private $data;
	
	public function deactivate($news_id, $user_id) {
	   $data = array('id' => $news_id, 'user_id' => $user_id);    
	   $this->query(self::SQL_DELETE_NEWS ,$data);
	   return $this->getRowCount();
	}
	
	public function activate($news_id, $user_id, $isAdmin = 0) {
	   $data = array('id' => $news_id, 'user_id' => $user_id, 'is_admin' => $isAdmin);    
	   $this->query(self::SQL_ACTIVATE_NEWS ,$data);
	   return $this->getRowCount();
	}
	
	public function setHot($news_id, $user_id, $isAdmin = 0) {
	   // if (!$isAdmin) return; // TODO access only admin	   
	   $data = array('id' => $news_id, 'user_id' => $user_id, 'is_admin' => $isAdmin);    
	   $this->query(self::SQL_SETHOT_NEWS ,$data);
	   return $this->getRowCount();
	}
	
	public function add($data) {
	    if (!$data['user_id']) return null;
//	    Log::getInstance()->toLog( $data );
//	    Log::getInstance()->toLog( $this->getStat() );
	    $this->query("SET NAMES 'UTF8'");
	    $this->query(self::SQL_INSERT ,$data);
	    return $this->getId();
	}
	
	public function getMy($webUser) {	    
	    $this->data = $this->exec( self::SQL_SELECT_MYNEWS , $webUser );
	    return array( 'news' => $this->data );	    
	}

	    
	public function getHot($part) {
	    $this->data = $this->exec( self::SQL_SELECT );
	    if (!$this->data)
	       return array( 'news' => null );	    
	    foreach ( $this->data as &$item ) {
	       $this->cutText($item);
	       $item['part']=$part;
	    }
	       	 
	    return array( 'news' => $this->data );	    
	}    

	private function cutText(&$item) {
          $txt = $item['text'];
          for ($i = self::ANONS_MIN ; $i < self::ANONS_MAX; $i++) {
            if ($txt[$i] == '.' && $txt[$i+1] == ' ')
                break;
          }
           $item['text'] = substr( $txt, 0,$i). '...';        
	}
}