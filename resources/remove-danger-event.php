<?php
include_once('../dbConnect.php');
$id_user = -1;
if(isset($_SESSION['id_user']) and isset($_SESSION['loggedIn']))
    $id_user = $_SESSION['id_user'];

$stmt = $conn->prepare("Select id_event FROM Events where id_user =? and type = 'person'");
$stmt -> bind_param("i",$id_user);
$stmt -> execute();
$stmt -> bind_result($id_event);
$stmt -> fetch();
$stmt -> close();


$stmt = $conn->prepare("DELETE FROM Events where id_user = ? and type = 'person'");
$stmt ->bind_param("i",$id_user);
$stmt->execute();
$stmt -> close();

$stmt = $conn->prepare("DELETE FROM Comments where event_id= ?");
$stmt ->bind_param("i",$id_event);
$stmt->execute();
$stmt -> close();

$stmt = $conn->prepare("DELETE FROM Feedback where id_danger= ?");
$stmt ->bind_param("i",$id_event);
$stmt->execute();
$stmt -> close();
?>