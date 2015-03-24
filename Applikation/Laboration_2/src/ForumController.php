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
		if($this->forumView->getThread() > 0) {
			$this->forumView->showThread($this->forumView->getThread());
		}// Lägg till lämplig action i view (showpost eller nåt) med parent-id för tråden.
		else {
			$this->forumView->showForum();
		}
	}
	
}

?>