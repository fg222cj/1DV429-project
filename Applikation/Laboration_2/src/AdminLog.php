<?php

	class AdminLog{
		
		private $id; 
		private $userId;
		private $oldRole;
		private $newRole;
		private $timedate;
	
		public function __construct($Id, $userId, $oldRole, $newRole, $timedate){
			$this->id = $Id;
			$this->userId = $userId;
			$this->oldRole = $oldRole;
			$this->newRole = $newRole;
			$this->timedate = $timedate;
		}
		
		public function getLogId() {
			return $this->id;
		}
		
		public function getUserId(){
			return $this->userId;
		}
		
		public function getOldRole(){
			return $this->oldRole;
		}
		
		public function getNewRole() {
			return $this->newRole;
		}
		
		public function getTimedate() {
			return $this->timedate;
		}
	}