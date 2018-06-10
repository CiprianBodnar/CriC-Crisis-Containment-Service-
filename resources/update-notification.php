<?php 
	include_once('../dbConnect.php');
	if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false){
		echo json_encode(array("error"=>"Nu sunteți autentificat"));
		die();
	}
	$notId = floatval($_POST['not_id']);
	$notState = floatval($_POST['not_state']);

	if($notState == -1 || $notState == 0){
		$notState = 1;
	}
	else{
		$notState = 0;
	}

	$stmt = $conn->prepare("update notifications set unread = ? where id = ?");
	$stmt->bind_param('ii', $notState, $notId);
	$stmt->execute();

	echo json_encode(array("newState"=>$notState));
	$stmt->close();
?>