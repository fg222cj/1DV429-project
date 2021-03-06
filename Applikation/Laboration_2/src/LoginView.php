<?php

require_once('src/Validation.php');

class LoginView {
	private $model;
	private $username = "";
	private $password = "";
	private $userArr = array();
	private $rememberValue;
	private $msg = "";
	private $validation;
	
	public function __construct(LoginModel $model){
		$this->model = $model;
		$this->validation = new Validation();
	}
	
	//Shows login form if not already logged in
	public function showLoginForm(){
		$ret = "";
		
		// Saves username to input if pw is wrong
        if (isset($_POST["username"])){
            $this->username = $_POST["username"];
		}
		
		$ret = "
			<h1>IT-Security 1DV429</h1>
			<a href='?register'>Register new user</a>
			<form method='post' action='?'>
			<fieldset>
			<legend>Login - Type username and password</legend>
			$this->msg
			Username: <input type='text' name='username' maxlength='30' id='username'>
			Password: <input type='password' name='password' maxlength='30'>
			<input type='submit' class='small button' name='submit' value='Log in'>
			</fieldset>
			</form>";
		return $ret;
	}
	
	public function showRegisterForm(){
	    $ret = "";
	    
	    if (isset($_POST["regUsername"])){
	        $this->username = $_POST["regUsername"];
	    }
	    
	    $ret = "
		    <a href='?'>Back</a>
		    <h2>Register user</h2>
		    <form method='post'>
			<fieldset>
			<legend>Register new user - Type username and password</legend>
			$this->msg
			Username: 
			<input type='text' name='regUsername' id='username' maxlength='30'>
			<p>Password need to have at least 8 characters, at least one upper-case letter and one lowercase letter, at least one digit and no special characters</p>
			Password: 
			<input type='password' name='regPassword' maxlength='30'>
			Repeat password: 
			<input type='password' name='repeatedRegPassword' maxlength='30'> 
			<input type='submit' class='small button' name='regSubmit' value='Register'>
			</fieldset>
			</form>";
	    
	    return $ret;
	}
		
	// Shown if logged in
	public function showLoggedIn($username){
				
		$username = strtolower($username);
		$username = ucfirst($username);
		
		$ret = "<h2>Welcome " .$username." </h2>$this->msg";
		return $ret;
	}
	
	// Makes sure input fields are not empty
	public function checkIfNotEmpty($username, $password){
		if(strlen($username) == 0 || strlen($password) == 0){
			
			if (strlen($username) == 0){
				$this->msg = "<p>Username missing</p>";
				return false;
			}
			else if (strlen($password) == 0){
				$this->msg = "<p>Password missing</p>";
				return false;
			}
		}
		return true;
	}
	
	public function checkRegisterInput($username, $password, $repeatedPassword){
	
		$exceptionThrown = false;
			
			try{					
				$this->validation->validateString($username);
				$this->validation->validateString($password);
				$this->validation->validateString($repeatedPassword);
				
				$this->validation->validateUsernameLength($username);
				$this->validation->validateUsernameCharacters($username);

				$this->validation->validatePasswordLength($password);
				$this->validation->validatePasswordSecurity($password);
				
				$this->validation->compareNewPasswordInputs($password, $repeatedPassword);
			}
			
			catch(ValidationException $e){
				$exceptionThrown = true;
				switch ($e->getMessage()){										
					case "VARIABLE_NOT_STRING":
						$this->msg .= "<p><font color='#FF0000'>Invalid input!</font></p>";
						break;
						
					case "USERNAME_BAD_LENGTH":
						$this->msg .= "<p><font color='#FF0000'>Username needs to be in the range of 3-15 characters</font></p>";
						break;
					
					case "USERNAME_BAD_CHARACTERS":
						$this->msg .= "<p><font color='#FF0000'>Username contains invalid characters.</font></p>";
						break;

					case "PASSWORD_BAD_LENGTH":
						$this->msg .= "<p><font color='#FF0000'>Password needs to be in the range of 8-15 characters.</font></p>";
						break;
						
					case "PASSWORD_NOT_SECURE":
						$this->msg .= "<p><font color='#FF0000'>Password either contains invalid characters, or does not contain at least one upper case letter, one lower case letter and one numeric character.</font></p>";
						break;
						
					case "NEW_PASSWORDS_NOT_MATCHING":
						$this->msg .= "<p><font color='#FF0000'>The passwords are not matching!</font></p>";
						break;
				}
				return false;
			}
		return true;
	}

	public function userPressedLogin(){
        if(isset($_POST["submit"])){
            return true;
        }
        return false;
    }

	public function logOut(){
		    $this->msg = "<p>You now logged out</p>";
	}
	
	public function userPressedRegister(){
	    if(isset($_GET["register"])){
	        return true;
	    }
	    return false;
	}
	
	public function userPressedRegisterSubmit(){
	    if(isset($_POST["regSubmit"])){
	        return true;
	    }
	    return false;
	}
	
	public function getUsername(){
		if(isset($_POST["username"])){
			return $_POST["username"];
		}
	}
	
	public function getPassword(){
		if(isset($_POST["password"])){
			return $_POST["password"];
		}
	}
	
	public function getRegUsername(){
		if(isset($_POST["regUsername"])){
			return $_POST["regUsername"];
		}
	}
	
	public function getRegPassword(){
		if(isset($_POST["regPassword"])){
			return $_POST["regPassword"];
		}
	}
	
	public function getRepeatedRegPassword(){
		if(isset($_POST["repeatedRegPassword"])){
			return $_POST["repeatedRegPassword"];
		}
		return "";
	}
	
	public function errorMsg(){
		$this->msg = "<p>Wrong username or password</p>";
	}
	
	public function setMsg($msg){
		$this->msg = $msg;
	}
	
	public function registerMsg($value){
		if($value == true){
			$this->msg = "<p>New User Registration successfully</p>";
			$this->username = $this->getRegUsername();
		}
		else{
			$this->msg = "<p>The username is already taken</p>";
		}
	}
	
	public function loginSuccess(){
        $this->msg = "<p>Login successful</p>";
	}
}
