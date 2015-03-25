<?php
require_once('./src/LoginLog.php');
require_once ('./src/Repository.php');

class LogRepository extends Repository {
	
	private static $id = 'ID';
	private static $username = 'username';
	private static $timedate = 'timedate';
	private static $IP = 'IP';
	private static $success = 'success';
	
	private static $dbTable = 'loginlog';
	

	public function addLoginLog($loginLog) {
		try
		{
			
		$db = $this -> connection();
		
			$sql = "INSERT INTO " . self::$dbTable . " (" . self::$username . ", " . self::$IP . ", " . self::$success . ") VALUES (?, ?, ?)";
			$params = array($loginLog -> getUsername(), $loginLog -> getIP(), $loginLog -> getSuccessCode());

			$query = $db -> prepare($sql);
			$query -> execute($params);
			
			$userId = $db->lastInsertId();
			
			return true;
		}
		
		catch(PDOException $e)
		{
			die($e->getMessage());
			throw new DatabaseException('LOGINLOG_INSERT');
		}
	}
	
	public function checkLoginAttempts($IP) {
		try {
			$db = $this -> connection();
			
			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$IP . " = ? AND (". self::$timedate . " > CURDATE()-500);";
			$params = array($IP);
	
			$query = $db -> prepare($sql);
			$query -> execute($params);
	
			$result = $query -> fetch();
			
			$loginLog = new LoginLog($result[self::$id], $result[self::$username], $result[self::$timedate], $result[self::$IP], $result[self::$success]);
				
			return $loginLog;
		}
		
		catch(PDOException $e) {
			throw new DatabaseException('LOGINLOG_FETCH');
		}
	}
}