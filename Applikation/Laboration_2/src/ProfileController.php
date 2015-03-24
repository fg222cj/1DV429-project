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
			
			$exceptionThrown = false;
			
			try{
				$this->validation->validateString($this->oldPasswordInput);
				$this->validation->validateString($this->newPasswordFirstInput);
				
				$this->validation->validatePasswordLength($this->newPasswordFirstInput);
				$this->validation->validatePasswordSecurity($this->newPasswordFirstInput);
					
				$this->validation->compareNewPasswordInputs($this->newPasswordFirstInput, $this->newPasswordSecondInput);
				$this->validation->verifyPassword($this->oldPasswordInput);
			}
			catch(ValidationException $e){
				$exceptionThrown = true;
				switch ($e->getMessage()){
					case "VARIABLE_NOT_STRING":
						$this->view->setMessage("Invalid input!");
						break;
						
					case "PASSWORD_BAD_LENGTH":
						$this->view->setMessage("Password needs to be in the range of 8-15 characters");
						break;
						
					case "PASSWORD_NOT_SECURE":
						$this->view->setMessage("Password needs at least one upper case letter, one lower case letter and one numeric character.");
						break;
						
					case "NEW_PASSWORDS_NOT_MATCHING":
						$this->view->setMessage("The new passwords are not matching!");
						break;
						
					case "INVALID_PASSWORD":
						$this->view->setMessage("Wrong password!");
						break;
				}
			}
			// Save new password and show success message.
			if($exceptionThrown == false){
				try{
					$this->model->changePassword($this->model->getUser($_SESSION['username']), $this->newPasswordFirstInput);
				}
				catch(DatabaseException $e){
					switch ($e->getMessage()){
						case "PASSWORD_CHANGE":
							$this->view->setMessage("An error occured! Password did not change properly.");
							
						default:
							$exceptionThrown = true;
							break;
					}
				}
				
				if($exceptionThrown == false){
					$this->view->setMessage("New password was successully saved!");
					return $this->view->showEditAccountSettingsForm();
				}
				else{
					return $this->view->showEditAccountSettingsForm();
				}
			}
			else{
				return $this->view->showEditAccountSettingsForm();
			}
		}
		
		// Returns profile if nothing was clicked.
		return $this->view->showProfile();
	}
}