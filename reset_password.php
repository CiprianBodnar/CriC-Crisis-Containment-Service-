<?php
include_once ("dbConnect.php");

$key = "";
if(isset($_GET['key'])){
    $key = $_GET['key'];
    echo $key;
}

$sql = "SELECT * FROM Reset_Pwd WHERE ekey='".$key."'";
if($conn->query($sql) == FALSE){
    echo "Error: " . $conn->error;
}
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$email = $row['email'];

if(isset($_POST['submit'])){
    $password = hash("sha256", $_POST['parola_noua']);
    $verify_password = hash("sha256", $_POST['verificare_parola_noua']);

    if(strlen($_POST['parola_noua']) >= 6){
        if($password == $verify_password){
            $sql = "UPDATE Users SET password='".$password."' WHERE email='".$email."'";
            if(!$conn->query($sql)){
                echo "Eroare: ". $conn->error;
            }

            $sql = "DELETE FROM Reset_Pwd where email='".$email."'";
            if(!$conn->query($sql)){
                echo "Eroare: ". $conn->error;
            }

            header("Location: login.php");
        }
    }
    $conn->close();    
}
 
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
                <div class="box-small align-left orange" id="enlarge">
                    <div class="col12">
                        <h3 class="subtitle">
                            Schimbarea parolei dvs
                        </h3>
                        <form class="contact-form" action="#" method="POST">
                            <div class="row">
                                <div class="par">
                                    Parola noua
                                </div>
                                <input type="password" class="pwd" name="parola_noua" value="Parola noua" onfocus="if(this.value=='Parola noua') this.value='';" onblur="if(this.value=='') this.value='Parola noua';">
                            </div>
                            <div class="row">
                                <div class="par">
                                    Verificare parola noua
                                </div>
                                <input type="password" class="pwd" name="verificare_parola_noua" value="Parola noua" onfocus="if(this.value=='Parola noua') this.value='';" onblur="if(this.value=='') this.value='Parola noua';">
                            </div>

                            <button type="submit" name="submit" id="submit-button">
                                Trimitere
                            </button>
                                   
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</section>

	<?php include "footer.php" ?>
	<script src="js/miscs.js"></script>
    <script src="js/fill-page.js"></script>
</body>
</html>