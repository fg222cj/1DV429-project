<?php

class HTMLView {
	
	public function echoHTML($body){
		
		$links = "";
		
		if ($body == NULL) {
			throw new \Exception("Body can't be null");
		}
		
		if(isset($_SESSION['loggedIn'])){
			$links .= "<div><a href='?profile'>Profile </a><a href='?logout'>Log out</a></div>
		</form>";
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