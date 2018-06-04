<?php
include_once('../dbConnect.php');

#################


for($i=0;$i<75;$i++){
   $name = 'John'.$i;
    $email = 'john.doe'.$i.'@myemail.com';
    $f = 'Doe';
    $stmt = $conn->prepare("INSERT INTO Users (firstname, lastname, email, password, address, conn_date) VALUES (?,?,?,'8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92','Iasi, Romania',sysdate())");
	$stmt ->bind_param("sss",$name,$f,$email);
    $stmt->execute();
    
    $aftercoma1 = rand(0,10000000);
    $sec = rand(3,7);
    $aftercoma2 = rand(3000000,8000000);
    $frst = rand(0,9);

    $prima = '4'.$sec.'.'.$aftercoma1;
    $adoua = '2'.$frst.'.'.$aftercoma2;

    $location = $prima.' '.$adoua;
    $id_user = rand(0,100);
    $event_range = rand(10,5000);

    $type_num = rand(1,4);
    if($type_num ==1) 
        $type  = 'fire';
    if($type_num ==2)
        $type = 'flood';
    if($type_num ==3 )
        $type = 'earthquake';
    if($type_num ==4)
        $type = 'snowstorm';
    
    $desciption = "bla bla la fiecare";

    $year = rand (10,18);
    $year = '20'.$year;

    $month = rand(1,12);
    $day = rand (1,29);

    
    $full_date = $year.'/'.$month.'/'.$day; 
    $full_date = date('Y/m/d H:i:s', strtotime($full_date));
    $stmt = $conn->prepare("INSERT INTO events (id_user, location, event_range, type, description, event_date) values(?, ?, ?, ?, ?,?)");
	$stmt ->bind_param("isisss", $id_user, $location, $event_range, $type, $desciption,$full_date);
    $stmt->execute();
    

    $stmt = $conn->prepare("Select id_event from events where id_user = ? and location = ? and type = ? and event_date = ?");
	$stmt ->bind_param("isss", $id_user, $location, $type,$full_date);
    $stmt->execute();
    $stmt -> bind_result($id_event);
    $stmt -> fetch();
    $stmt -> close();

    $num_of_comments = rand(1,7);

    for($j=0;$j<$num_of_comments;$j++){
        $id_user = rand(0,100);
        $content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $stmt = $conn->prepare("insert into comments (user_id, event_id, content, post_date) values(?, ?, ?, sysdate())");
        $stmt->bind_param('iis', $id_user, $id_event, $content);
        $stmt->execute();
    }
}

for($i=0;$i<15;$i++){
    
    $aftercoma1 = rand(0,10000000);
    $sec = rand(3,7);
    $aftercoma2 = rand(3000000,8000000);
    $frst = rand(0,9);

    $prima = '4'.$sec.'.'.$aftercoma1;
    $adoua = '2'.$frst.'.'.$aftercoma2;

    $location = $prima.' '.$adoua;
    $id_user = rand(0,100);
    $event_range = rand(10,5000);

    $type_num = rand(1,4);
    if($type_num ==1) 
        $type  = 'fire';
    if($type_num ==2)
        $type = 'flood';
    if($type_num ==3 )
        $type = 'earthquake';
    if($type_num ==4)
        $type = 'snowstorm';
    
    $desciption = "bla bla la fiecare in data de astazi";

    $year = rand (13,18);
    $year = '20'.$year;

    $month = rand(1,12);
    $day = rand (1,29);

    $full_date = $year.'/'.$month.'/'.$day;

    $stmt = $conn->prepare("INSERT INTO events (id_user, location, event_range, type, description, event_date) values(?, ?, ?, ?, ?,sysdate())");
	$stmt ->bind_param("isiss", $id_user, $location, $event_range, $type, $desciption);
    $stmt->execute();


    $stmt = $conn->prepare("Select id_event from events where id_user = ? and location = ? and type = ? and event_date = sysdate()");
	$stmt ->bind_param("iss", $id_user, $location, $type);
    $stmt->execute();
    $stmt -> bind_result($id_event);
    $stmt -> fetch();
    $stmt -> close();

    $num_of_comments = rand(1,7);

    for($j=0;$j<$num_of_comments;$j++){
        $id_user = rand(0,100);
        $content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $stmt = $conn->prepare("insert into comments (user_id, event_id, content, post_date) values(?, ?, ?, sysdate())");
        $stmt->bind_param('iis', $id_user, $id_event, $content);
        $stmt->execute();
    }


   
}

echo 'done generating events, users and comments';
?>