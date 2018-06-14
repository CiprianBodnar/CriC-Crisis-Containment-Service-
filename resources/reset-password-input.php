<?php
include_once ("database-connect.php");

$key = "";
$error = "";
if(isset($_POST['key'])){
    $key = $_POST['key'];
}

$email='';
$ekey='';

$stmt = $conn->prepare("Select email, ekey from reset_pwd where ekey=? ");
$stmt -> bind_param("s",$key);
$stmt -> execute();
$stmt -> bind_result($email,$ekey);
$stmt -> fetch();
$stmt -> close();

$email = htmlspecialchars($email, ENT_QUOTES);
$ekey = htmlspecialchars($ekey, ENT_QUOTES);

if(!(isset($_POST['resetPassword']) && isset($_POST['resetVerifyPassword']))){
    echo json_encode(array("error"=>"Campuri inca necompletate"));
    die();
}
else{
    $errorHandler = new \StdClass();
    $errorHandler -> ok = "";
    $errorHandler -> passwordLength = "";
    $errorHandler -> passwordMatch = "";
    $errorHandler -> redirect = "";
    $errorHandler -> error = "";

    $resetPassword = $_POST['resetPassword'];
    $resetVerifyPassword = $_POST['resetVerifyPassword'];

    if($resetPassword !== $resetVerifyPassword)
        $errorHandler -> error = "Parolele nu se potrivesc";

    if($resetPassword==="" && $resetVerifyPassword==="")
        $errorHandler -> error = "Parola trebuie sa fie mai mare de 6 caractere";
    
    if(strlen($resetPassword) < 6 || strlen($resetVerifyPassword) < 6)
        $errorHandler -> error = "Parola trebuie sa fie mai mare de 6 caractere";
    
    if($errorHandler -> error === ""){
        $errorHandler -> ok = "Parola dumneavoastra a fost resetata";

        $resetPassword = hash("sha256", $resetPassword);
        $resetVerifyPassword = hash("sha256", $resetVerifyPassword);

        $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $stmt -> bind_param("ss", $resetPassword, $email);
        $stmt -> execute();
        $stmt -> close();

        $stmt = $conn->prepare("DELETE FROM reset_pwd WHERE email =?");
        $stmt -> bind_param("s", $email);
        $stmt -> execute();
        $stmt -> close();

        $errorHandler -> redirect = "redirect";

        $conn->close();
    }
    echo json_encode($errorHandler);
}
?>