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
		if(isset($this->forumView->getPost())) {
			$post = $this->forumView->getPost();
			if($this->forumModel->insertPost($post)) {
				$this->forumView->setMessage("Your post was submitted.");
			}
			else {
				$this->forumView->setMessage("Something fucked up. Sorry.");
			}
		}
		
		if($this->forumView->getThread() > 0) {
			$this->forumView->showThread($this->forumView->getThread());
		}
		else {
			$this->forumView->showForum();
		}
	}
	
}

?>