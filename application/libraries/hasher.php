<?php
	/*Creates the hashing algorithm that will be used throughout the site for user account passwords*/ 
	require_once(APPPATH."libraries/PasswordHash.php");
	$hasher = new PasswordHash(8, TRUE); //creates the global variable for the password hasher.
?>