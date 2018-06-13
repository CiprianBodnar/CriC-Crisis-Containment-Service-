<?php
    if(!(isset($_POST['lastname']) && isset($_POST['firstname']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message']))){
        echo json_encode(array("error"=>"Campuri inca necompletate"));
        die();
    }
    else{
        $errorHandler = new \StdClass();
        $last_name = $_POST['lastname'];
        $first_name = $_POST['firstname'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $errorHandler -> ok = "";
        $errorHandler -> lastName = "";
        $errorHandler -> firstName = "";
        $errorHandler -> email = "";
        $errorHandler -> subject = "";
        $errorHandler -> message = "";

        if(!(preg_match('/^([a-zA-Z0-9]+[a-zA-Z0-9._%-]*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4})$/', $email)) || $email === "your.email@yoursite.com"){
            $errorHandler -> email = "Mail necorespunzator";
        }

        if(!(strlen($subject)>=5) || $subject === "Subiect"){
            $errorHandler -> subject = "Subiect gol sau prea scurt";
        }

        if($message === 'Mesaj' || strlen($message) == 0) {
            $errorHandler -> message = "Mesaj gol";
        }

        if($last_name == 'Nume') {
            $errorHandler -> lastName = "Campul nume este gol";
        }

        if($first_name == 'Prenume') {
            $errorHandler -> firstName = "Campul prenume este gol";
        }

        if($errorHandler-> lastName === "" && $errorHandler -> firstName === "" && $errorHandler -> message === "" && $errorHandler -> subject === "" && $errorHandler -> email === "") {
            $errorHandler -> ok = "Mesajul dumneavoastra a fost trimis";
            $to = "fiicriciasi@gmail.com";
            $header = "From: fiicriciasi@gmail.com";
            $mail_body = "Nume: ".$last_name;
            $mail_body .= "\nPrenume: ".$first_name;
            $mail_body .= "\nE-Mail: ".$email;
            $mail_body .= "\n".$message;

            mail($to, $subject, $mail_body, $header);
        }
        echo json_encode($errorHandler);
    }
?>