<?php
include_once('dbConnect.php');

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==true)
    header("Location: home.php");

if(!isset($_POST['email']) && isset($_POST['password'])){
    echo json_encode(array("error"=>"Probleme email+parola"));
    die();
}
else{
    $id_user = '';
    $firstname='';
    $lastname='';
    $searchResult = new \stdClass();

    $email = $_POST['email'];
    $email = htmlspecialchars($email,ENT_QUOTES);    
    $password = hash("sha256",$_POST['password']);

    $stmt = $conn->prepare("Select id_user,firstname,lastname FROM Users where email =? and password = ?");
    $stmt -> bind_param("ss",$email,$password);
    $stmt -> execute();
    if ($result = $stmt ->get_result()){
        if($row = $result -> fetch_assoc()){
            $searchResult  = new \stdClass();
            $searchResult -> id_user = $row['id_user'];
            $searchResult -> firstname =  $row['firstname'];
            $searchResult -> lastname = $row['lastname'];
        }
    }

    if($searchResult->id_user != null && $searchResult->firstname !=null && $searchResult->lastname != null){
        $_SESSION ["name"] = $searchResult->firstname . " " . $searchResult->$lastname;
        $_SESSION["loggedIn"] = TRUE;
        $_SESSION["id_user"] = $searchResult->id_user;
        $stmt = $conn -> prepare("UPDATE users set conn_date=sysdate() where email = ?");
        $stmt -> bind_param("s",$email);
        $stmt -> execute();
        $stmt -> close();
    }
    else{
        echo json_encode(array("error"=>"Email sau parola gresita"));
    }
}
?>