<?php

include_once('resources/database-connect.php');
$_SESSION['loggedIn'] = false;
header("Location: home.php");

?>

