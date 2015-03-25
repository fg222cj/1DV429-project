<?php

require_once('src/UserRepository.php');
require_once('src/AdminView.php');

class AdminController
{
	private $AdminView;
	private $UserRepository;
	
	public function __construct()
	{
		$this->UserRepository = new UserRepository();
		$this->AdminView = new AdminView($this->UserRepository);
	}
	
	// Visar admin sida där man kan ändra roller.
	public function AdminControl()
	{
		
		if($this->AdminView->userPressedUpdate()) {
			
			try {
				$Id = $this->AdminView->getId();
				$role = $this->AdminView->getRole();
			
				if($this->UserRepository->changeRole($role, $Id)) {
					$this->AdminView->setMsg("Update of user role succeeded");
					return $this->AdminView->ShowRoleList();
				} else {
					$this->AdminView->setMsg("Something went wrong when tried to update a user role");
				}
			} catch(exception $e) {
				$this->AdminView->setMsg("Something went wrong when tried to update a user role");
			}
		}
			
		else {
			return $this->AdminView->ShowRoleList();
		}			
			
	}
}

?>