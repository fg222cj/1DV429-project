<?php
require_once("src/Post.php");
require_once("src/UserRepository.php");

class ForumView {
	private $forumModel;
	private $message;
	private $activeUser;
	private $userRepository;
	
	public function __construct($forumModel) {
		$this->forumModel = $forumModel;
		$this->message = "";
		$this->activeUser = $this->forumModel->getUser($_SESSION["userID"]);
		$this->userRepository = new UserRepository();
	}
	
	public function getThread() {
		if(isset($_GET["thread"])) {
			return $_GET["thread"];
		}
		return 0;
	}
	
	public function getDelete() {
		if(isset($_GET["delete"])) {
			return $_GET["delete"];
		}
		return 0;
	}
	
	public function getPost() {
		if(isset($_POST["parentid"]) && isset($_POST["title"]) && isset($_POST["text"])) {
			$post = new Post(0, $_POST["parentid"], $_POST["title"], $_POST["text"], $_SESSION["userID"], null);
			return $post;
		}
		return null;
	}
	
	public function showForum() {
		$html = "<h2>SuperCoolAwesome Forum</h2>";
		$html .= $this->message;
		
		$parentPosts = $this->forumModel->getTopPosts();
		
		$postsAsRows = "";
		
		foreach ($parentPosts as $post) {
			$postsAsRows .= "
			<tr>
				<td><a href='?forum&thread=" . $post->getPostId() . "'>" . $post->getTitle() . "</a></td>
				<td>" . $post->getTimePosted() . "</td>
			</tr>";
		}
		
		$forumTable = "
		<table>
			<tr>
				<td>Title</td>
				<td>Post created</td>
			</tr>
			" . $postsAsRows . "
		</table>";
		
		$html .= $forumTable;
		
		$forumForm = "
		<form method='post' action=''><br>
			<fieldset>
			<legend>Create new post</legend>
				<input type='hidden' name='parentid' value='0'>
				<label for='title'>Title</label>
				<input type='text' id='title' name='title' maxlength='50'><br>
				<label for='text'>Text</label>
				<textarea id='text' name='text' maxlength='1024'></textarea><br>
				<input type='submit' class='small button'>
			</fieldset>
		</form>
		";
		
		$html .= $forumForm;
		
		return $html;
	}
	
	public function showThread($parentId) {
		$html = "<h2>SuperCoolAwesome Forum</h2>";
		$html .= $this->message;
		
		$parentPost = $this->forumModel->getPostById($parentId);
		$childPosts = $this->forumModel->getChildPosts($parentId);
		
		$delete = "";
		if($this->activeUser->getRole() <= 2 || $this->activeUser->getUserId() == $parentPost->getAuthor()) {
			$delete = "<a href='?forum&thread=" . $parentId . "&delete=" . $parentPost->getPostId() . "'>Delete this post</a>";
		}
		
		$user = $this->userRepository->getUserByID($parentPost->getAuthor());
		
		
		$html .= "<h3>" . $parentPost->getTitle() . "</h3>";
		$html .= "<p>Posted by " . $user->getUsername() . " " . $parentPost->getTimePosted() . " " .  $delete . "</p>";
		$html .= "<p>" . $parentPost->getText() . "</p>";
		
		$postsAsRows = "";
		
		foreach ($childPosts as $post) {
			$delete = "";
			$commentUser = $this->userRepository->getUSerByID($post->getAuthor());
			
			if($this->activeUser->getRole() <= 2 || $this->activeUser->getUserId() == $post->getAuthor()) {
				$delete = "<a href='?forum&thread=" . $parentId . "&delete=" .$post->getPostId() . "'>Delete this post</a>";
			}
			$postsAsRows .= "
			<tr>
				<td><p>Posted by " . $commentUser->getUsername() . " " . $post->getTimePosted() . " " . $delete . "</p>
				<p>" . $post->getText() . "</p></td>
			</tr>";
		}
		
		$forumTable = "
		<table>
			" . $postsAsRows . "
		</table>";
		
		$html .= $forumTable;
		
		$forumForm = "
		<form method='post' action=''><br>
			<fieldset>
				<legend>Reply</legend>
				<input type='hidden' name='parentid' value='" . $this->getThread() . "'>
				<input type='hidden' name='title' value='reply'><br>
				<label for='text'>Text</label>
				<textarea id='text' name='text' maxlength='1024'></textarea><br>
				<input type='submit' class='small button'>
			</fieldset>
		</form>
		";
		
		$html .= $forumForm;
		
		return $html;
	}
	
	public function setMessage($newMessage) {
		$this->message .= "<p>" . $newMessage . "</p>";
	}
}


?>