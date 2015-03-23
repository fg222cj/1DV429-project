<?php

require_once("src/Exceptions.php");

class Validation{
		// ----- CREDENTIALS VALIDATIONS -----
		
		// Checks if variable is of type string.
		private function validateString($var){
			if(!is_string($var)){
				throw new ValidationException("VARIABLE_NOT_STRING");
			}
		}
		
		// Checks the username length.
		private function validateUsernameLength($username){
			if(strlen($username) > 15 || strlen($username) <= 3){
				throw new ValidationException("USERNAME_BAD_LENGTH");
			}
		}
		
		// Makes sure username only contains alphabetic and numeric characters.
		private function validateUsernameCharacters($username){
			if(!ctype_alnum($username)){
				throw new ValidationException("USERNAME_BAD_CHARACTERS");
			}
		}
		
		// Checks the password length.
		private function validatePasswordLength($password){
			if(strlen($password) > 15 || strlen($password) < 8){
				throw new ValidationException("PASSWORD_BAD_LENGTH");
			}
		}
		
		// Makes sure password contains both uppercase & lowercase letters, and at least one numeric character.
		private function validatePasswordSecurity($password){
			if (!preg_match('/[A-Z]+[a-z]/', $password) || !preg_match('/[0-9]/', $password)){
			    throw new ValidationException("PASSWORD_NOT_SECURE");
			}
		}
		
		// Checks if new passwords match.
		private function compareNewPasswordInputs($newPasswordFirstInput, $newPasswordSecondInput){
			if($newPasswordFirstInput == $newPasswordSecondInput){
				throw new ValidationException("NEW_PASSWORDS_NOT_MATCHING");
			}
		}
		
		// Checks if the password is correct.
		private function validatePassword(){
			// TODO: Kolla så lösenordet är rätt!
		}
		
		// ----- FORUM VALIDATIONS -----
		
		// Checks post title length.
		private function validatePostTitleLength($title){
			if(strlen($title) > 30 || strlen($title) < 3){
				throw new ValidationException("TITLE_BAD_LENGTH");
			}
		}
		
		// Makes sure post contains at least one alphabetic character.
		private function validatePostCharacters($string){
			if(!preg_match('/[A-Za-z]/')){
				throw new ValidationException("POST_BAD_CHARACTERS");
			}
		}
	
}
?>