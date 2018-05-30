<?php 
	include_once('dbConnect.php');
	$begin_date=trim($_POST['begin']);
	$end_date=trim($_POST['end']);

	if(!($stmt = $conn->prepare("select id_event, events.id_user, location, event_range, type, description, event_date, firstname, lastname, address from events join users on users.id_user = events.id_user where event_date >= str_to_date(?,'%d-%m-%Y') and event_date <= str_to_date(?,'%d-%m-%Y')"))){
        echo json_encode(array("error"=>("Could not post your report. ".$conn->error)));
        die();                       
    }
	
	$stmt -> bind_param("ss",$begin_date,$end_date);
	$stmt -> execute();
	$events = array();
	
	if ($res = $stmt->get_result()){
		
        while($row = $res->fetch_assoc()){
			
        	$event = new \stdClass();
        	$event->id = floatval($row['id_event']);
            $event->user = new \stdClass();
        	$event->user->id = floatval($row['id_user']);
            $event->user->firstname = $row['firstname'];
            $event->user->lastname = $row['lastname'];
			$event->user->address = $row['address'];
			
        	$event->location = new \stdClass();
        	$coords = explode(" ", $row["location"]);
        	$event->location->lat = floatval($coords[0]);
        	$event->location->lng = floatval($coords[1]);
        	$event->range = floatval($row['event_range']);
        	$event->type = $row['type'];
        	$event->desc = $row['description'];
        	$event->date = date('Y/m/d H:i:s', strtotime($row['event_date']));
            if(isset($_SESSION['id_user']) && $row['id_user'] == $_SESSION['id_user'])
                $event->removeable = true;
        	array_push($events, $event);
        }
    }
    echo json_encode($events);
 ?>