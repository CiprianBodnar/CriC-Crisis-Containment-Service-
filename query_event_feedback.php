<?php 
	include_once('dbConnect.php');
    if(!isset($_POST['event_id'])){
        echo json_encode(array("error"=>("Could not post your report. ".$conn->error)));
        die();
    }
	$event_id = $_POST['event_id'];

	$sql = "select id, user_id, event_id, content, post_date, firstname, lastname from comments 
            join users on users.id_user=comments.user_id 
            where event_id = ".$event_id." 
            order by post_date;";

	if(!$conn->query($sql)){
		echo json_encode(array("error"=>("Could not post your report. ".$conn->error)));
		die();
	}
	$comments = array();
	if ($result = $conn ->query($sql)){
        while($row = $result->fetch_assoc()){
        	$comment = new \stdClass();
            $comment -> id = floatval($row['id']);
            $comment -> eventId = floatVal($row['event_id']);
            $comment -> date = date('Y/m/d H:i:s', strtotime($row['post_date']));
            $comment -> user = new \stdClass();
            $comment -> user -> id = floatVal($row['user_id']);
            $comment -> user -> firstname = $row['firstname'];
            $comment -> user -> lastname = $row['lastname'];
            $comment -> content = $row['content'];
            $comment -> removeable = false;
            if($_SESSION['loggedIn'] === true){
                if($_SESSION['id_user'] == $row['user_id'])
                    $comment -> removeable = true;
            }

        	array_push($comments, $comment);
        }
    }
    $sql = "select count(*) as upvotes from feedback where feedback = 1 and id_danger = ".$event_id;

    if(!$conn->query($sql)){
        echo json_encode(array("error"=>("Could not post your report. ".$conn->error)));
        die();
    }
    $up;
    if ($result = $conn ->query($sql)){
        if($row = $result->fetch_assoc()){
            $up = floatVal($row['upvotes']);
        }
    }
    $sql = "select count(*) as downvotes from feedback where feedback = -1 and id_danger = ".$event_id;
    if(!$conn->query($sql)){
        echo json_encode(array("error"=>("Could not post your report. ".$conn->error)));
        die();
    }
    $down;
    if ($result = $conn ->query($sql)){
        if($row = $result->fetch_assoc()){
            $down = floatVal($row['downvotes']);
        }
    }
    $feedback = new \stdClass();
    $feedback -> votes = new \stdClass();
    $feedback -> votes -> up = $up;
    $feedback -> votes -> down = $down;
    $feedback -> comments = $comments;
    echo json_encode($feedback);
 ?>