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
                    <div class="row2" id = "inputs-row">
                        <form class="login-form" action="#" method="POST">
                            <div class="col12 no-padding">
                                <input type="text" name="email" id="login-email"  value="<?php  if(isset($_SESSION['email'])) echo $_SESSION['email']; else echo "your.email@yoursite.com"; ?>"  >
                            </div>
                            <div class="col12 no-padding">
                                <input type="password" name="parola" id="login-password">
                                <div  id="conecteaza" name="conectare">Conectează-te</div>
                                <div class="clear"></div>
                            </div>
                        </form>
                    </div>
                    <div class="row3">
                        <p class="information">
                            Nu ai încă un cont de utilizator? <a href="register.php">Înregistreaza-te!</a>
                        </p>
                        <p class="information">
                            Ai uitat parola? <a href="send-code.php">Resetează.</a>
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
    <script src="js/form-errors.js"></script>
    <script src="js/login-fields.js"></script>
    <script>
        checkLogin("","");
    </script>
</body>
</html>