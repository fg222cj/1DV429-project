<?php

require_once('src/AdminView.php');
require_once('src/AdminModel.php');
require_once("src/AdminLog.php");
require_once("src/LogRepository.php");

class AdminController
{
	private $AdminView;
	private $AdminModel;
	private $adminLog;
	private $logRepository;
	
	public function __construct()
	{
		$this->AdminModel = new AdminModel();
		$this->AdminView = new AdminView($this->AdminModel);
		$this->logRepository = new LogRepository();
	}
	
	// Visar admin sida där man kan ändra roller.
	public function AdminControl()
	{
		
		if($this->AdminView->userPressedUpdate()) {
			
			try {
				$Id = $this->AdminView->getId();
				$role = $this->AdminView->getRole();
				
				$admin = $this->AdminModel->getUser($_SESSION["userID"]);
				$adminRole = $admin->getRole();
				
				$user = $this->AdminModel->getUser($this->AdminView->getId());
				$oldRole = $user->getRole();
				
				if($adminRole == 1) {
					if($this->AdminModel->changeRole($role, $Id)) {
						$this->adminLog = new AdminLog(null, $_SESSION["userID"], $this->AdminView->getId(), $oldRole, $this->AdminView->getRole(), null);
						$this->logRepository->addAdminLog($this->adminLog);
						
						$this->AdminView->setMsg("Update of user role succeeded");
						return $this->AdminView->ShowRoleList();
					} else {
						$this->AdminView->setMsg("Something went wrong when tried to update a user role");
						return $this->AdminView->ShowRoleList();
					}
				}
			} catch(exception $e) {
				die($e->getMessage());
				//$this->AdminView->setMsg("Something went wrong when tried to update a user role");
				return $this->AdminView->ShowRoleList();
			}
		}
			
		else {
			return $this->AdminView->ShowRoleList();
		}			
			
	}
}

?>