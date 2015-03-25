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
		$post = $this->forumView->getPost();
		if(isset($post)) {
			if($this->forumModel->insertPost($post)) {
				$this->forumView->setMessage("Your post was submitted.");
			}
			else {
				$this->forumView->setMessage("Something fucked up. Sorry. Probably your own fault though.");
			}
		}
		
		if($this->forumView->getThread() > 0) {
			return $this->forumView->showThread($this->forumView->getThread());
		}
		else {
			return $this->forumView->showForum();
		}
	}
	
}

?>