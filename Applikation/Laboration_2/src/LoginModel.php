<?php

//Är användaren inloggad?
//Får användaren logga in?
//Vem är inloggad?

require_once("src/connectionSettings.php");

class LoginModel {
	private $loggedIn = "loggedIn";
	private $browser = "browser";
	private $username = "";
	protected $dbConnection;
	protected $dbTable = "user";
	private static $sUsername = "username";
	private static $sPassword = "password";
	
	public function __construct(){
		
	}
	
	// Returnerar true om användaren redan är inloggad
	public function userLoggedInStatus(){
	    // Kollar så ingen sessionsstöld har skett
        if(isset($_SESSION[$this->browser])){
            if ($_SESSION[$this->browser] != $_SERVER["HTTP_USER_AGENT"]){
                return false;
            }
		}
		
		if(isset($_SESSION[$this->loggedIn]) && $_SESSION[$this->loggedIn] == 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	// Förstör sessionen
	public function destroySession(){
            session_unset();
            session_destroy();
	}
	
	//Hämtar användarnamnet på personen inloggad i sessionen
	public function getLoggedInUser(){
		if(isset($_SESSION["username"])){
			return $_SESSION["username"];
		}
	}
	
	// Loggar in
	public function login($username, $password){
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;

		$linesArr = array();
		$fh = fopen("src/users.txt", "r");


		$db = $this->connection();
		$checkIfUsernameExists = "SELECT * from " . $this->dbTable . " WHERE " . self::$sUsername . " ='" . $username . "' AND " . self::$sPassword . "='" . $password . "';";
		$userQuery = $db->prepare($checkIfUsernameExists);
		$userQuery->execute();
		$existingRow = $userQuery->fetch(PDO::FETCH_ASSOC);
		if(!$existingRow){
			return false;
		}
		else{
			$_SESSION[$this->loggedIn] = 1;
		    $_SESSION[$this->browser] = $_SERVER["HTTP_USER_AGENT"];
			return true;
		}
	}
	
	public function addUser(User $user) {

	try{
		$db = $this->connection();
	
		// Kör en query där jag selectar alla användarnamn med värdet som användaren skrev in
		$checkIfUsernameExists = "SELECT " . self::$sUsername . " from " . $this->dbTable . " WHERE " . self::$sUsername . " ='" . $user->getUsername() . "';";
		$userQuery = $db->prepare($checkIfUsernameExists);
		$userQuery->execute();
		$existingRow = $userQuery->fetch(PDO::FETCH_ASSOC);
		
		// Om inte queryn returnerar något så finns inte användarnamnet i databasen redan
		if(!$existingRow){
	    	$sql = "INSERT INTO $this->dbTable (" . self::$sUsername . ", " . self::$sPassword . ") VALUES (?, ?)";
	
			$params = array($user->getUsername(), $user->getPassword());
	
			$query = $db->prepare($sql);
		
			$query->execute($params);
			return true;
		
		}
		else{
			return false;
		}

		} catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
		
	}
	
	protected function connection() {
		if ($this->dbConnection == NULL)
			$this->dbConnection = new \PDO(\dbSettings::$DB_CONNECTION, \dbSettings::$DB_USERNAME, \dbSettings::$DB_PASSWORD);
		
		$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
		return $this->dbConnection;
	}
	
		// Kollar om det går att registrera
	public function tryRegister($username, $password, $repeatedPassword){

	}
}