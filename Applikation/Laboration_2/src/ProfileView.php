<?php

class ProfileView {
	private $model;
	private $msg = "";

	public function __construct(ProfileModel $model){
		$this->model = $model;
	}

	
	public function showProfile(){
		$ret = "<h2>'s profile</h2>
		<form method='post'>
		<input type='submit' name='editAccountSettings' value='Edit account settings'/>
		</form>
		";
		return $ret;
	}
	
	public function setMessage($message){
		$this->msg .= "<li>" . $message . "</li>";
	}
	
	public function showEditAccountSettingsForm(){
	    $ret = "
	    <a href='?'>Back</a>
	    <h2>Edit account settings</h2>
	    <form method='post'>
		<fieldset>
		<legend>Change password</legend>
		<ul>$this->msg</ul>
		Old password: <input type='password' name='oldPassword'><br>
		New password: <input type='password' name='newPassword'><br>Repeat new password: 
		<input type='password' name='repeatedNewPassword'><br>Skicka: 
		<input type='submit' name='submitAccountSettings' value='Save'>
		</fieldset>
		</form>
	    ";
	    
	    return $ret;
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
	
	public function getNewPasswordFirstInput(){
		if(isset($_POST["newPassword"])){
			return $_POST["newPassword"];
		}
	}
	
	public function getNewPasswordSecondInput(){
		if(isset($_POST["repeatedNewPassword"])){
			return $_POST["repeatedNewPassword"];
		}
	}
}
