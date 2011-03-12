<?

class CommentModel extends DbModel {
		
	const SQL_SELECT_BY_NEWS = "SELECT id,text,user_id,date,user_name
					FROM comments c
					WHERE news_id = {{i(news_id)}}";

	const SQL_INSERT = "INSERT INTO comments ( text,user_id,news_id ,date, user_name)
					VALUES ('{{s(comment)}}', {{i(user_id)}}, {{i(news_id)}}, NOW(), '{{user_name}}')";
	
	public function add($data) { 			
		$this->exec( self::SQL_INSERT , $data );
		return $this->getId();
	}
	
	public function get($news_id) { 		
	    return $this->exec( self::SQL_SELECT_BY_NEWS , array('news_id' => $news_id) );
		
	}
	

}