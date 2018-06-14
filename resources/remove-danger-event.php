<?php
include_once('database-connect.php');
$id_user = -1;
if(isset($_SESSION['id_user']) && $_SESSION['loggedIn'] )
    $id_user = $_SESSION['id_user'];
else{
    echo json_encode(array("error"=>"Nu sunteti autentificat!"));
    die();
}
    

$stmt = $conn->prepare("Select id_event FROM events where id_user =? and type = 'person'");
$stmt -> bind_param("i",$id_user);
$stmt -> execute();
$stmt -> bind_result($id_event);
$stmt -> fetch();
$stmt -> close();



$stmt = $conn->prepare("DELETE FROM events where id_user = ? and type = 'person'");
$stmt ->bind_param("i",$id_user);
$stmt->execute();
$stmt -> close();

$stmt = $conn->prepare("DELETE FROM comments where event_id= ?");
$stmt ->bind_param("i",$id_event);
$stmt->execute();
$stmt -> close();

$stmt = $conn->prepare("DELETE FROM feedback where id_danger= ?");
$stmt ->bind_param("i",$id_event);
$stmt->execute();
$stmt -> close();
echo json_encode(array("success"=>"Sters cu succes."));
?>