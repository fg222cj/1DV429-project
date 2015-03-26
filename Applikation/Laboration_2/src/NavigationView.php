<?php

class NavigationView
{
	public static $actionProfile = 'profile';
	public static $actionAdmin = 'admin';
	public static $actionLogin = 'login';
	public static $actionLogout = "logout";
	public static $actionForum = "forum";
	
	//Check the url and return static string.
	public static function getAction()
	{
		if(isset($_REQUEST[self::$actionProfile]))
		{
			return self::$actionProfile;
		}
		
		if(isset($_REQUEST[self::$actionAdmin]))
		{
			return self::$actionAdmin;
		}

		if(isset($_REQUEST[self::$actionLogout])) {
			return self::$actionLogout;
		}
		
		if(isset($_REQUEST[self::$actionForum])) {
			return self::$actionForum;
		}
		
		return self::$actionLogin;
	}
}

?>