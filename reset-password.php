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
    <link rel="stylesheet" href="css/modals.css">
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
                            <div class="row" id ="password-row">
                                <div class="par">
                                    Parola noua
                                </div>
                                <input type="password" class="pwd" name="parola_noua" id="reset-password">
                            </div>
                            <div class="row" id ="verify-password-row">
                                <div class="par">
                                    Verificare parola noua
                                </div>
                                <input type="password" class="pwd" name="verificare_parola_noua" id="reset-verify-password">
                            </div>

                            <div class="settings-button" name="submit" id="reset-submit-button">
                                Trimitere
                            </div>
                            <div class = "clear"></div>  
                        </form>
                    </div>
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
    <script src="js/reset-password-fields.js"></script>
	<script src="js/miscs.js"></script>
    <script src="js/fill-page.js"></script>
</body>
</html>