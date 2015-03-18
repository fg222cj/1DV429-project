<?php
require_once('./src/User.php');
require_once ('./src/Repository.php');

class UserRepository extends Repository {
	
	private static $id = 'ID';
	private static $username = 'username';
	private static $password = 'password';
	
	private static $dbTable = 'user';
	
	// Fetch user by ID.
	public function getUserByID($userId)
	{
		try {
			$db = $this -> connection();
			
			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$id . " = ?";
			$params = array($userId);
	
			$query = $db -> prepare($sql);
			$query -> execute($params);
	
			$result = $query -> fetch();
			
			$user = new User($result[self::$id], $result[self::$username], $result[self::$password]);
				
			return $user;
		}
		
		catch(PDOException $e) {
			throw new DatabaseException('USER_FETCH');
		}
	}
	
	// Fetch user by name.
	public function getUserByName($username)
	{
		try {
			$db = $this -> connection();
		
			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$name . " = ?";
			$params = array($userId);
	
			$query = $db -> prepare($sql);
			$query -> execute($params);
	
			$result = $query -> fetch();
			
			$user = new User($result[self::$id], $result[self::$username], $result[self::$password]);
				
			return $user;
		}
		
		catch(PDOException $e) {
			throw new DatabaseException('USER_FETCH');
		}
	}
	
	// Fetch all users.
	public function getAllUsers()
	{
		try {
			$db = $this -> connection();
		
			$sql = "SELECT * FROM " . self::$dbTable;
			$params = array();
	
			$query = $db -> prepare($sql);
			$query -> execute($params);
	
			$result = $query -> fetchAll();
			
			$users = array();
			
			foreach($result as $row)
			{
				$user = new User($row[self::$id], $row[self::$username], $result[self::$password]);
				$users[] = $user;
			}
				
			return $users;
		}
		
		catch(PDOException $e) {
			throw new DatabaseException('USER_FETCH');
		}
	}
	
	public function addUser($user) {
		try
		{
			$db = $this -> connection();

			$sql = "INSERT INTO " . self::$dbTable . " (" . self::$username . ", " . self::$password . ") VALUES (?, ?)";
			$params = array($user -> getUsername(), $user -> getPassword());

			$query = $db -> prepare($sql);
			$query -> execute($params);
			
			$userId = $db->lastInsertId();
			
			// Fetch the added user and return it. Remove these rows if we end up not needing them.
			//$user = $this->getUserByID($userId);
			//return $user;
		}
		
		catch(PDOException $e)
		{
			throw new DatabaseException('USER_INSERT');
		}
	}
	
	public function changePassword($user, $newpassword) {
		try
		{
			$db = $this -> connection();

			$sql = "UPDATE " . self::$dbTable . " SET " . self::$password . "=? WHERE " . self::$id ."=?";
			$params = array($newpassword, $user -> getUserId());

			$query = $db -> prepare($sql);
			$query -> execute($params);
		}
		catch (PDOException $e)
		{
			throw new DatabaseException('PASSWORD_CHANGE');
		}
	}
}