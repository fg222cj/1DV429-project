<?php

class LoginView {
	private $model;

	public function __construct(ProfileModel $model){
		$this->model = $model;
	}

	
	public function showProfile($username){
		$ret = "<h2>" .$username."'s profile</h2>
		<form method='post'>
		<input type='submit' name='editAccountSettings' value='Edit account settings'/>
		</form>
		";
		return $ret;
	}
	
	public function showEditAccountSettingsForm(){
	    $ret = "
	    <a href='?>Back</a>
	    <h2>Edit account settings</h2>
	    <form method='post'>
		<fieldset>
		<legend>Change password</legend>
		$this->msg
		Old password: <input type='password' name='oldPassword'><br>
		New password: <input type='password' name='newPassword'><br>Repeat new password: 
		<input type='password' name='repeatedNewPassword'><br>Skicka: 
		<input type='submit' name='submitAccountSettings' value='Save'>
		</fieldset>
		</form>
	    ";
	    
	    return $ret;
	}
	
	public function compareNewPasswordInputs($newPasswordFirstInput, $newPasswordSecondInput){
		if($newPasswordFirstInput == $newPasswordSecondInput){
			return true;
		}
		return false;
	}
	
	public function userPressedEditAccountSettings(){
		if(isset($_POST["editAccountSettings"])){
            return true;
        }
        return false;
	}
	
	public function userPressedSubmitAccountSettings(){
		if(isset($_POST["submitAccountSettings"])){
            return true;
        }
        return false;
	}
	
	public function getOldPasswordInput(){
		if(isset($_POST["oldPassword"])){
			return $_POST["oldPassword"];
		}
	}
	
	public function getOldPasswordInput(){
		if(isset($_POST["newPassword"])){
			return $_POST["newPassword"];
		}
	}
	
	public function getOldPasswordInput(){
		if(isset($_POST["repeatedNewPassword"])){
			return $_POST["repeatedNewPassword"];
		}
	}
}
