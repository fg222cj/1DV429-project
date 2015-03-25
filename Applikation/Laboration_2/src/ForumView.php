<?php
require_once("src/Post.php");

class ForumView {
	private $forumModel;
	private $message;
	
	public function __construct($forumModel) {
		$this->forumModel = $forumModel;
		$this->message = "";
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
			$post = new Post(0, $_POST["parentid"], $_POST["title"], $_POST["text"], $_POST["author"], null);
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
				<input type='hidden' name='author' value='1'>
				<input type='hidden' name='parentid' value='0'>
				<input type='text' name='title'><br>
				<textarea name='text'></textarea><br>
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
		
		$html .= "<h3>" . $parentPost->getTitle() . "</h3>";
		$html .= "<p>" . $parentPost->getTimePosted() . "</p>";
		$html .= "<p>" . $parentPost->getText() . "</p>";
		
		$postsAsRows = "";
		
		foreach ($childPosts as $post) {
			$postsAsRows .= "
			<tr>
				<td><h4>" . $post->getTitle() . "</h4></td>
				<td>" . $post->getTimePosted() . "</td>
			</tr>
			<tr>
				<td colspan='2'>" . $post->getText() . "</td>
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
		
		$forumForm = "
		<form method='post' action=''><br>
			<fieldset>
				<input type='hidden' name='author' value='1'>
				<input type='hidden' name='parentid' value='" . $this->getThread() . "'>
				<input type='text' name='title'><br>
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