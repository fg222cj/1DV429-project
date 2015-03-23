<?php

require_once("src/ProfileModel.php");
require_once("src/ProfileView.php");
require_once("src/Validation.php");

class ProfileController {
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
		// Check if user wants to edit their account settings.
		if($this->view->userPressedEditAccountSettings()){
			return $this->view->showEditAccountSettingsForm();
		}
		
		// Check if user wants to save their account settings changes.
		if($this->view->userPressedSubmitAccountSettings()){
			// Retrieve inputs from input fields.
			$this->oldPasswordInput = $this->view->getOldPasswordInput();
			$this->newPasswordFirstInput = $this->view->getNewPasswordFirstInput();
			$this->newPasswordSecondInput = $this->view->getNewPasswordSecondInput();
			
			try{
				$this->validation->validateString($this->oldPasswordInput);
				$this->validation->validateString($this->newPasswordFirstInput);
				
				$this->validation->validatePasswordLength($this->newPasswordFirstInput);
				$this->validation->validatePasswordSecurity($this->newPasswordFirstInput);
					
				$this->validation->compareNewPasswordInputs($this->newPasswordFirstInput, $this->newPasswordSecondInput);
				$this->validation->validatePassword($this->oldPasswordInput);
			}
			catch(ValidationException $e){
				switch ($e->getMessage()){
					case "VARIABLE_NOT_STRING":
						$this->view->setMessage("Invalid input!");
						
					case "PASSWORD_BAD_LENGTH":
						$this->view->setMessage("Password needs to be in the range of 8-15 characters");
						
					case "PASSWORD_NOT_SECURE":
						$this->view->setMessage("Password needs at least one upper case letter, one lower case letter and one numeric character.");
						
					case "NEW_PASSWORDS_NOT_MATCHING":
						$this->view->setMessage("The new passwords are not matching!");
						
					case "INVALID_PASSWORD":
						$this->view->setMessage("Wrong password!");
				}
			}
			// Save new password and show success message.
			// TODO: Spara nya lösenordet.
			
			$this->view->setMessage("New password was successully saved!");
			return $this->view->showEditAccountSettingsForm();
		}
		
		// Returns profile if nothing was clicked.
		return $this->view->showProfile();
	}
}