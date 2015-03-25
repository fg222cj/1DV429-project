<?php

	class LoginLog{
		
		private $ID; 
		private $username;
		private $timedate;
		private $IP;
		private $success;
	
		public function __construct($ID, $username, $timedate, $IP, $success){
			$this->ID = $ID;
			$this->username = $username;
			$this->timedate = $timedate;
			$this->IP = $IP;
			$this->success = $success;
		}
		
		public function getLogId() {
			return $this->ID;
		}
		
		public function getUsername(){
			return $this->username;
		}
		
		public function getTimedate(){
			return $this->timedate;
		}
		
		public function getIP() {
			return $this->IP;
		}
		
		public function getSuccessCode() {
			return $this->success;
		}
	}