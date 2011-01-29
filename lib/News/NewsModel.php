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
	const SQL_SET_HOT =  "UPDATE news 
	                    SET isHot = 0
						WHERE id = {{id}};";
	
	const SQL_ACTIVATE_NEWS = "UPDATE news 
	                    SET isPublish = 1
						WHERE user_id = {{user_id}} AND id = {{id}};";

	const SQL_SETHOT_NEWS = "UPDATE news 
	                    SET ishot = 1
						WHERE user_id = {{user_id}} AND id = {{id}};";
	
	const SQL_SELECT_BYID = "SELECT *
						FROM news 
						WHERE id = {{id}}";
	
	const SQL_SELECT_NEW_NEWS = "SELECT *
						FROM news 
						WHERE isPublish = 0
						ORDER BY date desc";
	
	const SQL_SELECT_CATEGORY = "SELECT id,title FROM newsCategory";
	
	const SQL_SELECT_MENU_CATEGORY = "SELECT id,title,shortname FROM newsCategory WHERE isMenu";
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
						VALUES( '{{s(title)}}', '{{s(text)}}', {{i(newsCategory)}},NOW(),{{user_id}} )";
	
	const SQL_UPDATE = "UPDATE news SET
	                    title = '{{s(title)}}',
	                    text = '{{s(text)}}', 
	                    city_id = '{{i(city_id)}}', 
	                    cityName = '{{s(city)}}',
	                    tags = '{{s(tags)}}',
	                    newsCategory = {{i(newsCategory)}}
						WHERE id={{i(id)}}";
	
	const SQL_IMG_UPDATE = "UPDATE news SET
	                    haveImage = {{set_img}}
						WHERE id={{i(id)}} AND user_id = {{i(user_id)}}"; 
	
	private $data;
	
	public function setImage($id, $user_id) {
	    $data = array('id' => $id, 'set_img' => 1, 'user_id' => $user_id);    
	    $this->query(self::SQL_IMG_UPDATE, $data);
	    return $this->getRowCount();
	}

	public function unsetImage($id,$user_id) {
	    $data = array('id' => $id, 'set_img' => 0, 'user_id' => $user_id);    
	    $this->query(self::SQL_IMG_UPDATE, $data);
	    return $this->getRowCount();
	}
	
	public function update($data) {
	    $this->query("SET NAMES 'UTF8'"); // TODO fix all tables to UTF-8
	    $this->query(self::SQL_UPDATE, $data);
	    return $this->getRowCount();
	}
	
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
	   if (!$isAdmin) return; // TODO access only admin	   
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

	public function get($id) {	    
	    $this->data = $this->exec( self::SQL_SELECT_BYID , array('id' =>$id) );	    
	    return $this->data[0];	    
	}

	public function getNew() {
	    $this->data = $this->exec( self::SQL_SELECT_NEW_NEWS);
	    return array( 'news' => $this->data );	    
	}
	
	public function getMenu() {
        $conf = new Config();
	    $mc = Mc::getInstance($conf->get('mc'));
	    
	    $data = $mc->get('newsMenu');
	    if (!$data) {
	       $data = $this->exec( self::SQL_SELECT_MENU_CATEGORY );	       
	       $mc->set('newsMenu', $data);
	    }	    	    
	    return $data;
	}
	
	public function getCategory($id = null) {
	    $conf = new Config();
	    $mc = Mc::getInstance($conf->get('mc'));
	    
	    $data = $mc->get('newsCategory');
	    if (!$data) {
	       $data = $this->exec( self::SQL_SELECT_CATEGORY );
	       $mc->set('newsCategory', $data);
	    }
	    if ($id)
	    foreach ($data as &$row) {
	        if ($row['id'] == $id)
	           $row['selected'] = 'selected';
	    }
	    //var_dump($this->data);
	    return $data;	    
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
          if (strlen($txt) < self::ANONS_MIN) 
                        return;
          for ($i = self::ANONS_MIN ; $i < self::ANONS_MAX; $i++) {
            if ($txt[$i] == '.' && $txt[$i+1] == ' ')
                break;
          }
           $item['text'] = substr( $txt, 0,$i). '...';        
	}
}