<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Contact &bull; Crisis Containment Service</title>
	<link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/modals.css">
    <link rel="stylesheet" href="css/register.css">
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
                                <div class="col6 no-padding" id="lastname-row">
                                    <input type="text" name="nume" id="lastname-contact" value="Nume" onfocus="if(this.value=='Nume') this.value='';" onblur="if(this.value=='') this.value='Nume';">
                                </div>
                                <div class="col6 no-padding" id="firstname-row">
                                    <input type="text" name="prenume" id="firstname-contact" value="Prenume" onfocus="if(this.value=='Prenume') this.value='';" onblur="if(this.value=='') this.value='Prenume';">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col6 no-padding" id="email-row">
                                    <input type="text" name="email" id="email-contact" value="your.email@yoursite.com" onfocus="if(this.value=='your.email@yoursite.com') this.value='';" onblur="if(this.value=='') this.value='your.email@yoursite.com';">
                                </div>
                                <div class="col6 no-padding" id="subject-row">
                                    <input type="text" name="subject" id="subject-contact" value="Subiect" onfocus="if(this.value=='Subiect') this.value='';" onblur="if(this.value=='') this.value='Subiect';">
                                </div>
                            </div>
                            <div class="row" id="message-row">
                                <textarea name="mesaj" id = "message-contact" value="Mesaj" onfocus="if(this.value=='Mesaj') this.value='';" onblur="if(this.value=='') this.value='Mesaj';" ></textarea>
                                <div id="contact-submit-button" class="settings-button" name = "submit">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <div class="clear"></div>
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

    <div class="cover"></div>
    <div class="modals-container">
    <?php include "modals/notifications.php" ?>
    </div>

    <script src="js/event-manager.js"></script>
    <script src="js/form-errors.js"></script>
    <script src="js/contact-fields.js"></script>
	<script src="js/miscs.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/modals.js"></script>
    <script src="js/notifications.js"></script>
    <script src="js/fill-page.js"></script>
</body>
</html>