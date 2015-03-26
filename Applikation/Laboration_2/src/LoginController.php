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
			
		// If user wants to log out
		if($logout == true) {
			if($this->model->userLoggedInStatus()) {
				$this->model->destroySession();
				$this->view->logOut();
			}
			return $this->view->showLoginForm();
		}
		
		// If user is already logged out		
		if($this->model->userLoggedInStatus()){
			$this->username = $this->model->getLoggedInUser();
			return $this->view->showLoggedIn($this->username);
        }

		// If user wants to log in
		if($this->view->userPressedLogin()){
			
			// Gets inputs from form
			$this->username = $this->view->getUsername();
			$this->password = $this->view->getPassword();
			
			// Makes sure username and password
			if($this->view->checkIfNotEmpty($this->username, $this->password)){
				
				$loginCheck = $this->logRepository->checkLoginAttempts($_SERVER['REMOTE_ADDR']);
				if($loginCheck < 5){
					// Tries to log in with the input values
					if($this->model->login($this->username, $this->password)){
						// Success message
						$this->view->loginSuccess();
						$this->loginLog = new LoginLog(null, $this->username, null, $_SERVER['REMOTE_ADDR'], 1);
						if($this->logRepository->addLoginLog($this->loginLog)){
							return $this->view->showLoggedIn($this->username);
						}
						else{
							$this->view->setMsg("An error has occured!");
						}
					}	
					
					// Shows login form again if login was not successful
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
		
		// If user wants to register a new user
		if($this->view->userPressedRegister()){
		    $this->username = $this->view->getRegUsername();
		    $this->password = $this->view->getRegPassword();
		    $this->repeatedPassword = $this->view->getRepeatedRegPassword();
			
		    if($this->view->userPressedRegisterSubmit()){
		        if($this->view->checkRegisterInput($this->username, $this->password, $this->repeatedPassword)){
		        	$user = new User(null, $this->username, md5($this->password));
					//$this->view->setMsg($this->model->addUser($user));
					try{
						if($this->model->addUser($user)){
							$this->view->registerMsg(true);
							return $this->view->showLoginForm();
							
						}
						else{
							$this->view->registerMsg(false);
						}
					}
					catch(DatabaseException $e){
						switch ($e->getMessage()){
							case "ADD_USER_ERROR":
								$this->view->setMessage("Something went wrong, user could not be added!");
								break;
						}
					}
    		    }
		    }
			return $this->view->showRegisterForm();
		}
		
		// Shows login form as default
		return $this->view->showLoginForm();
	}
}