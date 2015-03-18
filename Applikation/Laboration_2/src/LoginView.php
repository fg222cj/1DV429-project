<?php

//Visualisera data
//Behöver tillgång till datan som den ska visualisera från modellen

class LoginView {
	private $model;
	private $username = "";
	private $password = "";
	private $userArr = array();
	private $rememberValue;
	private $msg = "";
	private $dateTime;

	public function __construct(LoginModel $model){
		$this->model = $model;

	}
	
	//Visar login-formuläret om ej redan inloggad
	public function showLoginForm(){
		$ret = "";
		
		// Sparar användarnamnet till inputfältet om lösenordet är fel
        if (isset($_POST["username"])){
            $this->username = $_POST["username"];
		}
		
		$this->dateTime = $this->getTime();
		$ret = "
			<h1>IT-Security 1DV429</h1>
			<a href='?register'>Register new user</a>
			<form method='post'>
			<fieldset>
			<legend>Login - Type username and password</legend>
			$this->msg
			Username: <input type='text' name='username' id='username' value='$this->username'>
			Password: <input type='password' name='password'>
			<input type='submit' class='small button' name='submit' value='Log in'>
			</fieldset>
			</form>
			<p>$this->dateTime</p>";
		return $ret;
	}
	
	public function showRegisterForm(){
	    $ret = "";
	    
	    if (isset($_POST["regUsername"])){
	        $this->username = $_POST["regUsername"];
	    }
	    
	    $this->dateTime = $this->getTime();
	    $ret = "
	    <a href='?'>Back</a>
	    <h2>Register user</h2>
	    <form method='post'>
		<fieldset>
		<legend>Register new user - Type username and password</legend>
		$this->msg
		Username: 
		<input type='text' name='regUsername' id='username' value='$this->username'>
		<br>
		Password: 
		<input type='password' name='regPassword'>
		<br>
		Repeat password: 
		<input type='password' name='repeatedRegPassword'>
		<br> 
		<input type='submit' class='small button' name='regSubmit' value='Register'>
		</fieldset>
		</form>
		<p>$this->dateTime</p>
	    ";
	    
	    return $ret;
	}
		
	// Visas om inloggad
	public function showLoggedIn($username){

		$this->dateTime = $this->getTime();
		
		$ret = "<h2>Welcome " .$username." </h2>$this->msg
		<form method='post'>
		<input type='submit' class='small button' value='Log out' name='logOut'/>
		</form>
		<p>$this->dateTime</p>";
		return $ret;
	}
	
	// Hämtar ut dag, tid osv och returnerar som en sträng
	public function getTime(){
		setlocale(LC_TIME, "swedish");
		date_default_timezone_set('Europe/Stockholm');
		$weekDay = ucfirst(utf8_encode(strftime('%A')));
		$date = strftime('%d');
		$month = ucfirst(strftime("%B"));
		$year = strftime("%Y");
		$time = strftime("%H:%M:%S");

		$this->dateTime = $weekDay . ", den " . $date . " " . $month . " år " . $year . ". Klockan är [" . $time . "]";
		
		return $this->dateTime;	
	}
	
	// Kollar så användaren matat in något i båda fälten
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

	    $updatedUsername = "";
	    if(!ctype_alnum($username)){
	    	$length = strlen($username);
	    	$array = array();
	    	for($i = 0; $i < $length; $i++){
	    		if(ctype_alnum($username[$i])){
	    			$updatedUsername .= $username[$i];	
	    		}
	    	}
			$_POST["regUsername"] = $updatedUsername;
	    	$this->msg = "<p>Användarnamnet innehåller ogiltiga tecken</p>";
			return false;
	    }
		
	    if(strlen($username) < 3 || strlen($password) < 6 || strlen($repeatedPassword) < 6  || $password != $repeatedPassword){
    	    if(strlen($username) < 3){
    	        $this->msg = "<p>Användarnamnet har för få tecken. Minst 3 tecken</p>";
    	    }
    	    
    	    if(strlen($password) < 6 || strlen($repeatedPassword) < 6){
    	        $this->msg .= "<p>Lösenorden har för få tecken. Minst 6 tecken</p>";
    	    }
    	    
    	    if($password != $repeatedPassword){
    	    	$this->msg .= "<p>Lösenorden stämmer inte överrens</p>";
    	    }
    	    return false;
	    }
	    
	    return true;
	}

	// Returnerar true om användaren klickar på 'Logga in'.
	public function userPressedLogin(){
        if(isset($_POST["submit"])){
            return true;
        }
        return false;
    }

	// Returnerar true om användaren klickar på 'Logga ut'
	public function userPressedLogOut(){
		if(isset($_POST["logOut"])){
		    $this->msg = "<p>You now logged out</p>";
			return true;
		}
		return false;
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
	
	// Returnerar användarnamnet som matats in
	public function getUsername(){
		if(isset($_POST["username"])){
			return $_POST["username"];
		}
	}
	
	// Returnerar lösenordet som matats in
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
	
	// Olika statusmeddelanden
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
