<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Hartă &bull; Crisis Containment Service</title>
	<link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/map.css">
    <link rel="stylesheet" href="css/media.css">
</head>
<body id="map-page">
	
    <?php include "header.php" ?>
	
	<section class="content">
        <div class="wrapper">
            <div class="input-trigger visible">
                <i class="fa fa-search"></i>
            </div>
             <div class="container">
                 <input id="address-keyword" type="text" name="location-keyword" value="Căutați după o adresă..." onfocus="if (this.value=='Căutați după o adresă...') this.value='';" onblur="if(this.value=='') this.value='Căutați după o adresă...';">
            </div>
        </div>

         <div id="map-container">
        </div>
    </section>
    <div class="tabs box-small no-padding">
        <div class="tab" id="tab-about">
            <div class="tab-content align-left">
                <p class="tab-title">Descriere</p>
                <p class="tab-info">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati a, harum placeat sit nam! Tempore neque nobis, quam fugit inventore quod doloribus debitis adipisci laborum quis reiciendis, ipsam ea assumenda.
                </p>
            </div>
        </div>
        <div class="tab" id="tab-layers">
            <div class="tab-content align-left">
                <p class="tab-title">Layers</p>
                <p class="tab-info">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati a, harum placeat sit nam! Tempore neque nobis, quam fugit inventore quod doloribus debitis adipisci laborum quis reiciendis, ipsam ea assumenda.
                </p>
                <p class="tab-info">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati a, harum placeat sit nam! Tempore neque nobis, quam fugit inventore quod doloribus debitis adipisci laborum quis reiciendis, ipsam ea assumenda.
                </p>
            </div>
        </div>
        <div class="tab tab-visible" id="tab-legend">
            <div class="tab-content align-left">
                <p class="tab-title">Legend</p>
                <p class="tab-info">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi, debitis labore officiis necessitatibus? Blanditiis porro mollitia quisquam repudiandae vel soluta deserunt iure tempore sapiente quae, velit hic quas consectetur, ipsa, a assumenda praesentium reiciendis natus minus eligendi dicta! Tempora, soluta, aspernatur? In obcaecati officia, fugit perferendis magnam, provident doloribus iure!
                </p>
            </div>
        </div>
    </div>
    <footer>
        <div class="container no-padding">
            <div class="bottom-nav-menu">
                <ul>
                    <li data-tab="tab-about">Despre</li>
                    <li data-tab="tab-layers">Straturi</li>
                    <li class="tab-selected" data-tab="tab-legend">Legendă</li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </footer>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/map-page.js">
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key= AIzaSyC8Pcx6UnNfKrOjhDrcOgG3joJPpUSDEuA&callback=createMap"></script>
	<script type="text/javascript" src="js/miscs.js"></script>
</body>
</html>