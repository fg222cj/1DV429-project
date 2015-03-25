<?php
require_once("src/UserRepository.php");

class AdminModel {
	private $userRepository;
	
	public function __construct() {
		$this->userRepository = new UserRepository();
	}
	
	public function getList()
	{
		return $this->userRepository->getAllUsers();
	}
	
	public function changeRole($role, $Id) {
		if($this->userRepository->changeRole($role, $Id)) {
			return true;
		}
		return false;
	}
	
	
}


?>