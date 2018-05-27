<?php
include_once ("dbConnect.php");

    $last_name_error = "";
    $first_name_error = "";
    $email_address_error = "";
    $verify_email_address_error = "";
    $password_error = "";
    $verify_password_error = "";
    $verify_password_error_same_email = "";
    $address_error = "";
    $different_email_address = "";
    $email_address = "";
    $verify_email_address = "";

$error = "";
$error_same_user = "";
if(isset($_POST['submit'])) {

    $first_name = $_POST['prenume'];
    $first_name = htmlspecialchars($first_name, ENT_QUOTES);
 
    $last_name = $_POST['nume'];
    $last_name = htmlspecialchars($last_name, ENT_QUOTES);

    $email_address = $_POST['email'];
    $email_address = htmlspecialchars($email_address, ENT_QUOTES);

    $verify_email_address = $_POST['verifica_email'];
    $verify_email_address = htmlspecialchars($verify_email_address, ENT_QUOTES);

    $password = hash("sha256", $_POST['parola']);
    $verify_password = hash("sha256", $_POST['verifica_parola']);

    $address = $_POST['formatted-address'];
    $address = str_replace(array("ș","ă","ț","Ș","Ț","Ă","Â","â"),array("s","a","t","s","t","a","a","a"),$address);
    $address = htmlspecialchars($address, ENT_QUOTES);

    $sql = $conn->prepare("SELECT * FROM Users WHERE email = ?");
    $sql -> bind_param('s', $email_address);
    $sql -> execute();
    
    if($result = $sql -> get_result()) { 
        $row = $result -> fetch_assoc();
        
    if($last_name === 'Nume') {
        $last_name_error = 'Camp gol!';
    }

    if($first_name === 'Prenume') {
        $first_name_error = 'Camp gol!';
    }

    if($email_address === 'your.email@yoursite.com') {
        $different_email_address = 'Camp gol!';
    }

    if(!(preg_match('/^([a-zA-Z0-9]+[a-zA-Z0-9._%-]*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4})$/', $email_address))) {
        $email_address_error = 'Email incorect!';
    }

    if(!(strlen($_POST['parola']) >= 6)) {
        $password_error = 'Parola prea scurta!';
    }

    if($email_address != $verify_email_address || $verify_email_address === 'your.email@yoursite.com') {
        $verify_email_address_error = 'Adresele nu corespund!';
    }

    if($password != $verify_password) {
        $verify_password_error = 'Parola incorecta!';
    }

    if($address == '') {
        $address_error = 'Introduceti adresa!';
    }

   
    /*print_r( $last_name_error);
    print_r( $first_name_error);
    print_r( $email_address_error);
    print_r( $password_error);
    print_r( $verify_password_error);
    print_r( $verify_email_address_error);
    print_r( $address_error);*/


    if($last_name_error === "" && $first_name_error === "" &&  $different_email_address === "" && $email_address_error === "" &&  $verify_email_address_error === "" && $password_error === "" && $verify_password_error === "" && $address_error === "") {

            if($row === NULL) {

                $sql = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, address, conn_date) VALUES (?, ?, ?, ?, ?, sysdate())");
                
                $sql -> bind_param("sssss", $first_name, $last_name, $email_address, $password, $address);
                $sql -> execute();
                $sql -> close();

                $_SESSION["name"] = $first_name . " " . $last_name;
                $_SESSION["email"] = $email_address;
                header("Location: login.php");
            }
            else {
                $error_same_user = "Există deja un utilizator cu această adresa de e-mail!";
            }
    }
    else {
        $error = "Datele introduse în câmpurile marcate nu sunt valide!";
    }
  }
 
    $_SESSION["pre-lastname"] = $last_name;
    $_SESSION["pre-firstname"] = $first_name;
    $_SESSION["pre-email"] = $email_address;
    $_SESSION["pre-verify-email"] = $verify_email_address;
    $_SESSION["pre-address"] = $address;
}

if(isset($_SESSION['loggedIn'])){
    $loggedIn = $_SESSION['loggedIn'];
    if($loggedIn)
        header("Location: home.php");
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
                                        <input type="text" name="nume" value="<?php if($error) echo $_SESSION['pre-lastname']; else 
                                        echo 'Nume'; ?>" <?php if($last_name_error) echo "class = 'error'"; ?> onfocus="if(this.value=='Nume') this.value='';" onblur="if(this.value=='') this.value='Nume';">
                                        
                                    </div>
                                    <div class="col6 no-padding">
                                            <div class="par">
                                                Prenume 
                                            </div>
                                            <input type="text" name="prenume" value="<?php if($error) echo $_SESSION['pre-firstname']; else 
                                        echo 'Prenume'; ?>"" <?php if($first_name_error) echo "class = 'error'"; ?> onfocus="if(this.value=='Prenume') this.value='';" onblur="if(this.value=='') this.value='Prenume';">
                                    </div>

                                    <div class="col6 no-padding">
                                        <div class="par">
                                            Adresa de e-mail
                                        </div>
                                        <input type="text" name="email" value="<?php if($error) echo $_SESSION['pre-email']; else
                                        echo 'your.email@yoursite.com'; ?>" <?php if($password_error != '' || $different_email_address != '') echo "class = 'error'"; ?> onfocus="if(this.value=='your.email@yoursite.com') this.value='';" onblur="if(this.value=='') this.value='your.email@yoursite.com';">
                                    </div>

                                    <div class="col6 no-padding">
                                        <div class="par">
                                            Verificare adresa de e-mail
                                        </div>
                                        <input type="text" name="verifica_email" value="<?php if($error != '' || $email_address != '') echo $_SESSION['pre-verify-email']; else 
                                        echo 'your.email@yoursite.com'; ?>" <?php if($verify_email_address_error) echo "class = 'error'"; ?> onfocus="if(this.value=='your.email@yoursite.com') this.value='';" onblur="if(this.value=='') this.value='your.email@yoursite.com';">
                                    </div>


                                    <div class="col6 no-padding">
                                        <div class="par">
                                            Parola
                                        </div>
                                        <input type="password"  name="parola" class="pwd <?php if($password_error || $verify_password_error) echo  "password-error"; ?>">

                                    </div>
                                    <div class="col6 no-padding">
                                        <div class="par">
                                            Verificare parola
                                        </div>
                                        <input type="password" name="verifica_parola" class = "pwd <?php if($verify_password_error || 
                                            $error) echo "password-error"; ?>" >
                                    </div>
                                    <div class="par">
                                        Adresa
                                    </div>

                                    <input type="text" name="Adresa" value="<?php if($error) echo $_SESSION['pre-address']; else 
                                        echo 'Adresa'; ?>" <?php if($address_error) echo "class = 'error'"; ?> onfocus="if(this.value=='Adresa') this.value='';" onblur="if(this.value=='') this.value='Adresa';" id = "address-input">
                                    <input type="text" id ="formatted-addr" name ="formatted-address" value="" style="display:none;">
                                    <button type="submit" id="submit-button" name="submit">
                                        Trimitere
                                    </button>
                                    <div class="clear"></div>
                                    <?php
                                        if($error != "") {
                                            echo "<div class = 'error'>". $error . "</div>";
                                        }
                                        if($error_same_user != "") {
                                            echo "<div class = 'error'>". $error_same_user . "</div>";
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