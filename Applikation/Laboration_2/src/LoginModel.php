<?php

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
	
	// Returns true if already logged in
	public function userLoggedInStatus(){
	    // Makes sure session has not been stolen
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
	
	// Destroys session
	public function destroySession(){
		session_unset();
        session_destroy();
	}
	
	//Fetches username from logged in user
	public function getLoggedInUser(){
		if(isset($_SESSION["username"])){
			return $_SESSION["username"];
		}
	}
	
	// Login
	public function login($username, $password){
		$_SESSION["username"] = $username;
		
		try {
			$user = $this->userRepository->authenticateUser($username, md5($password));
			if(isset($user)) {
				$_SESSION[$this->loggedIn] = 1;
				$_SESSION["userID"] = $user->getUserId();
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
			throw new DatabaseException("ADD_USER_ERROR");
		}
		
	}

	public function adminStatus() {
		$user = $this->userRepository->getUserByName($_SESSION["username"]);
		$userrole = $user->getRole();

		if($userrole == 1) {
			return true;
		}
		return false;
	}
	
}