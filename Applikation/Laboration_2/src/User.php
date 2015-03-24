<?php

	class User{
		
		private $userId; 
		private $username;
		private $password;
		private $role;
	
		public function __construct($userId, $username, $password, $role = 3){
			$this->userId = $userId;
			$this->username = $username;
			$this->password = $password;
			$this->role = $role;
		}
		
		public function getUserId() {
			return $this->userId;
		}
		
		public function getUsername(){
			return $this->username;
		}
		
		public function getPassword(){
			return $this->password;
		}
		
		public function getRole() {
			return $this->role;
		}
	}