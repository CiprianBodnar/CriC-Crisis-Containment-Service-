<?php 
	include_once('../dbConnect.php');

	$result = new \stdClass();
	if($_SESSION['loggedIn']===false){
		$result->error="User not logged in";
		die();
	}else{
		$eventId = htmlspecialchars($_POST['event-id'], ENT_QUOTES);
		$userId = -1;
		if(isset($_SESSION['id_user']))
			$userId = $_SESSION['id_user'];
		$stmt = $conn->prepare("delete from events where id_event=? and id_user=?");
		$stmt->bind_param('ii', $eventId, $userId);
		$stmt->execute();
		if($stmt->affected_rows > 0){
			$stmt = $conn->prepare("delete from comments where event_id=?");
			$stmt->bind_param('i', $eventId);
			$stmt->execute();
			$result->success = "Event removed";
			$stmt->close();
		}
		else{
			$result->error="No rights on this event";
		}
		$stmt = $conn -> prepare("update users set conn_date = sysdate() where id_user = ?");
		$stmt -> bind_param('i', $userId);
		$stmt -> execute();
		$stmt -> close();

	}
	echo json_encode($result);

?>