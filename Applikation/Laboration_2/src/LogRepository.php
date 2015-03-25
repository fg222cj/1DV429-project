<?php
require_once('./src/LoginLog.php');
require_once('./src/PasswordUpdateLog.php');
require_once ('src/AdminLog.php');
require_once ('./src/Repository.php');

class LogRepository extends Repository {
	
	private static $id = 'ID';
	private static $userId = 'userID';
	private static $username = 'username';
	private static $timedate = 'timedate';
	private static $IP = 'IP';
	private static $success = 'success';
	
	private static $userId = "userid";
	private $oldRole = "oldrole";
	private $newRole = "newrole";
	
	private static $dbTableLogin = 'loginlog';
	private static $dbTableAdmin = "adminlog";
	private static $dbTablePassword = 'passwordupdatelog';
	

	public function addLoginLog($loginLog) {
		try
		{
			
		$db = $this -> connection();
		
			$sql = "INSERT INTO " . self::$dbTableLogin . " (" . self::$username . ", " . self::$IP . ", " . self::$success . ") VALUES (?, ?, ?)";
			$params = array($loginLog -> getUsername(), $loginLog -> getIP(), $loginLog -> getSuccessCode());

			$query = $db -> prepare($sql);
			$query -> execute($params);
			
			return true;
		}
		
		catch(PDOException $e)
		{
			die($e->getMessage());
			throw new DatabaseException('LOGINLOG_INSERT');
		}
	}
	
	public function addPasswordUpdateLog($passwordUpdateLog){
		try {
			
		$db = $this -> connection();
		
			$sql = "INSERT INTO " . self::$dbTablePassword . " (" . self::$userId . ", " . self::$IP . ") VALUES (?, ?)";
			$params = array($passwordUpdateLog -> getUserId(), $passwordUpdateLog -> getIP());

			$query = $db -> prepare($sql);
			$query -> execute($params);
			
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
			
			$sql = "SELECT COUNT(*) FROM " . self::$dbTableLogin . " WHERE " . self::$IP . " = ? AND " . self::$timedate . " > DATE_SUB(NOW(), INTERVAL 5 MINUTE) AND " . self::$success ." = 0";
			$params = array($IP);
	
			$query = $db -> prepare($sql);
			$query -> execute($params);
	
			$result = $query -> fetch();
					
			return $result[0];
		}
		
		catch(PDOException $e) {
			die($e->getMessage());
			throw new DatabaseException('LOGINLOG_FETCH');
		}
	}
	
	public function addAdminLog($adminLog) {
		try
		{
			
		$db = $this -> connection();
		
			$sql = "INSERT INTO " . self::$dbTableAdmin . " (" . self::$userId . ", " . self::$oldrole . ", " . self::$newRole . ") VALUES (?, ?, ?)";
			$params = array($adminLog -> getUserId(), $adminLog  -> getOldRole(), $adminLog  -> getNewRole());

			$query = $db -> prepare($sql);
			$query -> execute($params);
			
			return true;
		}
		
		catch(PDOException $e)
		{
			throw new DatabaseException('ADMINLOG_INSERT');
		}
	}
}