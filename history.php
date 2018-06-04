<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Hartă &bull; Crisis Containment Service</title>
	<link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/history.css">
    <link rel="stylesheet" href="css/modals.css">
    <link rel="stylesheet" href="css/media.css">
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
        <div class="tab tab-visible" id="tab-timeline">
            <div class="tab-content align-left">
           		<p class="tab-title"> Interval de căutare</p>
                <span  class="amount" > </span>
				<div class="slider-range">
                    <input value="30" min="0" max="60" step="1" type="range">
                    <input value="60" min="0" max="60" step="1" type="range">
                    <div class="pretty"></div>
                </div>
            </div>
            <div class="tab-content align-left">
                <p class="tab-title">Filtru</p>
                <div class="tab-content" id="filter">
                    <div class="section">
                        <div class="row">
                            <input type="checkbox" class="filter-option" id="hide-all"> Ascunde tot
                        </div>
                    </div>
                    <div class="section">
                        <div class="row">
                            <input id="earthquake" class="filter-option" type="checkbox" checked>
                            Cutremure
                        </div>
                        <div class="row">
                            <input id="fire" class="filter-option" type="checkbox" checked>
                            Incendii
                        </div>
                        <div class="row">
                            <input id="flood" class="filter-option" type="checkbox" checked>
                            Inundații
                        </div>
                        <div class="row">
                            <input id="snow-storm" class="filter-option" type="checkbox" checked>
                            Furtuni de zăpadă
                        </div>
                        <div class="row">
                            <input id="person" class="filter-option" type="checkbox" checked  >
                            Persoane aflate în pericol
                        </div>
                    </div>
                    <div class="section">
                        <div class="row">
                            <input id="radius" class="filter-option" type="checkbox" checked>
                            Raza de acoperire a pericolelor
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab" id="tab-legend">
            <div class="tab-content align-left">
                <div class="tab-title">Legendă</div>
                <div class="tab-content">
                    <p class="row">
                        <span class="icon">
                            <img src="img/danger-icons/earthquake.png" alt="cutremur">
                        </span>
                        <span class="content">Cutremur</span>
                    </p>
                    <p class="row">
                        <span class="icon">
                            <img src="img/danger-icons/fire.png" alt="incendiu">
                        </span>
                        <span class="content">Incendiu</span>
                    </p>
                    <p class="row">
                        <span class="icon"><img src="img/danger-icons/flood.png" alt=""></span>
                        <span class="content">Inundație</span>
                    </p>
                    <p class="row">
                        <span class="icon"><img src="img/danger-icons/snow-storm.png" alt=""></span>
                        <span class="content">Furtună de zăpadă</span>
                    </p>
                    <p class="row">
                        <span class="icon"><img src="img/danger-icons/person.png" alt=""></span>
                        <span class="content">Persoană aflată în pericol</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

	<footer>
        <div class="container no-padding">
            <div class="bottom-nav-menu">
                <ul>
                    <li data-tab="tab-about">Despre</li>
                    <li class="tab-selected" data-tab="tab-timeline">Timeline</li>
                    <li data-tab="tab-legend">Legendă</li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </footer>
    

    <div class="cover"></div>
    <div class="modals-container">
    <?php include "modals/view-event.php" ?>
    <?php include "modals/confirmation-popup.php" ?>
    </div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/modals.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8Pcx6UnNfKrOjhDrcOgG3joJPpUSDEuA&libraries=places"></script>
    <script src="js/event-manager.js"></script>
    <script src="js/map-page.js"></script>
	<script src="js/miscs.js"></script>
	<script src="js/slider_custom.js"></script>
    

</body>