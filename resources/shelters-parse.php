<?php
include_once('../dbConnect.php');
$ID_USER = 50000;
$RANGE = 5000;
$TYPE = 'safehouse';
if (($handle = fopen("shelters.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $desc = $data[0];
        $location = $data[1].' '.$data[2];
        $stmt = $conn->prepare("INSERT INTO events (id_user, location, event_range, type, description, event_date) values(?, ?, ?, ?, ?,sysdate())");
        $stmt ->bind_param("isiss",$ID_USER, $location, $RANGE, $TYPE, $desc);
        $stmt->execute();
        $stmt->close();
        
    }
    fclose($handle);
}
$conn->close();
echo 'Shelters added';
?>
