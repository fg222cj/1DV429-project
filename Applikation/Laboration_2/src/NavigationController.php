<?php

require_once('src/NavigationView.php');
require_once('src/LoginController.php');
require_once('src/ProfileController.php');
require_once('src/AdminController.php');
require_once("src/LoginModel.php");

class NavigationController
{
	private $loginmodel;

	public function __construct() {
		$this->loginmodel = new LoginModel();
	}

	public function doNavigation()
	{
		$controller;
		
		try
		{
			switch (NavigationView::getAction())
			{
				
				case NavigationView::$actionProfile:
					
					if($this->loginmodel->userLoggedInStatus()) {
						$controller = new ProfileController();
						$result = $controller->doControll();
					} else {
						$controller = new LoginController();
						$result = $controller->doControll();
					}
					
					return $result;
					break;
					
				
				case NavigationView::$actionAdmin:
					
					if($this->loginmodel->userLoggedInStatus()) {
						if($this->loginmodel->adminStatus()) {
							$controller = new AdminController();
							$result = $controller->AdminControl();
						} else {
							$controller = new ProfileController();
							$result = $controller->doControll();
						}
					} else {
						$controller = new LoginController();
						$result = $controller->doControll();
					}
					
					return $result;
					break;

				case NavigationView::$actionLogout:

					$controller = new LoginController();
					$result = $controller->doControll(true);
					return $result;
					break;

					
				case NavigationView::$actionLogin:
				default:
					
					$controller = new LoginController();
					$result = $controller->doControll(); 
					return $result;
					break;
				
			}	
		}
		catch (Exception $e)
		{
			$controller = new LoginController();
			$result = $controller->doControll();
			return $result;
		}
	}
}
?>