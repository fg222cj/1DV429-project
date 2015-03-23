<?php
	
	class Post {
		private $postId;
		private $title;
		private $author;
		private $timePosted;
		
		public function __construct($postId, $title, $author, $timePosted) {
			$this->postId = $postId;
			$this->title = $title;
			$this->author = $author;
			$this->timePosted = $timePosted;
		}
		
		public function getPostId() {
			return $this->postId;
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