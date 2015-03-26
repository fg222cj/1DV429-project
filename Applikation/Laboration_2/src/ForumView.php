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
	
	public function getPost() {
		if(isset($_POST["parentid"]) && isset($_POST["title"]) && isset($_POST["text"])
		&& isset($_POST["author"])) {
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
				<td>Most recent post</td>
			</tr>
			" . $postsAsRows . "
		</table>";
		
		$html .= $forumTable;
		
		// Fixa vettig author
		$forumForm = "
		<form method='post' action=''><br>
			<fieldset>
				<input type='hidden' name='author' value='" . $_SESSION['userID'] . "'>
				<input type='hidden' name='parentid' value='0'>
				<input type='text' name='title' maxlength='50'><br>
				<textarea name='text' maxlength='1024'></textarea><br>
				<input type='submit'>
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
			$delete = "<a href='?forum&thread='" . $parentId . "'&delete='" . $parentPost->getPostId() . "'>Delete this post</a>";
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
				$delete = "<a href='?forum&thread='" . $parentId . "'&delete='" .$post->getPostId() . "'>Delete this post</a>";
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
				<input type='hidden' name='author' value='1'>
				<input type='hidden' name='parentid' value='" . $this->getThread() . "'>
				<input type='hidden' name='title' value='reply'><br>
				<textarea name='text'></textarea><br>
				<input type='submit'>
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