<?php 
include_once('dbConnect.php');

	if(isset($_SESSION['loggedIn'])){
		echo "inserting report";
	}
	else{
		echo "You are not logged in.";
	}

 ?>