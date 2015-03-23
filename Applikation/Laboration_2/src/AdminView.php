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
			$contentString .="
			<li>UserName: " . $UsersAndRoles->getUsername() . "<br>
			Role: " . $UsersAndRoles->getRole(). "</li>
			<form method='post'>
				<input type='radio' name='role' value='1'>Admin
				<input type='radio' name='role' value='2'>Moderator
				<input type='radio' name='role' value='3'>User
			</form><br>
			";
		}
		
		$ret = "
				<h1>User List</h1>
				" . $this->showMessages() . "
				<ul>$contentString</ul>
				<input type='submit' class='small button' name='submit' value='Update'>
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
