<?php 
	include_once("../dbConnect.php");

	$type = htmlspecialchars($_POST['type']);
	$args = htmlspecialchars($_POST['args']);
	$args = explode(" ", $args);
	// if type === event | person
	// args[0] = event_id
	// args[1] = lat
	// args[2] = lng
	// args[3] = range

	// else if type === posted_info
	// args[0] = user_id
	// args[1] = poster name

	// else if type === event_removed
	// args[0] = user_id
	// args[1] = event type



	if($type === 'event' || $type === 'person'){
		$eventId = floatval($args[0]);
		$latLng = new \stdClass();
		$latLng -> lat = floatval($args[1]);
		$latLng -> lng = floatval($args[2]);
		$range = floatval($args[3]);

		$message;
		if($type === 'person')
			$message = "Va aflați pe raza unei <strong>persoane aflate in pericol</strong>. <a href='map.php?view=".$eventId."'>Vedeți informații</a>";
		elseif($type === 'event')
			$message = "Va aflat pe raza unui <strong>pericol</strong>. <a href='map.php?view=".$eventId."'>Informații despre pericol.</a>";
		
		$users = $conn->query("select id_user, address from users");
		while($user = $users->fetch_assoc()){
			$user_id = floatval($user['id_user']);
			$user_address = explode(" ", $user['address']);
			$user_location =  new \stdClass();
			$user_location -> lat = floatval($user_address[0]);
			$user_location -> lng = floatval($user_address[1]);
			$d = pow($user_location->lat-$latLng->lat, 2)+ pow($user_location->lng-$latLng->lng, 2);
			$d = sqrt($d);
		    $d = $d*100000;
		    if($d < $range && ((!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false) || $_SESSION['id_user'] != $user_id)){
		    	if(!$stmt = $conn->prepare("insert into notifications (user_id, infos, notification_date, unread) values(?, ?, sysdate(), -1)")){
		    		echo json_encode(array("error"=>"unexpected error"));
		    		die();
		    	}
		    	$stmt->bind_param('is', $user_id, $message);
		    	$stmt->execute();
		    	$stmt->close();
		    }

		}
	}elseif ($type === 'posted_info') {
		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false){
			echo json_encode(array("error"=>"Nu sunteti autentificat"));
			die();
		}

		$userId = floatval($args[0]);
		$posterName = $args[1];
		for($i = 2; $i<count($args); $i++)
			$posterName.=' '.$args[$i];
		
		$message = "<strong>".$posterName."</strong> a oferit informații despre dumneavoastră. <a href='home.php?user=".$userId."'>Vedeți toate informațiile</a>";
		if(!$stmt = $conn->prepare("insert into notifications (user_id, infos, notification_date, unread) values(?, ?, sysdate(), -1)")){
    		echo json_encode(array("error"=>"unexpected error"));
    		die();
    	}
		$stmt->bind_param('is', $userId, $message);
		$stmt->execute();
		$stmt->close();
	}elseif ($type === 'event_removed') {
		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false){
			echo json_encode(array("error"=>"Nu sunteti autentificat"));
			die();
		}
		$userId = floatval($args[0]);
		$eventTitle = $args[1];
		$message = 'Evenimentul raportat de dumneavoastră (<strong>'.$eventTitle.'</strong>) a fost șters datorită voturilor negative.';
		if(!$stmt = $conn->prepare("insert into notifications (user_id, infos, notification_date, unread) values(?, ?, sysdate(), -1)")){
    		echo json_encode(array("error"=>"unexpected error"));
    		die();
    	}
		$stmt->bind_param('is', $userId, $message);
		$stmt->execute();
		$stmt->close();
	}

	echo json_encode(array("success"=>"done"));
 ?>