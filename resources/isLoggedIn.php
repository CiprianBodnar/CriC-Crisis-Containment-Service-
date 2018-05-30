<?php
    include_once("../dbConnect.php");
    if(isset($_SESSION['loggedIn']))
        echo json_encode($_SESSION['loggedIn']);

?>