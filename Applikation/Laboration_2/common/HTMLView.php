<?php

class HTMLView {
	
	public function echoHTML($body){
		if ($body == NULL) {
			throw new \Exception("Body can't be null");
		}
		
		echo "
			<!DOCTYPE html>
			<meta charset='UTF-8'>
			<title>IT-Security</title>
			<body>
				<h1>IT-Security 1DV429</h1>
				$body
			</body>
		";
	}
}