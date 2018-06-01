<?php 
	include_once('../dbConnect.php');

	$response = new \stdClass();
	if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']===false){
		$response->error = "Nu sunteți autentificat";
		echo json_encode($response);
		die();
	}
	$user_id = $_SESSION['id_user'];
	$event_id = $_POST['event_id'];
	$feedback = floatval($_POST['feedback_val']);

	if($feedback == 0){
		if(!($stmt = $conn->prepare("delete from feedback where id_user = ? and id_danger = ?"))){
		    $response->error="Unexpected error. ".$conn->error;
		    echo json_encode($response);
		    die();                       
		}
		$stmt->bind_param("ii", $user_id, $event_id);
		$stmt->execute();
		$response->success="feedback removed";
		echo json_encode($response);
		die();
	}
	$sql;
	if(!($stmt = $conn->prepare("select feedback from feedback where id_user = ? and id_danger = ?"))){
	    $response->error="Unexpected error. ".$conn->error;
	    echo json_encode($response);
	    die();                       
	}
	$stmt->bind_param("ii", $user_id, $event_id);
	$stmt->execute();
	$sql;
	if($res = $stmt->get_result()){
		if($row = $res->fetch_assoc()){
			$sql = "update feedback set feedback = ? where id_user = ? and id_danger = ?";
		}
		else{
			$sql = "insert into feedback(feedback, id_user, id_danger) values(?, ?, ?)";
		}
	}
	else{
		$response->error="internal errror";
		echo json_encode($response);
		die();
	}
	$stmt->close();
	if(!$stmt = $conn->prepare($sql)){
		$response->error="Unexpected error. ".$conn->error;
	    echo json_encode($response);
	    die();   
	}
	$stmt->bind_param("iii", $feedback, $user_id, $event_id);
	$stmt->execute();
	$stmt->close();
	$response->success="feedback updated";
	echo json_encode($response);

?>