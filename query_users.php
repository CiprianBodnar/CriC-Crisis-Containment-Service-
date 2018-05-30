<?php
    include_once("dbConnect.php");

    if(!isset($_SESSION['loggedIn']))
        die("User not logged in");

    if(!isset($_POST['pre_name']))
        die("Name not found");
    
    $pre_name = trim("%{$_POST['pre_name']}%");

    if(!($stmt=$conn->prepare("Select concat(lastname,' ',firstname) as 'Name', id_user as 'Id' from Users where lower(lastname) LIKE lower(?) or lower(firstname) LIKE lower(?) "))){
        echo json_encode(array("error"=>("Could not post your report. ".$conn->error)));
        die();        
    }
    
    $stmt -> bind_param("ss",$pre_name,$pre_name);
	$stmt -> execute();
    $users = array();
    if($result = $stmt->get_result()){
        while($row = $result->fetch_assoc()){
            $user = new \stdClass();
            $user->name = $row['Name'];
            $user->id_user = $row['Id'];
            

            array_push($users,$user);
        }
    }
    echo json_encode($users);
?>