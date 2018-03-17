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
                        <form class="contact-form">
                            <div class="row">
                                <div class="par">
                                    Parola noua
                                </div>
                                <input type="password" class="pwd" name="Parola noua" value="Parola noua" onfocus="if(this.value=='Parola noua') this.value='';" onblur="if(this.value=='') this.value='Parola noua';">
                            </div>
                            <div class="row">
                                <div class="par">
                                    Verificare parola noua
                                </div>
                                <input type="password" class="pwd" name="Verificare parola noua" value="Parola noua"onfocus="if(this.value=='Verificare parola noua') this.value='';" onblur="if(this.value=='') this.value='Verificare parola noua';">
                                </div>

                                <button type="submit" id="submit-button">
                                    Trimitere
                                </button>
                                   
                        </form>
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