<?php 
	include_once('dbConnect.php');
    if(!isset($_POST['event_id'])){
        echo json_encode(array("error"=>("Could not post your report. ".$conn->error)));
        die();
    }
	$event_id = $_POST['event_id'];    
    if(!($stmt = $conn->prepare("select id, user_id , content, post_date, firstname, lastname from comments 
                            join users on users.id_user=comments.user_id where event_id = ? order by post_date;"))){
        echo json_encode(array("error"=>("Could not post your report. ".$conn->error)));
        die();                       
    }

    $stmt -> bind_param("i",$event_id);
    $stmt -> execute();
    $res = $stmt->get_result();

	$comments = array();
    while($row = $res->fetch_assoc()){
        $comment = new \stdClass();
        $comment -> id = floatval($row['id']);
        $comment -> eventId = floatVal($event_id);
        $comment -> date = date('Y/m/d H:i:s', strtotime($row['post_date']));
        $comment -> user = new \stdClass();
        $comment -> user -> id = floatVal($row['user_id']);
        $comment -> user -> firstname = $row['firstname'];
        $comment -> user -> lastname = $row['lastname'];
        $comment -> content = $row['content'];
        $comment -> removeable = false;
        if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true){
            if($_SESSION['id_user'] == $row['user_id'])
                $comment -> removeable = true;
        }
        array_push($comments, $comment);
    }

    $stmt = $conn->prepare("select count(*) as upvotes from feedback where feedback = 1 and id_danger =?");
    $stmt-> bind_param("i",$event_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $up;
    if($row = $res->fetch_assoc())
        $up = floatval($row['upvotes']);
   
    $stmt = $conn->prepare("select count(*) as downvotes from feedback where feedback = -1 and id_danger =?");
    $stmt-> bind_param("i",$event_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $down;
    if($row = $res->fetch_assoc())
        $down = floatval($row['downvotes']);
     
    $feedback = new \stdClass();
    $feedback -> votes = new \stdClass();
    $feedback -> votes -> up = $up;
    $feedback -> votes -> down = $down;
    $feedback -> comments = $comments;
    
    echo json_encode($feedback);
 ?>