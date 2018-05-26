<?php
    include_once("dbConnect.php");

    if(!isset($_SESSION['loggedIn']))
        die("User not logged in");

    if(!isset($_POST['pre_name']))
        die("Name not found");
    $pre_name = $_POST['pre_name'];
    
    $sql = "Select concat(firstname,' ',lastname) as 'Name', id_user as 'Id' from Users where lower(lastname) LIKE lower('%".$pre_name."%') or lower(firstname) LIKE lower('%".$pre_name."%')";

    if(!$conn->query($sql)){
        echo json_encode(array("error"=>("Could not post your report.".$conn->error)));
        die();
    }
    
    $users = array();
    if($result = $conn->query($sql)){
        if($row = $result->fetch_assoc()){
            $user = new \stdClass();
            $user->name = $row['Name'];
            $user->id_user = $row['Id'];

            array_push($users,$user);
        }
    }
    echo json_encode($users);
?>