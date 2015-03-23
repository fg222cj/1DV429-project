<?php

require_once('src/NavigationView.php');
require_once('src/LoginController.php');
require_once('src/ProfileController.php');
require_once('src/AdminController.php');

class NavigationController
{
	public function doNavigation()
	{
		$controller;
		
		try
		{
			switch (NavigationView::getAction())
			{
				
				case NavigationView::$actionProfile:
					
					$controller = new ProfileController();
					$result = $controller->doControll();
					return $result;
					break;
					
				
				case NavigationView::$actionAdmin:
					
					$controller = new AdminController();
					$result = $controller->AdminControl();
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