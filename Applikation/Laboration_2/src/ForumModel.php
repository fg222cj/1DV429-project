<?php
require_once("src/ForumRepository.php");

class ForumModel {
	private $forumRepository;
	
	public function __construct() {
		$this->forumRepository = new ForumRepository();
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
		return $this->forumRepository->insertPost($post);
	}
	
	public function getPostById($id) {
		return $this->forumRepository->getPostById($id);
	}
}


?>