<?php
    include_once("dbConnect.php");

    //$pre_name = $_POST['pre_name'];
    $pre_name = "j";
    $sql = "Select id_user,firstname,lastname from Users where lower(lastname) LIKE lower('%".$pre_name."%') UNION SELECT id_user,firstname,lastname from Users where lower(firstname) LIKE lower('%".$pre_name."%');";
    
    if(!$conn->query($sql)){
        echo json_encode(array("error"=>("Could not post your report.".$conn->error)));
        die();
    }
    
    $users = array();
    if($result = $conn->query($sql)){
        while($row = $result->fetch_assoc()){
            $user = new \stdClass();
           // $user->id_user = floatval($row['id_user']);
            $user->firstname = $row['firstname'];
            $user->lastname = $row['lastname'];
            array_push($users,$user);
        }
    }
    echo json_encode($users);
?>