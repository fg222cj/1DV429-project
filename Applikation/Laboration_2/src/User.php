<?php

	class User{
		
		private $userId; 
		private $username;
		private $password;
	
		public function __construct($userId, $username, $password = null){
			$this->userId = $userId;
			$this->username = $username;
			$this->password = $password;
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
	}