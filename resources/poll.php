<?php 
	include_once('../dbConnect.php');
	if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false){
		echo json_encode(array("error"=>"Nu sunteti autentificat"));
		die();
	}
	$all = false;
	if(isset($_POST['all']))
		$all = true;
	$user_id = $_SESSION['id_user'];
	$notifications = array();
	if(!$stmt = $conn->prepare("select count(case when unread = -1 then 1 end) as new, count(case when unread=0 or unread=-1 then 1 end) as unread from notifications where user_id = ?")){
		echo json_encode(array("error"=>$conn->error()));
		die();
	}
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$row = $stmt->get_result()->fetch_assoc();
	$stmt->close();
	$response = new \stdClass();
	$response->new = floatval($row['new']);
	$response->unread = floatval($row['unread']);
	if($response->new>0 || $all){
		$stmt=$conn->prepare("select * from notifications where user_id=? order by notification_date desc");
		$stmt->bind_param('i', $user_id);
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_assoc()){
			$notification = new \stdClass();
			$notification->id = $row['id'];
			$notification->info = $row['infos'];
			$notification->date = date('Y/m/d H:i:s', strtotime($row['notification_date']));
			$notification->state = $row['unread'];
			if ($row['unread'] == -1) {
				$updateStmt = $conn->prepare("update notifications set unread=0 where id=?");
				$updateStmt->bind_param('i', $notification->id);
				$updateStmt->execute();
				$updateStmt->close();
			}
			array_push($notifications, $notification);
		}
		$response->notifications=$notifications;
	}
	echo json_encode($response);
 ?>