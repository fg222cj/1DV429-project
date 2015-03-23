<?php

//Är användaren inloggad?
//Får användaren logga in?
//Vem är inloggad?

require_once("src/UserRepository.php");
require_once("src/Exceptions.php");

class LoginModel {
	private $loggedIn = "loggedIn";
	private $browser = "browser";
	private $username = "";
	private $userRepository;
	protected $dbConnection;
	protected $dbTable = "user";
	private static $sUsername = "username";
	private static $sPassword = "password";
	
	public function __construct(){
		$this->userRepository = new UserRepository();
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
		
		try {
			$user = $this->userRepository->authenticateUser($username, $password);
			if(isset($user)) {
				// Kanske göra något mer med user? Annars bara returnera true från auth-funktionen kanske.
				$_SESSION[$this->loggedIn] = 1;
		    	$_SESSION[$this->browser] = $_SERVER["HTTP_USER_AGENT"];
				return true;
			}
		}
		catch(AuthenticationException $e) {
			return false;
		}
		
	}
	
	public function addUser(User $user) {

	try{
		return $this->userRepository->addUser($user);

		} catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
		
	}
	
}