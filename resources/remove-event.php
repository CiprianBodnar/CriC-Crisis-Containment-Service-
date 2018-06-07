<?php 
	include_once('../dbConnect.php');

	$result = new \stdClass();
	if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']===false){
		$result->error="Nu sunteți autentificat";
		die();
	}else{
		$eventId = htmlspecialchars($_POST['event-id'], ENT_QUOTES);
		$userId = -1;
		if(isset($_SESSION['id_user']))
			$userId = $_SESSION['id_user'];

		// decrement posted events for building up score 
		$stmt = $conn->prepare("select posted from users where id_user = ?");
		$stmt->bind_param('i', $userId);
		$stmt->execute();
		$posted = $stmt->get_result()->fetch_assoc()["posted"];
		if($posted === null || $posted === 0)
			$posted = 0;
		else{
			$posted = floatval($posted)-1;
		}
		$stmt = $conn->prepare("update users set posted = ? where id_user = ?");
		$stmt->bind_param('ii', $posted, $userId);
		$stmt->execute();
		$stmt->close();

		$stmt = $conn->prepare("delete from events where id_event=? and id_user=?");
		$stmt->bind_param('ii', $eventId, $userId);
		$stmt->execute();
		if($stmt->affected_rows > 0){
			$stmt = $conn->prepare("delete from comments where event_id=?");
			$stmt->bind_param('i', $eventId);
			$stmt->execute();
			$stmt->close();
			$stmt = $conn->prepare("delete from feedback where id_danger=?");
			$stmt->bind_param('i', $eventId);
			$stmt->execute();
			$result->success = "Evenimentul a fost sters";
			$stmt->close();
		}
		else{
			$result->error="Nu aveți drepturi asupra acestui eveniment";
		}
		$stmt = $conn -> prepare("update users set conn_date = sysdate() where id_user = ?");
		$stmt -> bind_param('i', $userId);
		$stmt -> execute();
		$stmt -> close();

	}
	echo json_encode($result);

?>