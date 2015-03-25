<?php
require_once('./src/LoginLog.php');
require_once ('src/AdminLog.php');
require_once ('./src/Repository.php');

class LogRepository extends Repository {
	
	private static $id = 'ID';
	private static $username = 'username';
	private static $timedate = 'timedate';
	private static $IP = 'IP';
	private static $success = 'success';
	
	private static $userId = "userid";
	private $oldRole = "oldrole";
	private $newRole = "newrole";
	
	private static $dbTable = 'loginlog';
	private static $dbTableAdmin = "adminlog";
	

	public function addLoginLog($loginLog) {
		try
		{
			
		$db = $this -> connection();
		
			$sql = "INSERT INTO " . self::$dbTable . " (" . self::$username . ", " . self::$IP . ", " . self::$success . ") VALUES (?, ?, ?)";
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
	
	public function checkLoginAttempts($IP) {
		try {
			$db = $this -> connection();
			
			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$IP . " = ? AND (". self::$timedate . " > CURDATE()-500);";
			$params = array($IP);
	
			$query = $db -> prepare($sql);
			$query -> execute($params);
	
			$result = $query -> fetch();
			

			$loginLogs = array();
			
			foreach($result as $row)
			{
				$loginLog = new LoginLog($result[self::$id], $result[self::$username], $result[self::$timedate], $result[self::$IP], $result[self::$success]);
				$loginLogs[] = $loginLog;
			}
				
			return $loginLogs;
		}
		
		catch(PDOException $e) {
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