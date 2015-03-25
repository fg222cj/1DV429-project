<?php

require_once('src/AdminView.php');
require_once('src/AdminModel.php');

class AdminController
{
	private $AdminView;
	private $AdminModel;
	
	public function __construct()
	{
		$this->AdminModel = new AdminModel();
		$this->AdminView = new AdminView($this->AdminModel);
	}
	
	// Visar admin sida där man kan ändra roller.
	public function AdminControl()
	{
		
		if($this->AdminView->userPressedUpdate()) {
			
			try {
				$Id = $this->AdminView->getId();
				$role = $this->AdminView->getRole();
			
				if($this->AdminModel->changeRole($role, $Id)) {
					$this->AdminView->setMsg("Update of user role succeeded");
					return $this->AdminView->ShowRoleList();
				} else {
					$this->AdminView->setMsg("Something went wrong when tried to update a user role");
					return $this->AdminView->ShowRoleList();
				}
			} catch(exception $e) {
				$this->AdminView->setMsg("Something went wrong when tried to update a user role");
				return $this->AdminView->ShowRoleList();
			}
		}
			
		else {
			return $this->AdminView->ShowRoleList();
		}			
			
	}
}

?>