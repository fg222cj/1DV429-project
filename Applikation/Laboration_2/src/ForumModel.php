<?php
require_once("src/ForumRepository.php");
require_once("src/UserRepository.php");
require_once("src/Validation.php");

class ForumModel {
	private $forumRepository;
	private $userRepository;
	private $validation;
	
	public function __construct() {
		$this->forumRepository = new ForumRepository();
		$this->userRepository = new UserRepository();
		$this->validation = new Validation();
	}
	
	public function getTopPosts() {
		$posts = array();
		$posts = $this->forumRepository->getTopPosts();
		return $posts;
	}
	
	public function getChildPosts($parentId) {
		$posts = array();
		$posts = $this->forumRepository->getPostsByParent($parentId);
		return $posts;
	}
	
	public function insertPost($post) {
		$this->validateForumPost($post);
		return $this->forumRepository->insertPost($post);
	}
	
	public function getPostById($id) {
		return $this->forumRepository->getPostById($id);
	}
	
	public function validateForumPost($post) {
		$this->validation->validatePostTitleLength($post->getTitle());
		$this->validation->validatePostTextLength($post->getText());
	}
	
	public function getUser($id) {
		$user = $this->userRepository->getUserById($id);
		return $user;
	}
}


?>