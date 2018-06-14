<?php
	include_once('database-connect.php');
	if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false){
		echo json_encode(array("error"=>"Nu sunteți autentificat"));
		die();
	}
	$id_user_in_danger = floatval($_POST['id_user']);
	$info = $_POST['message'];
	$address = null;

	if(isset($_POST['address'])){
		$address = $_POST['address'];
		$address = str_replace(array("ș","ă","ț","Ș","Ț","Ă","Â","â"),array("s","a","t","s","t","a","a","a"),$address);
		$address = htmlspecialchars($address,ENT_QUOTES);
	}

	$info = htmlspecialchars($info , ENT_QUOTES);

	$id_user_posting = $_SESSION['id_user'];		

	$stmt = $conn->prepare("insert into person_finder (id_user_in_danger, id_user_posting, details, address, conn_date) values(?, ?, ?, ?, sysdate())");
	$stmt->bind_param('iiss', $id_user_in_danger, $id_user_posting, $info, $address);
	$stmt->execute();
	echo json_encode(array("success"=>"Inforațiile au trmise"));
	$stmt->close();
	$stmt = $conn -> prepare("update users set conn_date = sysdate() where id_user = ?");
	$stmt -> bind_param('i', $id_user_posting);
	$stmt -> execute();
	$stmt -> close();
?>