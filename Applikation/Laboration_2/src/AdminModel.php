<?php
require_once("src/UserRepository.php");

class AdminModel {
	private $userRepository;
	
	public function __construct() {
		$this->userRepository = new UserRepository();
	}
	
	//Get all users in database.
	public function getList()
	{
		return $this->userRepository->getAllUsers();
	}
	
	//Get user by id.
	public function getUser($id) {
		return $this->userRepository->getUserByID($id);
	}
	
	//Change role on a user.
	public function changeRole($role, $Id) {
		if($this->userRepository->changeRole($role, $Id)) {
			return true;
		}
		return false;
	}
	
	
}


?>