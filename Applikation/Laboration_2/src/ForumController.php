<?php
require_once("src/Post.php");
require_once("src/ForumView.php");
require_once("src/ForumModel.php");

class ForumController {
	private $forumModel;
	private $forumView;
	
	public function __construct() {
		$this->forumModel = new ForumModel();
		$this->forumView = new ForumView($this->forumModel);
	}
	
	public function doControl() {
		if(!isset($_SESSION["userID"])) {
			header('location: ?login');
		}
		
		if($this->forumView->getDelete() > 0) {
			$post = $this->forumModel->getPostById($this->forumView->getDelete());
			$postAuthor = $post->getAuthor();
			
			$currentUser = $this->forumModel->getUser($_SESSION["userID"]);
			$currentUserRole = $currentUser->getRole();
			
			if($post->getParentId() > 0 && $post->getPostId() > 0) {
				if($postAuthor == $_SESSION["userID"] || $currentUserRole == 2 || $currentUserRole == 1) {
					if($this->forumModel->deletePost($post)) {
						$this->forumView->setMessage("Deleted post successfully");
					}
					else {
						$this->forumView->setMessage("Post could not be deleted");
					}
				}
			} elseif($post->getPostId() > 0) {
				if($currentUserRole == 2 || $currentUserRole == 1 || ($postAuthor == $_SESSION["userID"] && count($this->forumModel->getChildPosts($post->getPostID())) < 1)) {
					$childPosts = $this->forumModel->getChildPosts($post->getPostId());
					
					foreach($childPosts as $childPost){
						$this->forumModel->deletePost($childPost);
					}
					
					if($this->forumModel->deletePost($post)) {
						$this->forumView->setMessage("Deleted post successfully");
					}
					else {
						$this->forumView->setMessage("Post could not be deleted");
					}
					return $this->forumView->showForum();
				}
				else {
					$this->forumView->setMessage("Thread can't be deleted when there are replies");
				}
			}
			else {
				$this->forumView->setMessage("Post does not exist");
			}
		}
		
		$post = $this->forumView->getPost();
		if(isset($post)) {
			try {
				if($this->forumModel->insertPost($post)) {
					$this->forumView->setMessage("Your post was submitted.");
				}
				else {
					$this->forumView->setMessage("Something fucked up. Sorry. Probably your own fault though.");
				}
			}
			catch(ValidationException $e) {
				switch($e->getMessage()) {
					case "TEXT_BAD_LENGTH":
						$this->forumView->setMessage("Your message was too long, the limit is 1024 characters.");
					case "TITLE_BAD_LENGTH":
						$this->forumView->setMessage("Your title was too long, the limit is 50 characters.");
				}
			}
			
		}
	
		if($this->forumView->getThread() > 0) {
			$post = $this->forumModel->getPostById($this->forumView->getThread());
			if($post->getParentId() == 0 && $post->getPostId() > 0) {
				return $this->forumView->showThread($this->forumView->getThread());
			}
		}
		return $this->forumView->showForum();	
	}
	
}

?>