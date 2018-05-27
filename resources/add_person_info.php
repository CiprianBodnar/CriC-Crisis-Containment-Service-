<?php
if(isset($_POST['ofera']) and isset($_POST['Nume2'])){
	$name = $_POST['Nume2'];
	$info = $_POST['Mesaj'];
	$address = null;
	if(isset($_POST['checkbox']))
		$address = $_POST['address'];

	$name = htmlspecialchars($name,ENT_QUOTES);
	$info = htmlspecialchars($info , ENT_QUOTES);
	$address = str_replace(array("ș","ă","ț","Ș","Ț","Ă","Â","â"),array("s","a","t","s","t","a","a","a"),$address);
	$address = htmlspecialchars($address,ENT_QUOTES);
	$token = strtok($name, ' ');
	$lastname = $token;
	$firstname = '';


if(isset($_SESSION['id_user'])) 
	if($_SESSION['loggedIn'] == true) {
		$id_user = $_SESSION['id_user'];		
		while($token !== false) {
			$token = strtok(" ");

			if($firstname === '')
				$firstname = $firstname.$token;
			else
				if($token != '')
					$firstname = $firstname.' '.$token;
		}
		
		$sql = "Select id_user from users where lastname = '".$lastname."' and firstname = '".$firstname."';";
		
		if ($result = $conn->query($sql)){
			if($row = $result->fetch_row()) {	
				$sql = "INSERT INTO Person_Finder (id_user_in_danger, id_user_posting, details, address, conn_date)  VALUES ('".$row[0]."','".$id_user."', '".$info."', '".$address."' , sysdate());"; 
				if(!$conn->query($sql))
					echo "Eroare" . $conn->error;
			}
		}
		else {
			echo $conn->error;
		}
	}
}
?>