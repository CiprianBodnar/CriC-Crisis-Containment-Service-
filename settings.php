<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Setări &bull; Crisis Containment Service</title>
	<link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/modals.css">
    <link rel="stylesheet" href="css/media.css">
</head>
<body id="setting-page">
	<?php include "header.php" ?>
    <section id="content">
        <div class="gradient-bg">
            <div class="container no-padding">
                <div class="box-medium align-left orange" id="enlarge">
                    <div class="row">
                        <div class="col12">
                            <h3 class="subtitle">
                                Datele contului dvs
                            </h3>
                            <form class="contact-form" action="#" method="POST">
                                <div class="row">
                                    <div class="col6 no-padding" id="firstname-row">
                                        <div class="par">
                                            Nume familie
                                        </div>
                                        <div class="input-wrapper">
                                          <input type="text" name="nume" id="firstname-setting">
                                        </div>
                                    </div>
                                    <div class="col6 no-padding" id="lastname-row">
                                        <div class="par">
                                            Prenume
                                        </div>
                                        <div class="input-wrapper">
                                            <input type="text" name="prenume" id="lastname-setting">
                                        </div> 
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="row">
                                    <div class="col12 no-padding" id ="email-row">
                                        <div class="par">
                                            Adresa de e-mail
                                        </div>
                                        <div class="input-wrapper">
                                            <input type="text" name="email" id="email-setting">
                                        </div>  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col12 no-padding" id="address-row">
                                        <span style = "display:none" id="span-setting"> </span>
                                        <div class="par">
                                            Adresa
                                        </div>
                                        <input type="hidden" id="user-coordinates">
                                        <div class="input-wrapper">
                                            <input type="text" id="address-setting" autocomplte="off">
                                        </div>                               
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col12 no-padding" id="password-row">
                                        <div class="par">
                                            Introduceti parola actuala pentru validare
                                        </div>
                                        <div class="input-wrapper">
                                            <input type="password" value=""  id="password-setting">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col12 no-padding">
                                        <div  id="settings-submit-button" class = "settings-button">
                                                Salveaza
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row" id="shelters-report-container">
                        <form action="#" class="contact-form">
                            <div class="col12">
                                <h3 class="subtitle">
                                    Înregistrați locații sigure
                                </h3>
                                <p class="par">Formatul acceptat pentru semnalarea adăposturilor este CSV. Fișierul selectat trebuie să aibă extensia .csv si o dimensiune mai mica de 1MB.</p>
                                <p class="par">
                                    Formatul unei înregistrări este următorul: <br>
                                    <span class="format-description">"Descrierea adăpostului",&lt;&lt;latitudine&gt;&gt;,&lt;&lt;longitudine&gt;&gt;</span>
                                </p>
                            </div>
                            <div class="col12" id="shelters-form-container">
                                <div class="col10" id="shelters-row">
                                    <input type="file" id="shelters-file" accept=".csv">   
                                    <label for="shelters-file" class="input-label">
                                        <i class="far fa-file-alt"></i>
                                        Încărcați fișierul
                                        <span id="selected-file">neselectat</span>
                                    </label>

                                </div>
                                <div class="col2">
                                    <div class='settings-button no-margin' id="shelters-submit">
                                        Trimite
                                    </div>
                                </div>
                                <div id="shelter-preloader"><i class="fas fa-spinner fa-spin"></i></div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <div class="cover"></div>
    <div class="modals-container">
        <?php include "modals/notifications.php" ?>
    </div>
    <?php include "footer.php" ?> 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8Pcx6UnNfKrOjhDrcOgG3joJPpUSDEuA&libraries=places"></script>
    <script src="js/address-autocomplete.js"></script>
    <script src="js/event-manager.js"></script>
    <script src="js/form-errors.js"></script>
    <script src="js/settings-get-value.js"></script>
    <script src="js/settings-set-value.js"></script>
    <script>
        let hiddenInput = document.getElementById("user-coordinates");
        let addressInput = document.getElementById("address-setting");

        for(let prop in containers){
            if(containers.hasOwnProperty(prop)){
                let container = document.querySelector("#"+containers[prop]+" .input-wrapper");
                let preloader = document.createElement("span");
                preloader.classList.add("input-preloader");
                preloader.innerHTML = " <i class='fas fa-spinner fa-spin'></i>";
                container.appendChild(preloader);
            }
        }
         
        prepareAddressAutocomplete(addressInput, hiddenInput);
        loadUserInfo();
    </script>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/miscs.js"></script>
    <script src="js/selected-page.js"></script>
    <script src="js/fill-page.js"></script>
    <script src="js/modals.js"></script>
    <script src="js/shelters-file.js"></script>
    <script src="js/notifications.js"></script>
    
</body>
</html>