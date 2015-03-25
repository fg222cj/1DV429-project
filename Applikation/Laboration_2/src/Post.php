<?php
	
	class Post {
		private $postId;
		private $parentId;
		private $title;
		private $text;
		private $author;
		private $timePosted;
		
		public function __construct($postId = 0, $parentId = 0, $title, $text, $author, $timePosted = null) {
			$this->postId = $postId;
			$this->parentId = $parentId;
			$this->title = $title;
			$this->text = $text;
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
		
		public function getText() {
			return $this->text;
		}
		
		public function getAuthor() {
			return $this->author;
		}
		
		public function getTimePosted() {
			return $this->timePosted;
		}
	}


?>