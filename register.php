<?php

include_once ("dbConnect.php");


$error = "";
if(isset($_POST['submit'])) {
    $first_name = $_POST['prenume'];
    $last_name = $_POST['nume'];
    $email_adress = $_POST['email'];
    $verify_email_address = $_POST['verifica_email'];
    $password = hash("sha256", $_POST['parola']);
    $verify_password = hash("sha256", $_POST['verifica_parola']);
    $address = $_POST['formatted-address'];

    //echo $address;
    $address = str_replace(array("ș","ă","ț","Ș","Ț","Ă","Â","â"),array("s","a","t","s","t","a","a","a"),$address);
   // $address = normalizer_normalize($address);
    //echo $address;

    $sql = "SELECT * FROM Users WHERE email='".$email_adress."';";

    if($result = $conn->query($sql)) {
        $row = $result->fetch_row();
        
            if(preg_match('/^([a-zA-Z0-9]+[a-zA-Z0-9._%-]*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4})$/', $email_adress)) {
                if(strlen($_POST['parola']) >= 6) {
                    if($email_adress === $verify_email_address && $password === $verify_password) {
                        if($row === NULL) {
                            $sql = "INSERT INTO Users (firstname, lastname, email, password, address, conn_date) VALUES ('".$first_name."', '".$last_name."', '".$email_adress."', '".$password."', '".$address."', sysdate());";
                           // echo $sql;
                            if(!$conn->query($sql)){
                                echo "Eroare" . $conn->error;
                            }
                            else {
                                $_SESSION["name"] = $first_name . " " . $last_name;
                                $_SESSION["email"] = $email_adress;
                                $_SESSION["password"] = $password;
                               
                            }
                        }
                        else 
                            $error = "Acest user exista!";
                    }
                    else 
                        $error = "Parola sau Email-ul nu corespund!";
                }
                else $error = "Parola trebuie să conțină minim 6 caractere!";
            }
            else $error = "Completați corect adresa de e-mail";
    }   
}

if(isset($_SESSION['loggedIn'])){
    $loggedIn = $_SESSION['loggedIn'];
    
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Acasă &bull; Crisis Containment Service</title>
	<link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/media.css">
</head>
<body id="login-page">
	<?php include "header.php" ?>
	
	<section id="content">
        <div class="gradient-bg">
            <div class="container no-padding">
                <div class="box-medium align-left orange" id="enlarge">
                    <div class="row">
                        <div class="col12">
                            <h3 class="subtitle">
                                Inregistrarea contului dvs
                            </h3>
                            <form class="contact-form" action="#" method="POST">
                                <div class="row">
                                    <div class="col6 no-padding">
                                        <div class="par">
                                            Nume familie
                                        </div>
                                        <input type="text" name="nume" value="Nume" onfocus="if(this.value=='Nume') this.value='';" onblur="if(this.value=='') this.value='Nume';">
                                    </div>
                                    <div class="col6 no-padding">
                                            <div class="par">
                                                Prenume 
                                            </div>
                                            <input type="text" name="prenume" value="Prenume" onfocus="if(this.value=='Prenume') this.value='';" onblur="if(this.value=='') this.value='Prenume';">
                                    </div>

                                    <div class="col6 no-padding">
                                        <div class="par">
                                            Adresa de e-mail
                                        </div>
                                        <input type="text" name="email" value="your.email@yoursite.com" onfocus="if(this.value=='your.email@yoursite.com') this.value='';" onblur="if(this.value=='') this.value='your.email@yoursite.com';">
                                    </div>

                                    <div class="col6 no-padding">
                                        <div class="par">
                                            Verificare adresa de e-mail
                                        </div>
                                        <input type="text" name="verifica_email" value="your.email@yoursite.com" onfocus="if(this.value=='your.email@yoursite.com') this.value='';" onblur="if(this.value=='') this.value='your.email@yoursite.com';">
                                    </div>


                                    <div class="col6 no-padding">
                                        <div class="par">
                                            Parola
                                        </div>
                                        <input type="password" class="pwd" name="parola" value="Parola" onfocus="if(this.value=='Parola') this.value='';" onblur="if(this.value=='') this.value='Parola';">
                                    </div>
                                    <div class="col6 no-padding">
                                        <div class="par">
                                            Verificare parola
                                        </div>
                                        <input type="password" class="pwd" name="verifica_parola" value="Parola" onfocus="if(this.value=='Verificare parola') this.value='';" onblur="if(this.value=='') this.value='Verificare parola';">
                                    </div>
                                    <div class="par">
                                        Adresa
                                    </div>

                                    <input type="text" name="Adresa" value="Adresa" onfocus="if(this.value=='Adresa') this.value='';" onblur="if(this.value=='') this.value='Adresa';" id = "address-input">
                                    <input type="text" id ="formatted-addr" name ="formatted-address" value="" style="display:none;">
                                    <button type="submit" id="submit-button" name="submit">
                                        Trimitere
                                    </button>
                                    <div class="clear"></div>
                                    <?php
                                        if($error != "") {
                                            echo "<div class = 'error'>". $error . "</div>";
                                        }
                                    ?>
                                </div>
                            </form>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
	</section>

	<?php include "footer.php" ?>
    <script src="js/miscs.js"></script>
    <script src="js/fill-page.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8Pcx6UnNfKrOjhDrcOgG3joJPpUSDEuA&libraries=places"></script>

    <script src="js/register-address.js"></script>
</body>
</html>