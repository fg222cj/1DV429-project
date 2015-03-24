<?php

Class AdminView
{
	private $UserRepository;
	private $messages;
	
	// Istället för strängberoenden
	//private $compactListLocation = "compactlist";
	
	public function __construct(UserRepository $UserRepository)
	{
		$this->UserRepository = $UserRepository;
		$this->messages = array();
	}
	
	// Hämtar ut alla användare och deras roller
	public function getList()
	{
		return $this->UserRepository->getAllUsers();
	}
	
	// Visar den kompakta listan. Returnerar HTML-sträng.
	public function ShowRoleList()
	{
		$AllUserAndRoles = $this->getList();
		$contentString = "";
		
		foreach($AllUserAndRoles as $UsersAndRoles)
		{
			$adminchecked = "";
			$moderatorchecked = "";
			$userchecked = "";
			$role = "";

			switch ($UsersAndRoles -> getRole()) {
				case "1":
					$adminchecked = "checked";
					$role = "Admin";
					break;
				case "2":
					$moderatorchecked = "checked";
					$role = "Moderator";
					break;
				case "3":
					$userchecked = "checked";
					$role = "User";
					break;
			}

			$contentString .="
			<li>UserName: " . $UsersAndRoles->getUsername() . "<br>
			Role: " . $role . "</li>
			<form method='post' action=''>
				<input type='hidden' name='user' value= " . $UsersAndRoles->getUserId() . ">
				<input type='radio' name='role' value='1' $adminchecked >Admin
				<input type='radio' name='role' value='2' $moderatorchecked >Moderator
				<input type='radio' name='role' value='3' $userchecked >User <br>
				<input type='submit' class='small button' name='submit' value='Update'>
			</form><br>
			";
		}
		
		$ret = "
				<h1>User List</h1>
				" . $this->showMessages() . "
				<ul>$contentString</ul>
		";
		
		return $ret;
	}
	
	// Returnerar true om användaren klickar på 'Update'.
	public function userPressedUpdate(){
        if(isset($_POST["submit"])){
            return true;
        }
        return false;
    }
	
	// Lägger till ett meddelande i $message-arrayen.
	public function addMessage($message)
	{
		array_push($this->messages, $message);
	}
	
	// Läger till rättmeddelande i $message-arrayen.
	public function setSuccessMessage()
	{
		$this->addMessage("Operation was successful.");
	}
	
	// Lägger till felmeddelande i $message-arrayen.
	public function setErrorMessage()
	{
		$this->addMessage("An unknown error has occured!");
	}
	
	// Visar meddelanden.
	private function showMessages()
	{
		$ret = "";
		// Loopar igenom messages-arrayen och skriver ut meddelanden.
		foreach($this->messages as $message)
		{
			$ret .= '<p>' . $message . '</p>';
		}
		
		return $ret;
	}
}
