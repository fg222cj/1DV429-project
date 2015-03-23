<?php

class ForumView {
	private $forumModel;
	
	public function __construct($forumModel) {
		$this->forumModel = $forumModel;
	}
	
	public function showForum() {
		$html = "<h2>SuperCoolAwesome Forum</h2>";
		
		$parentPosts = $this->forumModel->getParentPosts();
		
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
	
	public function showThread($parentId) {
		// samma som ovan fast visa bara poster med parent-id som tillhör länken man klickat på
	}
}


?>