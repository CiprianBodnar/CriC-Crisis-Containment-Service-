<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Acasă &bull; Crisis Containment Service</title>
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
                        <form class="login-form">
                            <div class="row21">
                                <input type="text" name="your.email@yoursite.com" value="your.email@yoursite.com" onfocus="if(this.value=='your.email@yoursite.com') this.value='';" onblur="if(this.value=='') this.value='your.email@yoursite.com';">
                            </div>
                            <div class="row21">
                                <input type="password" name="parola" value="parola" onfocus="if(this.value=='parola') this.value='';" onblur="if(this.value=='') this.value='parola';">
                                <button type="submit" id="conecteaza">Conectează-te</button>
                                <div class="clear"></div>
                            </div>
                        </form>
                    <div class="row3">

                        <p class="information">
                            Nu ai încă un cont de utilizator? <a href="register.php">Înregistreaza-te!</a>
                        </p>
                        <p class="information">
                            Ai uitat parola? <a href="password.php">Resetează.</a>
                        </p>
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