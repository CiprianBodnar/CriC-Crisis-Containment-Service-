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
                                <form class="contact-form">
                                    <div class="row">
                                        <div class="col6 no-padding">
                                            <div class="par">
                                                Nume familie
                                            </div>
                                            <input type="text" name="Nume" value="Nume" onfocus="if(this.value=='Nume') this.value='';" onblur="if(this.value=='') this.value='Nume';">
                                        </div>
                                        <div class="col6 no-padding">
                                                <div class="par">
                                                    Prenume 
                                                </div>
                                                <input type="text" name="Prenume" value="Prenume" onfocus="if(this.value=='Prenume') this.value='';" onblur="if(this.value=='') this.value='Prenume';">
                                        </div>

                                        <div class="col6 no-padding">
                                            <div class="par">
                                                Adresa de e-mail
                                            </div>
                                            <input type="text" name="Email" value="your.email@yoursite.com" onfocus="if(this.value=='your.email@yoursite.com') this.value='';" onblur="if(this.value=='') this.value='your.email@yoursite.com';">
                                        </div>

                                        <div class="col6 no-padding">
                                            <div class="par">
                                                Verificare adresa de e-mail
                                            </div>
                                            <input type="text" name="Verificare Email" value="your.email@yoursite.com" onfocus="if(this.value=='your.email@yoursite.com') this.value='';" onblur="if(this.value=='') this.value='your.email@yoursite.com';">
                                        </div>


                                        <div class="col6 no-padding">
                                            <div class="par">
                                                Parola
                                            </div>
                                            <input type="password" class="pwd" name="Parola" value="Parola" onfocus="if(this.value=='Parola') this.value='';" onblur="if(this.value=='') this.value='Parola';">
                                        </div>
                                        <div class="col6 no-padding">
                                            <div class="par">
                                                Verificare parola
                                            </div>
                                            <input type="password" class="pwd" name="Verificare parola" value="Parola" onfocus="if(this.value=='Verificare parola') this.value='';" onblur="if(this.value=='') this.value='Verificare parola';">
                                        </div>
                                        <div class="par">
                                            Adresa
                                        </div>

                                        <input type="text" name="Adresa" value="Adresa" onfocus="if(this.value=='Adresa') this.value='';" onblur="if(this.value=='') this.value='Adresa';">

                                        <button type="submit" id="submit-button">
                                            Trimitere
                                        </button>
                                        <div class="clear"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</section>

	<?php include "footer.php" ?>
    <script type="text/javascript" src="js/miscs.js"></script>
    <script type="text/javascript" src="js/fill-page.js"></script>
</body>
</html>