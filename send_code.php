<?php
include_once ("dbConnect.php");
function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$error = "";
if(isset($_POST['submit']))
{
    $key = generateRandomString();
    ini_set("SMTP","ssl://smtp.gmail.com");
    ini_set("smtp_port","465");

    if(preg_match('/^([a-zA-Z0-9]+[a-zA-Z0-9._%-]*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4})$/', $_POST['email'])){
        $to = $_POST['email'];
        $subject = "Trimitere cod de resetare parola cont CriC";
        $message = "Buna, \n \nVa puteti reseta parola la urmatoarea adresa http://localhost/cric/reset_password.php?key=";
        $message .= $key;
        $message .= "\n Va multumim ca aveti incredere in noi,\nEchipa CriC";
        $header = "From: fiicriciasi@gmail.com";

        mail($to, $subject, $message, $header);

        $to = htmlspecialchars($to, ENT_QUOTES);
        $key = htmlspecialchars($key, ENT_QUOTES);

        $sql = "INSERT INTO reset_pwd (email, ekey) VALUES ('".$to."','".$key."');";
        if(!$conn->query($sql) == TRUE){
            echo "Error: " . $conn->error;
        }
    }
    else
        $error = "Introduceți o adresă de email validă!";

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
                    <div class="row">
                        <div class="col12">
                            <h3 class="subtitle">
                                Trimiterea codului de recupare a contului pe email
                            </h3>
                            <form class="contact-form" action="#" method="POST">

                                <div class="col12 no-padding">
                                    <div class="par">
                                        Adresa de e-mail
                                    </div>
                                    <input type="text" name="email">
                                
                                <button type="submit" id="submit-button" name="submit">
                                    Trimitere
                                </button>
                                </div>
                                <div class="clear"></div>
                                <?php
                                    if($error != ""){
                                        echo "<div class = 'error'>".$error."</div>";
                                    } 
                                ?>
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
</body>
</html>