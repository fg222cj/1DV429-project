<?php
require_once("Post.php");
require_once("src/Repository.php");

class ForumRepository extends Repository {
	private static $id = "id";
	private static $parentId = "parentid";
	private static $title = "title";
	private static $text = "text";
	private static $author = "author";
	private static $timePosted = "timeposted";
	
	private static $dbTable = "forum";
	
	public function getPostByID($postId)
	{
		try {
			$db = $this -> connection();
			
			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$id . " = ?";
			$params = array($postId);
	
			$query = $db -> prepare($sql);
			$query -> execute($params);
	
			$result = $query -> fetch();
			
			$post = new Post($result[self::$id], $result[self::$parentId], $result[self::$title], $result[self::$text], $result[self::$author], $result[self::$timePosted]);
				
			return $post;
		}
		
		catch(PDOException $e) {
			throw new DatabaseException('POST_FETCH');
		}
	}
	
	public function getPostsByParent($parentId) {
		try {
			$db = $this -> connection();
		
			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$parentId . " = ?";
			$params = array($parentId);
	
			$query = $db -> prepare($sql);
			$query -> execute($params);
	
			$result = $query -> fetchAll();
			
			$posts = array();
			
			foreach($result as $row)
			{
				$post = new Post($row[self::$id], $row[self::$parentId], $row[self::$title], $row[self::$text], $row[self::$author], $row[self::$timePosted]);
				$posts[] = $post;
			}
				
			return $posts;
		}
		
		catch(PDOException $e) {
			throw new DatabaseException('POST_FETCH');
		}
	}
	
	public function getTopPosts() {
		try {
			$db = $this -> connection();
		
			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$parentId . " = 0";
			$params = array();
	
			$query = $db -> prepare($sql);
			$query -> execute($params);
	
			$result = $query -> fetchAll();
			
			$posts = array();
			
			foreach($result as $row)
			{
				$post = new Post($row[self::$id], $row[self::$parentId], $row[self::$title], $row[self::$text], $row[self::$author], $row[self::$timePosted]);
				$posts[] = $post;
			}
				
			return $posts;
		}
		
		catch(PDOException $e) {
			throw new DatabaseException('POST_FETCH');
		}
	}
	
	public function insertPost($post) {
		try
		{
			$db = $this -> connection();
			
			$sql = "INSERT INTO " . self::$dbTable . " (" . self::$parentId . ", " . self::$title . ", " . self::$text . ", " . self::$author . ") VALUES (?, ?, ?, ?)";
			$params = array($post -> getParentId(), $post -> getTitle(), $post -> getText(), $post -> getAuthor());

			$query = $db -> prepare($sql);
			$query -> execute($params);
			
			return true;
		}
		
		catch(PDOException $e)
		{
			throw new DatabaseException('POST_INSERT');
		}
	}
	
	public function deletePost($post) {
		try {
			$db = $this -> connection();
			
			$sql = "DELETE FROM " . self::$dbTable . " WHERE " . self::$id . " = ?";
			$params = array($post -> getPostId());
			
			$query = $db -> prepare($sql);
			$query -> execute($params);
			
			return true;
		}
		
		catch(PDOException $e)
		{
			throw new DatabaseException('POST_DELETE');
		}
	}
	
}

?>