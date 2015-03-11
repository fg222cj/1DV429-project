<?php

//Visualisera data
//Behöver tillgång till datan som den ska visualisera från modellen

class LoginView {
	private $model;
	private $username = "";
	private $password = "";
	private $userArr = array();
	private $rememberValue;
	private $usernameCookie = "Username";
	private $passwordCookie = "Password";
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
		<a href='?register'>Registrera ny användare</a>
		<h2>Ej inloggad</h2>
		<form method='post'>
		<fieldset>
		<legend>Login - Skriv in användarnamn och lösenord</legend>
		$this->msg
		Användarnamn: <input type='text' name='username' id='username' value='$this->username'>
		Lösenord: <input type='password' name='password'> Håll mig inloggad:
		<input type='checkbox' name='remember' value='Remember'><br>
		<input type='submit' name='submit' value='Logga in'>
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
	    <a href='/Laboration_2'>Tillbaka</a>
	    <h2>Ej inloggad, registrerar användare</h2>
	    <form method='post'>
		<fieldset>
		<legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>
		$this->msg
		Namn: <input type='text' name='regUsername' id='username' value='$this->username'><br>
		Lösenord: <input type='password' name='regPassword'><br>Repetera lösenord: 
		<input type='password' name='repeatedRegPassword'><br>Skicka: 
		<input type='submit' name='regSubmit' value='Registrera'>
		</fieldset>
		</form>
		<p>$this->dateTime</p>
	    ";
	    
	    return $ret;
	}
	
	public function setCookie(){
	    //time()+60*60*24*365
		setcookie($this->usernameCookie, $_POST["username"], time()+60*60*24*365, "/");
		setcookie($this->passwordCookie, md5($_POST["password"]), time()+60*60*24*365, "/");

		$storage = fopen("src/cookieExpire.txt", "w");
		$data = time()+60*60*24*365;
		fwrite($storage, $data);
		fclose($storage);
		
		return;
	}
	
	// Visas om inloggad
	public function showLoggedIn($username){
		
		// Om cookie är satt så ersätter jag $username med dess värde
	    if(isset($_COOKIE[$this->usernameCookie])){
			$username = $_COOKIE[$this->usernameCookie];
		}

		$this->dateTime = $this->getTime();
		
		$ret = "<h2>" .$username." är inloggad</h2>$this->msg
		<form method='post'>
		<input type='submit' value='Logga ut' name='logOut'/>
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
	
	// Tar bort kakor och rensar filen som sparat förfallotiden
	public function logOut(){
		setcookie($this->usernameCookie, "", time() -3600);
        setcookie($this->passwordCookie, "", time() -3600);
        
		$storage = fopen("src/cookieExpire.txt", "w");
        fclose($storage);
	}
	
	// Kollar så användaren matat in något i båda fälten
	public function checkIfNotEmpty($username, $password){
		if(strlen($username) == 0 || strlen($password) == 0){
			
			if (strlen($username) == 0){
				$this->msg = "<p>Användarnamn saknas</p>";
				return false;
			}
			else if (strlen($password) == 0){
				$this->msg = "<p>Lösenord saknas</p>";
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

	// Kollar om kakorna har förfallit
	public function checkIfCookieExpired(){
        $expire = fopen("src/cookieExpire.txt", "r");
		while (!feof($expire)){
			$line = fgets($expire);
			$line = trim($line);
			$expireArr[] = $line;
		}
		fclose($expire);
		
		if ($expireArr[0] < time()){
            return true;
		}
		return false;
	}
	
	// Kollar om kakor finns
    public function checkIfCookiesExist(){
        if(isset($_COOKIE[$this->usernameCookie]) && isset($_COOKIE[$this->passwordCookie])){
            return true;
        }
        else return false;
	}
    
    // Hämtar cookien för användarnamnet
	public function getUsernameCookie(){
        if(isset($_COOKIE[$this->usernameCookie])){
            return $_COOKIE[$this->usernameCookie];
        }
        else return "";
    }
	
	// Hämtar cookien för lösenordet
	public function getPasswordCookie(){
        if(isset($_COOKIE[$this->passwordCookie])){
            return $_COOKIE[$this->passwordCookie];
        }
        else return "";
	}
	
	// Returnerar true om användaren klickar på 'Logga in'.
	public function userPressedLogin(){
        if(isset($_POST["submit"])){
            return true;
        }
        return false;
    }

    // Returnerar true om användaren vill bli ihågkommen
	public function rememberMe(){
        if (isset($_POST["remember"])){
            $this->msg = "<p>Inloggning lyckades och vi kommer ihåg dig nästa gång</p>";
            return true;
        }
        return false;
    }
	
	// Returnerar true om användaren klickar på 'Logga ut'
	public function userPressedLogOut(){
		if(isset($_POST["logOut"])){
		    $this->msg = "<p>Du har loggat ut</p>";
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
		$this->msg = "<p>Felaktigt användarnamn och/eller lösenord</p>";
	}
	
	public function cookieLoginMsg(){
		$this->msg = "<p>Inloggning lyckades via cookies</p>";
	}
	
	public function failedCookieLoginMsg(){
	    $this->msg = "<p>Felaktig information i cookies</p>";
	}
	
	public function setMsg($msg){
		$this->msg = $msg;
	}
	
	public function registerMsg($value){
		if($value == true){
			$this->msg = "<p>Registrering av ny användare lyckades</p>";
			$this->username = $this->getRegUsername();
		}
		else{
			$this->msg = "<p>Användarnamnet är redan upptaget</p>";
		}
	}
	
	public function loginSuccess(){
        $this->msg = "<p>Inloggning lyckades</p>";
	}
}
