<?php
include_once('database-connect.php');

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === TRUE){
    echo json_encode(array("redirect"=>"Sunteti deja autentificat"));
    die();
}

if(! (isset($_POST['password']) && isset($_POST['email']))){
    echo json_encode(array("error"=>"Probleme email+parola"));
     die();
}
else{    
     $searchResult = new \stdClass();
     $searchResult -> id_user = "";
     $searchResult -> firstname =  "";
     $searchResult -> lastname = "";

     $email = $_POST['email'];
     $email = htmlspecialchars($email,ENT_QUOTES);    
     $password = hash("sha256",$_POST['password']);

     $stmt = $conn->prepare("select id_user,firstname,lastname from users where email =? and password =?");
     $stmt -> bind_param("ss",$email,$password);
     $stmt -> execute();
     if ($result = $stmt ->get_result()){
        if($row = $result -> fetch_assoc()){
            $searchResult -> id_user = $row['id_user'];
            $searchResult -> lastname = $row['lastname'];
            $searchResult -> firstname = $row['firstname'];
        }
    }
    $stmt -> close();

    if($searchResult->id_user != "" && $searchResult->firstname !="" && $searchResult->lastname != ""){
        $_SESSION ["name"] = $searchResult->firstname.' '.$searchResult->lastname; 
        $_SESSION["loggedIn"] = TRUE;
        $_SESSION["id_user"] = $searchResult->id_user;
        $_SESSION["email"] = $email;

        $stmt = $conn -> prepare("UPDATE users set conn_date=sysdate() where email = ?");
        $stmt -> bind_param("s",$email);
        $stmt -> execute();
        $stmt -> close();
        echo json_encode(array("succ"=>"Autentificare reusita"));
        die();
    }
    else
         echo json_encode(array("error"=>"Email sau parola gresita"));

}
if(isset($_SESSION['loggedIn'])){
    $loggedIn = $_SESSION['loggedIn'];
if($loggedIn ===TRUE)
    echo json_encode(array("redirect"=>"Sunteti deja autentificat"));
}
?>