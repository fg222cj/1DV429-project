<?php

require_once('src/LoginModel.php');

class HTMLView {
	
	private $loginModel;
	
	public function __construct(){
		$this->loginModel = new LoginModel();
	}
	
	public function echoHTML($body){
		
		$links = "";
		
		if ($body == NULL) {
			throw new \Exception("Body can't be null");
		}
		
		if(isset($_SESSION['loggedIn'])){
			$links = "<div><a href='?profile'>Profile </a><a href='?logout'>Log out</a></div>
		</form>";
			if($this->loginModel->adminStatus()){
				$links = "<div><a href='?profile' class='small button'>Profile</a><a href='?admin' class='small button'>Admin view</a><a href='?logout' class='small button'>Log out</a></div>
		</form>";
			}
		}
		
		echo "
			<!DOCTYPE html>
			<head>
				<meta charset='UTF-8'>
				<title>IT-Security</title>
				<link rel='stylesheet' type='text/css' href='css/foundation.css'>
			</head>
			<body>
				<div class='large-5 columns'>
					$links
					$body
				</div>
			</body>
		";
	}
}