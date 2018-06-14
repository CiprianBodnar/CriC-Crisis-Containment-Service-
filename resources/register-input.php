<?php
include_once ("database-connect.php");

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
   echo json_encode(array("redirect"=> "Redirectare spre home"));
   die();
}
   
if(!(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['verify_email']) && isset($_POST['password']) && isset($_POST['verify_password']) && isset($_POST['address'])) ) {
        echo json_encode(array("error" => "Eroare!"));
        die();
}
else {
    $errorHandler = new \stdClass();

    $errorHandler -> last_name_error = "";
    $errorHandler -> first_name_error = "";
    $errorHandler -> email_address_error = "";
    $errorHandler -> verify_email_address_error = "";
    $errorHandler -> password_error = "";
    $errorHandler -> verify_password_error = "";
    $errorHandler -> verify_password_error_same_email = "";
    $errorHandler -> address_error = "";
    $errorHandler -> different_email_address = "";
    $errorHandler -> email_address = "";
    $errorHandler -> verify_email_address = "";
    $errorHandler -> ok = "";
    $errorHandler -> same_user_error = "";
    $errorHandler -> data_validation_error = "";


    $first_name = $_POST['firstname'];
    $first_name = htmlspecialchars($first_name, ENT_QUOTES);
 
    $last_name = $_POST['lastname'];
    $last_name = htmlspecialchars($last_name, ENT_QUOTES);

    $email_address = $_POST['email'];
    $email_address = htmlspecialchars($email_address, ENT_QUOTES);

    $verify_email_address = $_POST['verify_email'];
    $verify_email_address = htmlspecialchars($verify_email_address, ENT_QUOTES);

    $password = htmlspecialchars($_POST['password']);
    $verify_password = htmlspecialchars($_POST['verify_password']);

    $address = $_POST['address'];
    $address = htmlspecialchars($address, ENT_QUOTES);

    $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $sql -> bind_param('s', $email_address);
    $sql -> execute();
    
    if($result = $sql -> get_result()) { 
        $row = $result -> fetch_assoc();
    }
        
    if($last_name === 'Nume') {
       $errorHandler -> last_name_error = 'Camp gol!';
    }

    if($first_name === 'Prenume') {
        $errorHandler -> first_name_error = 'Camp gol!';
    }

    if($email_address === 'your.email@yoursite.com') {
        $errorHandler -> different_email_address = 'Camp gol!';
    }   

    if(!(preg_match('/^([a-zA-Z0-9]+[a-zA-Z0-9._%-]*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4})$/', $email_address))) {
        $errorHandler -> email_address_error = 'Email incorect!';
    }

    if($email_address != $verify_email_address || $verify_email_address === 'your.email@yoursite.com') {
        $errorHandler -> verify_email_address_error = 'Adresele nu corespund!';
    }

    if(strlen($password) < 6 ) {
        $errorHandler -> password_error = 'Parola invalida!';
    } elseif ($password != $verify_password) {
        $errorHandler -> password_error = 'Parolele nu coincid!';
    }

    if($address === "") {
        $errorHandler -> address_error = 'Introduceti adresa!';
    }

    if($errorHandler -> last_name_error === "" && $errorHandler -> first_name_error === "" &&  $errorHandler -> different_email_address === "" && $errorHandler -> email_address_error === "" &&  $errorHandler -> verify_email_address_error === "" && $errorHandler -> password_error === "" && $errorHandler -> verify_password_error === "" && $errorHandler -> address_error === "") {

            $password = hash("sha256", $_POST['password']);
            $verify_password = hash("sha256", $_POST['verify_password']);

            if($row === NULL) {
                $errorHandler -> ok = "Inregistrare cu succes";
            
                $sql = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, address, conn_date) VALUES (?, ?, ?, ?, ?, sysdate())");
                
                $sql -> bind_param("sssss", $first_name, $last_name, $email_address, $password, $address);
                $sql -> execute();
                $sql -> close();

                $_SESSION["name"] = $first_name . " " . $last_name;
                $_SESSION["email"] = $email_address;
                echo json_encode(array("redirect"=> "Redirectare spre home"));
                die();
            }
            else {
                $errorHandler -> same_user_error = "Există deja un utilizator cu această adresa de e-mail!";
            }
    }
    else {
        $errorHandler -> data_validation_error = "Datele introduse în câmpurile marcate nu sunt valide!";
    }

    echo json_encode($errorHandler);
    die();
}

if(isset($_SESSION['loggedIn'])){
    $loggedIn = $_SESSION['loggedIn'];
    if($loggedIn)
        json_encode(array("redirect" => "Redirectare spre home"));
    }
    $conn->close();
?>