<?php 
	include_once('../dbConnect.php');

	$result = new \stdClass();
	if($_SESSION['loggedIn']===false){
		$result->error="User not logged in";
		echo json_encode($result);
		die();
	}else{
		$eventId = htmlspecialchars($_POST['event-id'], ENT_QUOTES);
		$userId = -1;
		if(isset($_SESSION['id_user']))
			$userId = $_SESSION['id_user'];
		$commentContent = htmlspecialchars($_POST['comment-content'], ENT_QUOTES);
		$stmt = $conn->prepare("insert into comments (user_id, event_id, content, post_date) values(?, ?, ?, sysdate())");
		$stmt->bind_param('iis', $userId, $eventId, $commentContent);
		$stmt->execute();
		$result->success = "Comentariu adăugat";
		echo json_encode($result);
		$stmt->close();
		$stmt = $conn -> prepare("update users set conn_date = sysdate() where id_user = ?");
		$stmt -> bind_param('i', $userId);
		$stmt -> execute();
		$stmt -> close();
	}

?>