<?php 
	include_once('../dbConnect.php');

	$result = new \stdClass();
	if($_SESSION['loggedIn']===false){
		$result->error="User not logged in";
		echo json_encode($result);
		die();
	}else{
		$commentId = htmlspecialchars($_POST['comment-id'], ENT_QUOTES);
		$userId = -1;
		if(isset($_SESSION['id_user']))
			$userId = $_SESSION['id_user'];
		$stmt = $conn->prepare("delete from comments where id=?");
		$stmt->bind_param('i', $commentId);
		$stmt->execute();
		$result->success = "Comment removed";
		echo json_encode($result);
		$stmt->close();
		$stmt = $conn -> prepare("update users set conn_date = sysdate() where id_user = ?");
		$stmt -> bind_param('i', $userId);
		$stmt -> execute();
		$stmt -> close();
	}

?>