<?php

class Validation{
		private function validateString($string){
			if(!is_string($string)){
				throw new ValidationException("VARIABLE_NOT_STRING");
			}
		}
		
		private function validateUsernameLength($username){
			if(strlen($username) > 15 || strlen($username) <= 0){
				throw new ValidationException("USERNAME_BAD_LENGTH");
			}
		}
		
		private function validateUsernameCharacters($username){
			if(!ctype_alnum($username)){
				throw new ValidationException("USERNAME_BAD_CHARACTERS");
			}
		}
		
		private function validatePasswordLength($password){
			if(strlen($password) > 20 || strlen($password) < 8){
				throw new ValidationException("PASSWORD_BAD_LENGTH");
			}
		}
		
		private function validatePasswordSecurity($password){
			if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)){
			    throw new ValidationException("PASSWORD_NOT_SECURE");
			}
		}
}
?>