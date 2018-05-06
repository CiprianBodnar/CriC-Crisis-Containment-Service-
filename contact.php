<?php
    $error = "";
    if(isset($_POST['submit'])){
        $last_name = $_POST['nume'];
        $first_name = $_POST['prenume'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $mesaj = $_POST['mesaj'];

        if(preg_match('/^([a-zA-Z0-9]+[a-zA-Z0-9._%-]*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4})$/', $email)){
            if(strlen($subject)>=5){
                if(strlen($mesaj)){
                    $to = "fiicriciasi@gmail.com";
                    $header = "From: fiicriciasi@gmail.com";

                    $message = "Nume: ".$last_name;
                    $message .= "\nPrenume: ".$first_name;
                    $message .= "\nE-Mail: ".$email;
                    $message .= "\n".$mesaj;

                    mail($to, $subject, $message, $header);
                }
                else 
                    $error = "Nu puteti trimite mesaj gol";
            }
            else 
                $error = "Subiectul nu poate avea mai putin de 5 caractere";
        }
        else
            $error = "Introduceti un email valid";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Contact &bull; Crisis Containment Service</title>
	<link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/media.css">
</head>
<body id="contact-page">
    <?php include "header.php" ?>
	<section id="content">                     
		<div class="gradient-bg"> 
            <div class="container orange" id="enlarge"> 
                <div class="row"> 
                    <div class="col4">    
                        <h3 class="subtitle">
                            Detalii de contact
                        </h3>
                        <span class="icon-container">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                            
                        <p class="information">
                            Facultatea de informatica, UAIC <br>
                            General Barthelot, 16, IASI, ROMANIA
                        </p>

                        <span class="icon-container">
                            <i class="fas fa-phone"></i>
                        </span>

                        <p class="information">
                                
                           0230 576 928 <br>
                           0712 345 678
                        </p>
                        <span class="icon-container">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <p class="information">
                            fiicriciasi@gmail.com
                        </p>
                    </div>
                    <div class="col8">
                        <h3 class="subtitle">
                            Trimite un mesaj
                        </h3>
                        <form class="contact-form" action="#" method="POST">  
                            <div class="row">
                                <div class="col6 no-padding">
                                    <input type="text" name="nume" value="Nume" onfocus="if(this.value=='Nume') this.value='';" onblur="if(this.value=='') this.value='Nume';">
                                </div>
                                <div class="col6 no-padding">
                                    <input type="text" name="prenume" value="Prenume" onfocus="if(this.value=='Prenume') this.value='';" onblur="if(this.value=='') this.value='Prenume';">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col6 no-padding">
                                    <input type="text" name="email" value="your.email@yoursite.com" onfocus="if(this.value=='your.email@yoursite.com') this.value='';" onblur="if(this.value=='') this.value='your.email@yoursite.com';">
                                </div>
                                <div class="col6 no-padding">
                                    <input type="text" name="subject" value="Subiect" onfocus="if(this.value=='Subiect') this.value='';" onblur="if(this.value=='') this.value='Subiect';">
                                </div>
                            </div>
                            <div class="row">
                                <textarea name="mesaj"    onfocus="if(this.value=='Mesaj') this.value='';" onblur="if(this.value=='') this.value='Mesaj';" >Mesaj</textarea>
                                <button type="submit" id="submit-button" name = "submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                                <div class="clear"></div>
                                <?php
                                      if($error != ""){
                                        echo "<div class = 'error'>" .$error ."</div>";
                                      }
                                ?>
                            </div>
                        </form>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="row"> 
                    <div id="map"> </div>
                    <script  src="js/contact-gmap-init.js">     
                    </script>
                    <script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8Pcx6UnNfKrOjhDrcOgG3joJPpUSDEuA&callback=createMap"></script>
                </div>
            </div>
		</div>
	</section>

	<?php include "footer.php" ?>
    
	<script  src="js/miscs.js"></script>
    <script  src="js/fill-page.js"></script>
</body>
</html>