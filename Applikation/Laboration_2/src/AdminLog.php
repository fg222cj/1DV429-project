<?php

	class AdminLog{
		
		private $id;
		private $adminId; 
		private $userId;
		private $oldRole;
		private $newRole;
		private $timedate;
	
		public function __construct($Id ,$adminId, $userId, $oldRole, $newRole, $timedate){
			$this->id = $Id;
			$this->adminId = $adminId;
			$this->userId = $userId;
			$this->oldRole = $oldRole;
			$this->newRole = $newRole;
			$this->timedate = $timedate;
		}
		
		public function getId() {
			return $this->id;
		}
		
		public function getAdminId() {
			return $this->adminId;
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