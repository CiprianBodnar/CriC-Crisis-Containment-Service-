<?php
include_once('dbConnect.php');

$error ="";

if(isset($_POST['conectare'])){

    $email = $_POST['email'];
    $email = htmlspecialchars($email,ENT_QUOTES);    
    $pass = hash("sha256",$_POST['parola']);
    #$sql = "SELECT * FROM Users WHERE email='".$email."' AND password='".$pass."';";
   
    $id_user = '';
    $firstname='';
    $lastname='';
    $stmt = $conn->prepare("Select id_user,firstname,lastname FROM Users where email =? and password = ?");
    $stmt -> bind_param("ss",$email,$pass);
    $stmt -> execute();
    $stmt -> bind_result($id_user,$firstname,$lastname);
    $stmt -> fetch();
    $stmt -> close();


    if($id_user !='' and $lastname!='' and $firstname!=''){
        $_SESSION ["name"] = $firstname . " " . $lastname;
        $_SESSION["loggedIn"] = TRUE;
        $_SESSION["id_user"] = $id_user;
       #$sql = "UPDATE Users set conn_date=sysdate where email='".$email."';";
        $stmt = $conn -> prepare("UPDATE Users set conn_date=sysdate() where email = ?");
        $stmt -> bind_param("s",$email);
        $stmt -> execute();
        $stmt -> close();
    }
    else
        $error = "Email sau parolă greșită!";

    $_SESSION["email"] = $email;

    if(isset($_SESSION['loggedIn'])){
        $loggedIn = $_SESSION['loggedIn'];
        if($loggedIn ===TRUE)
            header("Location: home.php");
        }
}
    $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Conectare &bull; Crisis Containment Service</title>
	<link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/media.css">
</head>
<body id="login-page">
	
    <?php include "header.php" ?>
	
    <section id="content">
        <div class="gradient-bg">
            <div class="container no-padding">
                <div class="box-small align-left orange" id="enlarge">
                    <div class="row1">
                        <h3 class="subtitle">
                            Conectează-te
                        </h3>
                        <p class="information">
                            Cu adresa ta de email si parola.
                        </p>
                    </div>
                    <div class="row2">
                        <form class="login-form" action="#" method="POST">
                            <div class="row21">
                                <input type="text" name="email" value="<?php  if(isset($_SESSION['email'])) echo $_SESSION['email']; else echo "your.email@yoursite.com"; ?>" 
                                onfocus="if(this.value=='your.email@yoursite.com') this.value='';" onblur="if(this.value=='') this.value='your.email@yoursite.com';">
                            </div>
                            <div class="row21">
                                <input type="password" name="parola">
                                <button type="submit" id="conecteaza" name="conectare">Conectează-te</button>
                                <div class="clear"></div>
                            </div>
                            <?php
                                if($error != "") {
                                    echo "<div class = 'error'>". $error . "</div>";
                                 }
                          ?>
                        </form>
                    </div>

                    
                    <div class="row3">

                        <p class="information">
                            Nu ai încă un cont de utilizator? <a href="register.php">Înregistreaza-te!</a>
                        </p>
                        <p class="information">
                            Ai uitat parola? <a href="send_code.php">Resetează.</a>
                        </p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


	<?php include "footer.php" ?>
    
    <script  src="js/miscs.js"></script>
    <script  src="js/fill-page.js"></script>
</body>
</html>