<?php
require_once('src/UserRepository.php');

class ProfileModel {
	private $userRepository;
	
	public function __construct(){
		$this->userRepository = new UserRepository();
	}
	
	public function getUser($username){
		return $this->userRepository->getUserByName($username);
	}
	
	public function changePassword($user, $newpassword){
		$this->userRepository->changePassword($user, $newpassword);
	}

}