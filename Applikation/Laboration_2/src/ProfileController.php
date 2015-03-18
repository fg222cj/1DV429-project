<?php

require_once("src/ProfileModel.php");
require_once("src/ProfileView.php");
require_once("src/Validation.php");

class LoginController {
	private $view;
	private $model;
	private $validation;
	private $oldPasswordInput;
	private $newPasswordFirstInput;
	private $newPasswordSecondInput;
		
	public function __construct(){
		$this->model = new ProfileModel();
		$this->view = new ProfileView($this->model);
		$this->validation = new Validation();
	}
	
	public function doControll(){
		if($this->view->userPressedEditAccountSettings()){
			return $this->view->showEditAccountSettingsForm();
		}
		
		if($this->view->userPressedSubmitAccountSettings()){
			// Retrieve inputs from input fields.
			$this->oldPasswordInput = $this->view->getOldPasswordInput();
			$this->newPasswordFirstInput = $this->view->getNewPasswordFirstInput();
			$this->newPasswordSecondInput = $this->view->getNewPasswordSecondInput();
			
			$this->validation->validateString($this->oldPasswordInput);
			$this->validation->validateString($this->newPasswordFirstInput);
			$this->validation->validatePasswordLength($this->newPasswordFirstInput);
			$this->validation->validatePasswordSecurity($this->newPasswordFirstInput);
				
			// Makes sure the old password is correct and that the two inputs for new password matches.
			if($this->model->checkOldPassword && $this->view->compareNewPasswordInputs($this->newPasswordFirstInput, $this->newPasswordSecondInput)){
				
				// TODO: Spara nya lösenordet.
				
				return $this->view->showProfile();
			}
			else{
				// TODO: Felmeddelanden, stannar på samma sida & inget sparas.
			}
		}
		
		return $this->view->showProfile();
	}
}