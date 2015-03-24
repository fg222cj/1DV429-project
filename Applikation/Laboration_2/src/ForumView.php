<?php

class ForumView {
	private $forumModel;
	
	public function __construct($forumModel) {
		$this->forumModel = $forumModel;
	}
	
	public function getThread() {
		return $_GET["thread"];
	}
	
	public function showForum() {
		$html = "<h2>SuperCoolAwesome Forum</h2>";
		
		$parentPosts = $this->forumModel->getTopPosts();
		
		$postsAsRows = "";
		
		foreach ($parentPosts as $post) {
			$postssAsRows .= "
			<tr>
				<td><a href='?forum&thread=" . $post->getPostId() . "'>" . $post->getTitle() . "</a></td>
				<td>" . $post->getMostRecentTime() . "</td>
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
		
		return $html;
	}
	
	public function showThread($parentId) {
		$html = "<h2>SuperCoolAwesome Forum</h2>";
		
		$parentPost = $this->forumModel->getPostById($parentId);
		$childPosts = $this->forumModel->getChildPosts($parentId);
		
		$html .= "<h3>" . $parentPost->getTitle() . "</h3>";
		
		$postsAsRows = "";
		
		foreach ($parentPosts as $post) {
			$postssAsRows .= "
			<tr>
				<td>" . $post->getTitle() . "</td>
				<td>" . $post->getMostRecentTime() . "</td>
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
		
		return $html;
	}
}


?>