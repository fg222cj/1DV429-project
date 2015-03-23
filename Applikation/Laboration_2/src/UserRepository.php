<?php
require_once('./src/User.php');
require_once ('./src/Repository.php');

class UserRepository extends Repository {
	
	private static $id = 'ID';
	private static $username = 'username';
	private static $password = 'password';
	private static $role = 'role';
	
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
			
			$user = new User($result[self::$id], $result[self::$username], $result[self::$password], $result[self::$role]);
				
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
		
			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$username . " = ?";
			$params = array($username);
	
			$query = $db -> prepare($sql);
			$query -> execute($params);
	
			
			if($result = $query -> fetch()) {
				$user = new User($result[self::$id], $result[self::$username], $result[self::$password], $result[self::$role]);
				return $user;
			}
			
			return null;
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
				$user = new User($row[self::$id], $row[self::$username], $result[self::$password], $result[self::$role]);
				$users[] = $user;
			}
				
			return $users;
		}
		
		catch(PDOException $e) {
			throw new DatabaseException('USER_FETCH');
		}
	}
	
	public function authenticateUser($username, $password) {
		try {
			$db = $this -> connection();
		
			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$username . " = ? AND "  . self::$password . " = ?";
			$params = array($username, $password);
	
			$query = $db -> prepare($sql);
			$query -> execute($params);
	
			if($result = $query -> fetch()) {
				$user = new User($result[self::$id], $result[self::$username], $result[self::$password], $result[self::$role]);
				return $user;
			}
			
			else {
				throw new AuthenticationException();
			}
			
		}
		
		catch(PDOException $e) {
			throw new DatabaseException('USER_AUTH');
		}
	}
	
	public function addUser($user) {
		try
		{
			$db = $this -> connection();

			if(!$this->userExists($user->getUsername())) {
			
				$sql = "INSERT INTO " . self::$dbTable . " (" . self::$username . ", " . self::$password . ", " . self::$role . ") VALUES (?, ?, ?)";
				$params = array($user -> getUsername(), $user -> getPassword(), $user -> getRole());
	
				$query = $db -> prepare($sql);
				$query -> execute($params);
				
				$userId = $db->lastInsertId();
				
				return true;
			}
			else {
				return false;
			}
			// Fetch the added user and return it. Remove these rows if we end up not needing them.
			//$user = $this->getUserByID($userId);
			//return $user;
		}
		
		catch(PDOException $e)
		{
			throw new DatabaseException('USER_INSERT');
		}
	}
	
	public function userExists($username) {
		$user = $this->getUserByName($username);
		return isset($user);
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