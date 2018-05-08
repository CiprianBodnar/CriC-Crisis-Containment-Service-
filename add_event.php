<?php 
include_once('dbConnect.php');

	$id_user = -1;
	if(isset($_SESSION['id_user']))
		$id_user = $_SESSION['id_user'];

	$stmt = $conn->prepare("INSERT INTO events (id_user, location, event_range, type, description, event_date) values(?, ?, ?, ?, ?, sysdate())");
	$stmt ->bind_param("isiss", $id_user, $_POST['location'], $_POST['range'], $_POST['type'], $_POST['desc']);
	$stmt->execute();
	$response = new \stdClass();
	$response -> id_user = $id_user;
	$response->id=-1;
	if($rs = $conn->query("select max(id_event) as max from events")){
		if($row = $rs->fetch_assoc()){
			$response -> id = $row['max'];
		}
	}
	echo json_encode($response);
	$conn->close();
 ?>