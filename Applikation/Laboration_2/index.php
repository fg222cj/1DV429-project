<?php

require_once ("common/HTMLView.php");
require_once ("src/NavigationController.php");
require_once ("src/LoginView.php");
require_once ("src/LoginModel.php");

// Startar session & sätter cookie hos klienten
try {
	session_start();
	
	$c = new NavigationController();
	$htmlBody = $c->doNavigation();
	
	$view = new HTMLView();
	$view->echoHTML($htmlBody);
}
catch(Exception $e) {
	die("An unexpected error has occurred!");
}
	