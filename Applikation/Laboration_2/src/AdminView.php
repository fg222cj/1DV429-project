<?php

require_once ("src/Validation.php");

Class AdminView
{
	private $AdminModel;
	private $msg = "";
	private $validation;
	
	public function __construct($AdminModel)
	{
		$this->AdminModel = $AdminModel;
		$this->messages = array();
		$this->validation = new Validation();
	}
	
	//Show the role list. Return HTML
	public function ShowRoleList()
	{
		$AllUserAndRoles = $this->AdminModel->getList();
		$contentString = "";
		
		foreach($AllUserAndRoles as $UsersAndRoles)
		{
			$adminchecked = "";
			$moderatorchecked = "";
			$userchecked = "";
			$role = "";

			switch ($UsersAndRoles -> getRole()) {
				case "1":
					$adminchecked = "checked";
					$role = "Admin";
					break;
				case "2":
					$moderatorchecked = "checked";
					$role = "Moderator";
					break;
				case "3":
					$userchecked = "checked";
					$role = "User";
					break;
			}

			$contentString .="
			<li>UserName: " . $UsersAndRoles->getUsername() . "<br>
			Role: " . $role . "</li>
			<form method='post' action=''>
				<input type='hidden' name='user' value= " . $UsersAndRoles->getUserId() . ">
				<input type='radio' name='role' value='1' $adminchecked >Admin
				<input type='radio' name='role' value='2' $moderatorchecked >Moderator
				<input type='radio' name='role' value='3' $userchecked >User <br>
				<input type='submit' class='small button' name='submit' value='Update'>
			</form><br>
			";
		}
		
		$ret = "
				<h1>User List</h1>
				<p>" . $this->msg . "</p>
				<ul>$contentString</ul>
		";
		
		return $ret;
	}
	
	//Return true if user clicked Update.
	public function userPressedUpdate(){
        if(isset($_POST["submit"])){
            return true;
        }
        return false;
    }
    
	//Get the role you want change.
    public function getRole() {
    	$role = $_POST["role"];
    	
    	if(isset($role)) {
    		if($this->validation->checkRoleValue($role)) {
    			return $role;
    		}
    	}
		return false;
    }
	
	//Get userid of the person you want change.
	public function getId() {
    	if(isset($_POST["user"])) {
    		return $_POST["user"];
    	}
		return false;
    }
    
    public function setMsg($msg){
		$this->msg = $msg;
	}
}
