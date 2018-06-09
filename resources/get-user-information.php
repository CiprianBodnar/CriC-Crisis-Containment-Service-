<?php
include_once('../dbConnect.php');
if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']===false){
    echo json_encode(array("error"=>"Nu sunteti autentificat!"));
    die();
}
else{
    $searchResult = new \stdClass();
    if(isset($_SESSION['id_user'])){
        $id_user = $_SESSION["id_user"];
        $stmt = $conn->prepare("Select firstname,lastname,email,address FROM Users where id_user= ? ");
        $stmt -> bind_param("i",$id_user);
        $stmt -> execute();
        if ($result = $stmt ->get_result()){
			if($row = $result -> fetch_assoc()){
                $searchResult -> user = new \stdClass();
                $searchResult -> user -> firstname = $row['firstname'];
                $searchResult -> user -> lastname = $row['lastname'];
                $searchResult -> user -> address = $row['address'];
                $searchResult -> user -> email = $row['email'];
            }
        }
       
        echo json_encode ($searchResult);
        $stmt -> close();
    }
    else{
        echo json_encode(array("error"=>"Nu aveti privilegii!"));
        die();
    }
}
?>