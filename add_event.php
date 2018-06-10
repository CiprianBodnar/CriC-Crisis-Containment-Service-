<?php 
include_once('dbConnect.php');

	$id_user = -1;
	if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
		$id_user = $_SESSION['id_user'];

	$desc = htmlspecialchars($_POST['desc'], ENT_QUOTES);
	$location = htmlspecialchars($_POST['location'], ENT_QUOTES);
	$type = htmlspecialchars($_POST['type'], ENT_QUOTES);
	$stmt = $conn->prepare("INSERT INTO events (id_user, location, event_range, type, description, event_date) values(?, ?, ?, ?, ?, sysdate())");
	$stmt ->bind_param("isiss", $id_user, $location, $_POST['range'], $type, $desc);
	$stmt->execute();
	$response = new \stdClass();
	$response -> id_user = $id_user;
	$response->id=-1;
	if($rs = $conn->query("select max(id_event) as max from events")){
		if($row = $rs->fetch_assoc()){
			$response -> id = $row['max'];
		}
	}
	if($id_user != -1){
		// increment posted events to build up the score by substracting valid events from posted events
		$stmt = $conn->prepare("select posted from users where id_user = ?");
		$stmt->bind_param('i', $id_user);
		$stmt->execute();
		$posted = $stmt->get_result()->fetch_assoc()["posted"];
		if($posted === null)
			$posted = 1;
		else{
			$posted = floatval($posted)+1;
		}
		$stmt = $conn->prepare("update users set posted = ? where id_user = ?");
		$stmt->bind_param('ii', $posted, $id_user);
		$stmt->execute();
		$stmt->close();
		// set last online datetime for current user
		$stmt = $conn -> prepare("update users set conn_date = sysdate() where id_user = ?");
		$stmt -> bind_param('i', $id_user);
		$stmt -> execute();
		$stmt -> close();
	}
	echo json_encode($response);

	$latLng = new \stdClass();
	$location = explode(" ", $location);
	$latLng -> lat = floatval($location[0]);
	$latLng -> lng = floatval($location[1]);

	$users = $conn->query("select id_user, address from users");
	while($user = $users->fetch_assoc()){
		$message;
		if($type === 'person')
			$message = "Va aflați pe raza unei persoane aflate in pericol.<br /><a href='map.php?view=".$response->id."'>informații</a>";
		else
			$message = "Va aflat pe raza unui pericol.<br /><a href='map.php?view=".$response->id."'>informații despre pericol.</a>";
		$user_id = floatval($user['id_user']);
		$user_address = explode(" ", $user['address']);
		$user_location =  new \stdClass();
		$user_location -> lat = floatval($user_address[0]);
		$user_location -> lng = floatval($user_address[1]);
		$d = pow($user_location->lat-$latLng->lat, 2)+ pow($user_location->lng-$latLng->lng, 2);
		$d = sqrt($d);
	    $d = $d*100000;
	    if($d < floatval($_POST['range'])){
	    	$stmt = $conn->prepare("insert into notifications (user_id, infos, notification_date, unread) values(?, ?, sysdate(), -1)");
	    	$stmt->bind_param('is', $user_id, $message);
	    	$stmt->execute();
	    	$stmt->close();
	    }

	}
 ?>