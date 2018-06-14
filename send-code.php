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
                                <div class="col12 no-padding" id="email-row">
                                    <div class="par">
                                        Adresa de e-mail
                                    </div>
                                    <input type="text" name="email"id="email-send-code">
                                </div>
                                <div class="col12 no-padding" >
                                    <div  id="send-code-submit-button" class = "settings-button"> 
                                        Trimitere
                                    </div>
                                </div>
                                <div class="clear"></div>
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
    <script src="js/form-errors.js"></script>
    <script src="js/send-code-get-value.js"></script>
</body>
</html>