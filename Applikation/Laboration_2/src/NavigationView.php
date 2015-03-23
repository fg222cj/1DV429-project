<?php

class NavigationView
{
	public static $actionProfile = 'profile';
	public static $actionAdmin = 'admin';
	public static $actionAddUser = 'adduser';
	public static $actionLogin = 'login';
	
	public static function getAction()
	{
		if(isset($_REQUEST[self::$actionProfile]) && !isset($_REQUEST[self::$actionAdmin]) && !isset($_REQUEST[self::$actionAddUser]) && !isset($_REQUEST[self::$actionLogin]))
		{
			return self::$actionProfile;
		}
		
		if(isset($_REQUEST[self::$actionAdmin]) && isset($_REQUEST[self::$actionProfile]) && !isset($_REQUEST[self::$actionAddUser]) && !isset($_REQUEST[self::$actionLogin]))
		{
			return self::$actionAdmin;
		}
		
		if(isset($_REQUEST[self::$actionAddUser]))
		{
			return self::$actionAddBoat;
		}
		
		return self::$actionLogin;
	}
}

?>