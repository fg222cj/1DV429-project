<?php

	class PasswordUpdateLog{
		
		private $ID; 
		private $userID;
		private $timedate;
		private $IP;
	
		public function __construct($ID, $userID, $timedate, $IP){
			$this->ID = $ID;
			$this->userID = $userID;
			$this->timedate = $timedate;
			$this->IP = $IP;
		}
		
		public function getLogId() {
			return $this->ID;
		}
		
		public function getUserId(){
			return $this->userID;
		}
		
		public function getTimedate(){
			return $this->timedate;
		}
		
		public function getIP() {
			return $this->IP;
		}
	}