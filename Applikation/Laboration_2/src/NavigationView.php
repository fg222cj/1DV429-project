<?php

class NavigationView
{
	public static $actionProfile = 'profile';
	public static $actionAdmin = 'admin';
	public static $actionAddUser = 'adduser';
	public static $actionLogin = 'login';
	public static $actionLogout = "logout";
	public static $actionForum = "forum";
	
	public static function getAction()
	{
		if(isset($_REQUEST[self::$actionProfile]) && !isset($_REQUEST[self::$actionAdmin]) && !isset($_REQUEST[self::$actionAddUser]) && !isset($_REQUEST[self::$actionLogin]))
		{
			return self::$actionProfile;
		}
		
		if(isset($_REQUEST[self::$actionAdmin]) && !isset($_REQUEST[self::$actionProfile]) && !isset($_REQUEST[self::$actionAddUser]) && !isset($_REQUEST[self::$actionLogin]))
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