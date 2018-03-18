<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Hartă &bull; Crisis Containment Service</title>
	<link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/history.css">
    <link rel="stylesheet" href="css/media.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body id="history-page">
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
        <div class="tab tab-visible" id="tab-layers">
            <div class="tab-content align-left">
           		<p> Interval de căutare</p>
                <span  id="amount" > </span>
				<div id="slider-range"></div>
            </div>
        </div>
        <div class="tab " id="tab-legend">
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
                    <li class="tab-selected" data-tab="tab-layers">Timeline</li>
                    <li  data-tab="tab-legend">Legendă</li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </footer>

    <script type="text/javascript" src="js/history-map-page.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8Pcx6UnNfKrOjhDrcOgG3joJPpUSDEuA&callback=createMap"></script>
	<script type="text/javascript" src="js/miscs.js"></script>
	<script type="text/javascript" src="js/slider_custom.js"></script>
    

</body>