<?php

class HTMLView {
	
	public function echoHTML($body){
		if ($body == NULL) {
			throw new \Exception("Body can't be null");
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
					$body
				</div>
			</body>
		";
	}
}