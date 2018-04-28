<?php

include_once('dbConnect.php');
$_SESSION['loggedIn'] = false;
header("Location: home.php");

?>

