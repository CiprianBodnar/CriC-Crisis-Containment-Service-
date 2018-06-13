<?php

include_once('../dbConnect.php');

function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if(!isset($_POST['email'])){
    echo json_encode(array("error"=>"Probleme la email"));
    die();
}
else{

    #echo json_encode(array("succ"=>" email"));
    $email = $_POST['email'];
    $key = generateRandomString();
    ini_set("SMTP","ssl://smtp.gmail.com");
    ini_set("smtp_port","465");
    if(preg_match('/^([a-zA-Z0-9]+[a-zA-Z0-9._%-]*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4})$/', $email)){
        $to = $email;
        $subject = "Trimitere cod de resetare parola cont CriC";
        $message = "Buna, \n \nVa puteti reseta parola la urmatoarea adresa http://localhost/cric/reset_password.php?key=";
        $message .= $key;
        $message .= "\n Va multumim ca aveti incredere in noi,\nEchipa CriC";
        $header = "From: fiicriciasi@gmail.com";

        mail($to, $subject, $message, $header);
        $to = htmlspecialchars($to, ENT_QUOTES);
        $key = htmlspecialchars($key, ENT_QUOTES);

        $stmt = $conn->prepare( "insert into reset_pwd (email, ekey) VALUES (?,?);");
        $stmt ->bind_param('ss',$email,$key);
        $stmt->execute();
        $stmt->close();
        echo json_encode(array("succ"=>"Bravo"));
    }
    else{
        echo json_encode(array("error"=>"Introduceti o adresa valida de email"));
        die();
    }
        
}

?>
