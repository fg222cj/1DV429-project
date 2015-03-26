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
			return $this->forumView->showThread($this->forumView->getThread());
		}
		else {
			return $this->forumView->showForum();
		}
	}
	
}

?>