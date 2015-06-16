<?php

//Created by Tim Emanuelsson(te222ds), Alexandra Seppänen(as223jx), Fabian Gillholm(fg222cj).
error_reporting(0);
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
	