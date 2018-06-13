<?php
	include_once('../dbConnect.php');

	if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false){
		echo json_encode(array("error"=>"Nu sunteti autentificat"));
		die();
	}
	$userId = $_SESSION['id_user'];
	$score_stmt = $conn->prepare("select count(*) as valid from events where id_user = ?");
    $score_stmt->bind_param('i', $userId);
    $score_stmt->execute();
    $valid_events = floatval($score_stmt->get_result()->fetch_assoc()['valid']);
    $posted_stmt = $conn->prepare("select posted from users where id_user = ?");
    $posted_stmt->bind_param('i', $userId);
    $posted_stmt->execute();
    $posted = floatval($posted_stmt->get_result()->fetch_assoc()['posted']);
    if($posted == 0 || $valid_events != $posted){
    	echo json_encode(array("error"=>"Scorul dvs. nu este suficient de mare"));
		die();
    }

	$ID_USER = -1;
	$RANGE = 10000;
	$TYPE = 'safehouse';
	$target_file = $_FILES["file"]["tmp_name"];
	$file_type= strtolower(pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION));
	if(mime_content_type($target_file)!='text/plain'){
		echo json_encode(array("error"=>"Formatul fișierului este invalid"));
		die();
	}
	if(filesize($target_file)>10000){
		echo json_encode(array("error"=>"Dimensiunea fișierului depășește 1MO"));
		die();	
	}
	if (($handle = fopen($target_file, "r")) !== FALSE) {
	    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	    	if(count($data)!=3){
	    		echo json_encode(array("error"=>"Formatul inregistrărilor este incorect"));
	    		die();
	    	}
	        $desc = $data[0];
	        $lat = floatval($data[1]);
	        $lng = floatval($data[2]);
	        if($lat === 0 || $lng === 0){
	        	echo json_encode(array("error"=>"Coordonatele sunt invalide"));
	        	die();
	        }
	        $location = $lat.' '.$lng;
	        $verifyStmt = $conn->prepare("select count(*) as existent from events where location = ?");
	        if(!$verifyStmt){
	        	echo json_encode(array("error"=>$conn->error));
				die();
	        }
	        $verifyStmt->bind_param('s', $location);
	        $verifyStmt->execute();
	        $verify = floatval($verifyStmt->get_result()->fetch_assoc()['existent']);

	        if($verify > 0){
	        	echo json_encode(array("error"=>"Înregistrarea '".$desc."' există deja (sau alt adăpost la aceleași coordonate)"));
				die();
	        }

	        $stmt = $conn->prepare("INSERT INTO events (id_user, location, event_range, type, description, event_date) values(?, ?, ?, ?, ?,sysdate())");
	        $stmt ->bind_param("isiss",$ID_USER, $location, $RANGE, $TYPE, $desc);
	        $stmt->execute();
	        $stmt->close();
	    }
	    fclose($handle);
	}
	$conn->close();
	echo json_encode(array("success"=>"Adăposturile au fost înregistrate cu succes"));
?>
