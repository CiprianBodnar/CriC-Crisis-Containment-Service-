<?php
include_once('../dbConnect.php');
$row = 1;
$ID_USER = -1;
$RANGE = 5000;
$TYPE = 'safehouse';
if (($handle = fopen("shelters.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        
        $desciption = $data[0];
        $location = $data[1].' '.$data[2];
        
        $stmt = $conn->prepare("INSERT INTO events (id_user, location, event_range, type, description, event_date) values(?, ?, ?, ?, ?,sysdate())");
        $stmt ->bind_param("isiss",$ID_USER, $location, $RANGE, $TYPE, $desciption);
        $stmt->execute();
        $stmt->close();
        
    }
    fclose($handle);
}

echo 'Shelters added';
?>
