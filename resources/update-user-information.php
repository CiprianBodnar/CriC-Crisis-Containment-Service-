<?php
    include_once('../dbConnect.php');
    $firsname = "";
    $lastname = "";
    $email = "";
    $address = "";

    if(isset($_SESSION['id_user'])){
        $id_user  = $_SESSION["id_user"];
        $errorHandler = new \stdClass();
        $firsname = htmlspecialchars($_POST['firstname'],ENT_QUOTES);
        $lastname = htmlspecialchars($_POST['lastname'],ENT_QUOTES);
        $email = htmlspecialchars($_POST['email'],ENT_QUOTES);
        $address = htmlspecialchars($_POST['address'],ENT_QUOTES);
        $password = htmlspecialchars($_POST['password'],ENT_QUOTES);

        $errorHandler -> ok = "";
        $errorHandler -> firstnameError = "";
        $errorHandler -> lastnameError = "";
        $errorHandler -> emailError = "";
        $errorHandler -> addressError = "";
        $errorHandler -> passwordError = "";
        
        $stmt = $conn->prepare("select password from users where id_user = ?");
        $stmt->bind_param('i',$id_user);
        $stmt->execute();
        $stmt -> bind_result($passwordFromDb);
        $stmt -> fetch();
        $stmt -> close();

        

        $password =  hash("sha256", $password);

        if($password != $passwordFromDb)
            $errorHandler -> passwordError = "Parola gresita";

        if($firsname === "")
            $errorHandler -> firstnameError = "Numele de familie trebuie sa fie valid.";
        if($lastname === "")
            $errorHandler -> lastnameError = "Prenumele trebuie sa fie valid.";
        if($email === "" || !(preg_match('/^([a-zA-Z0-9]+[a-zA-Z0-9._%-]*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4})$/',$email)))
            $errorHandler -> emailError = "Email-ul trebuie sa fie valid.";
        if($address === "")
            $errorHandler -> addressError = "Adresa trebuie sa fie valid.";
       
        if($errorHandler->passwordError === "" &&  $errorHandler->firstnameError === "" && $errorHandler->lastnameError === "" && $errorHandler->emailError === "" && $errorHandler->addressError ===""){
            $errorHandler -> ok = "Datele dvs au fost schimbate";
            $update_stmt = $conn->prepare("update users set firstname = ? , lastname = ? , email = ? , address = ? where id_user = ?");
            $update_stmt->bind_param('sssss', $firsname,$lastname,$email,$address,$id_user);
            $update_stmt->execute();
            $update_stmt->close();
            $_SESSION ["name"] = $lastname.' '.$firsname;
           
        }
        echo json_encode($errorHandler);
    }
?>