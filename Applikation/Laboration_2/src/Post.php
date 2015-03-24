<?php
	
	class Post {
		private $postId;
		private $parentId;
		private $title;
		private $author;
		private $timePosted;
		
		public function __construct($postId, $parentId, $title, $author, $timePosted) {
			$this->postId = $postId;
			$this->parentId = $parentId;
			$this->title = $title;
			$this->author = $author;
			$this->timePosted = $timePosted;
		}
		
		public function getPostId() {
			return $this->postId;
		}
		
		public function getParentId() {
			return $this->parentId;
		}
		
		public function getTitle() {
			return $this->title;
		}
		
		public function getAuthor() {
			return $this->author;
		}
		
		public function getTimePosted() {
			return $this->timePosted;
		}
	}


?>