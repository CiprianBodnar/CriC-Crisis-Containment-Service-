<?php 
	include_once('database-connect.php');
	$begin_date=trim($_POST['begin']);
	$end_date=trim($_POST['end']);

	if(!($stmt = $conn->prepare("select id_event, events.id_user, location, event_range, type, description, event_date, firstname, lastname, address, posted from events left join users on users.id_user = events.id_user where event_date >= str_to_date(?,'%d-%m-%Y') and event_date <= (str_to_date(?,'%d-%m-%Y')+1)"))){
        echo json_encode(array("error"=>("Could not post your report. ".$conn->error)));
        die();                       
    }
	
	$stmt -> bind_param("ss",$begin_date,$end_date);
	$stmt -> execute();
	$events = array();
	
	if ($res = $stmt->get_result()){
		
        while($row = $res->fetch_assoc()){
            $user_address;
            if ($row['address'] == null)
                $user_address = array(-1, -1);
            else
                $user_address = explode(" ", $row['address']);
        	$event = new \stdClass();
        	$event->id = floatval($row['id_event']);
            $event->user = new \stdClass();
        	$event->user->id = floatval($row['id_user']);
            $event->user->firstname = $row['firstname'];
            $event->user->lastname = $row['lastname'];
			$event->user->location = new \stdClass();
            $event->user->location->lat = floatval($user_address[0]);
            $event->user->location->lng = floatval($user_address[1]);

            //score for user;
            $score_stmt = $conn->prepare("select count(*) as valid from events where id_user = ?");
            $score_stmt->bind_param('i', $event->user->id);
            $score_stmt->execute();
            $valid_events = floatval($score_stmt->get_result()->fetch_assoc()['valid']);
            if($row['posted']!=0)
                $event->user->score= $valid_events/floatval($row['posted']);
            else
                $event->user->score = 1;

            if(isset($_SESSION['id_user'])){
                $user_id = $_SESSION['id_user'];
                if(!($fbstmt = $conn -> prepare("select feedback from feedback where id_danger = ? and id_user = ?"))){
                    echo json_encode(array("error"=>"Could not post your request. ".$conn->error));
                    die();
                }
                $fbstmt->bind_param("ii", $event->id, $user_id);
                $fbstmt->execute();
                if($fbrow = $fbstmt->get_result()->fetch_assoc()){
                    $event->feedbackValue = $fbrow['feedback'];
                }
                $fbstmt->close();
                    
            }
            
            if($event->user->firstname === null) {
                $event->user->firstname = 'anonim';
                $event->user->lastname = '';
                $event->user->address = '';
            }
			
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