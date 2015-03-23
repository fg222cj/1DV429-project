<?php

require_once('UserRepository.php');
require_once('AdminView.php');

class AdminController
{
	private $AdminView;
	private $UserRepository;
	
	public function __construct()
	{
		$this->$UserRepository = new $UserRepository();
		$this->$AdminView = new $AdminView($this->$UserRepository);
	}
	
	// Visar admin sida där man kan ändra roller.
	public function AdminControl()
	{
		
		if($this->listView->userPressedUpdate() == TRUE) {
			//WHAT TO DO:
			//Updatera sidan och in till databasen.
		}
		else {
			return $this->AdminView->ShowRoleList();
		}			
			
	}
}

?>