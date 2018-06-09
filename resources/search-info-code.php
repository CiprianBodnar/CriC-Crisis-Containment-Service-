<?php 
	include_once("../dbConnect.php");

		$user_id = $_POST['Id'];
		$searchResult = new \stdClass();

		$sql = $conn -> prepare("select firstname, lastname, address, conn_date from users where id_user = ?");
		$sql -> bind_param('i', $user_id);
		$sql -> execute();

		if ($result = $sql ->get_result()){
			if($row = $result -> fetch_assoc()){
				$searchResult -> user = new \stdClass();
				$searchResult -> user -> firstname = $row['firstname'];
				$searchResult -> user -> lastname = $row['lastname'];
				$searchResult -> user -> address = $row['address'];
				$searchResult -> user -> conn_date = date('Y/m/d H:i:s', strtotime($row['conn_date']));
			}

		}

		$sql = $conn -> prepare("select firstname, lastname, details, person_finder.address, person_finder.conn_date from person_finder join users on id_user_posting = id_user where id_user_in_danger = ?");
		$sql -> bind_param('i', $user_id);
		$sql -> execute();
		
		$searchResult -> posted = array();
		if($result = $sql -> get_result()){
			while($row = $result -> fetch_assoc()){
				$info = new \stdClass();
				$info -> firstname = $row['firstname'];
				$info -> lastname = $row['lastname'];
				$info -> details = $row['details'];
				$info -> address = $row['address'];
				$info -> conn_date = date('Y/m/d H:i:s', strtotime($row['conn_date']));
				array_push($searchResult -> posted, $info); 
			}
		}
		echo json_encode($searchResult);

		$sql -> close();
	
?>