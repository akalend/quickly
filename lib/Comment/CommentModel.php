<?

class CommentModel extends DbModel {
		
	const SQL_SELECT = "SELECT id,parent_id,h2_id,fullname, innername 
					FROM category c
					WHERE is_hidden=0
					order by parent_id";

	const SQL_INSERT = "INSERT INTO comments ( text,user_id,news_id ,date)
					VALUES ('{{s(comment)}}', {{i(user_id)}}, {{i(news_id)}}, NOW())";
	
	public function add($data) { 			
		$this->exec( self::SQL_INSERT , $data );
		return $this->getId();
	}
	
	public function getTitle() { 		
		return $this->title;
	}
	

}