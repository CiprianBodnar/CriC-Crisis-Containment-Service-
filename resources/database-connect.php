<?php
session_start();
$cfgfile = file_get_contents(__DIR__."/config.json");
$config = json_decode($cfgfile);
$servername = $config->servername;
$username = $config->username;
$password = $config->password;
$dbname = $config->dbname;

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn -> connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>