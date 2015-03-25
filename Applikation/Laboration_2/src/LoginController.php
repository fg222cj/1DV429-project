<?php

require_once("src/LoginModel.php");
require_once("src/LoginView.php");
require_once("src/User.php");
require_once("src/LoginLog.php");
require_once("src/LogRepository.php");

class LoginController {
	private $view;
	private $model;
	private $username = "";
	private $password = "";
	private $repeatedPassword = "";
	private $value;
	private $loginLog;
	private $logRepository;
	
	public function __construct(){
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
		$this->logRepository = new LogRepository();
	}
	
	public function doControll($logout = null){
			
		// Om användaren vill logga ut
		if($logout == true) {
			if($this->model->userLoggedInStatus()) {
				$this->model->destroySession();
				$this->view->logOut();
			}
			return $this->view->showLoginForm();
		}
		
		// Om användaren är inloggad redan		
		if($this->model->userLoggedInStatus()){
			$this->username = $this->model->getLoggedInUser();
			return $this->view->showLoggedIn($this->username);
        }

		// Om användaren vill logga in
		if($this->view->userPressedLogin()){
			
			// Hämtar inputvärdena från formuläret	
			$this->username = $this->view->getUsername();
			$this->password = $this->view->getPassword();
			
			// Kollar på användarnamn och lösenord är ifyllt
			if($this->view->checkIfNotEmpty($this->username, $this->password)){
				
				$loginCheck = $this->logRepository->checkLoginAttempts($_SERVER['REMOTE_ADDR']);
				if($loginCheck < 5){
					// Försöker logga in med de angivna värdena
					if($this->model->login($this->username, $this->password)){
						// Meddelande om att inloggningen lyckades
						$this->view->loginSuccess();
						$this->loginLog = new LoginLog(null, $this->username, null, $_SERVER['REMOTE_ADDR'], 1);
						$this->logRepository->addLoginLog($this->loginLog);
						return $this->view->showLoggedIn($this->username);
					}	
					
					// Om uppgifterna var fel visas login-forumläret igen
					else{
						$this->view->errorMsg();
						$this->loginLog = new LoginLog(null, $this->username, null, $_SERVER['REMOTE_ADDR'], 0);
						$this->logRepository->addLoginLog($this->loginLog);
						return $this->view->showLoginForm();
					}
				}
				else{
					$this->view->setMsg("<p><font color='red'>Please wait until next login attempt.</font></p>");
					return $this->view->showLoginForm();
				}			
			}
		
		}
		
		// Om användaren vill registrera ny användare
		if($this->view->userPressedRegister()){
		    $this->username = $this->view->getRegUsername();
		    $this->password = $this->view->getRegPassword();
		    $this->repeatedPassword = $this->view->getRepeatedRegPassword();
			
		    if($this->view->userPressedRegisterSubmit()){
		        if($this->view->checkRegisterInput($this->username, $this->password, $this->repeatedPassword)){
		        	$user = new User(null, $this->username, $this->password);
					//$this->view->setMsg($this->model->addUser($user));
					if($this->model->addUser($user)){
						$this->view->registerMsg(true);
						return $this->view->showLoginForm();
						
					}
					else{
						$this->view->registerMsg(false);
					}
    		    }
		    }
			return $this->view->showRegisterForm();
		}
		
		// Visar annars login-formuläret som default
		return $this->view->showLoginForm();
	}
}