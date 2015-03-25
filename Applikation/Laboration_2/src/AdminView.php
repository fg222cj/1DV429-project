<?php

Class AdminView
{
	private $AdminModel;
	private $msg = "";
	
	public function __construct($AdminModel)
	{
		$this->AdminModel = $AdminModel;
		$this->messages = array();
	}
	
	// Visar den kompakta listan. Returnerar HTML-sträng.
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
	
	// Returnerar true om användaren klickar på 'Update'.
	public function userPressedUpdate(){
        if(isset($_POST["submit"])){
            return true;
        }
        return false;
    }
    
    public function getRole() {
    	if(isset($_POST["role"])) {
    		return $_POST["role"];
    	}
		return false;
    }
	
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
