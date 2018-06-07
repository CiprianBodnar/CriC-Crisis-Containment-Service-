<?php

#################
set_time_limit(240);

include_once('../dbConnect.php');

$NUM_OF_RECORDS = 115;
$NUM_OF_RECORDS_TODAY=15;

for($i=1;$i<$NUM_OF_RECORDS;$i++){
   $name = 'John'.$i;
    $email = 'john.doe'.$i.'@myemail.com';
    $f = 'Doe';
    $aftercoma1 = rand(0,10000000);
    $sec = rand(3,7);
    $aftercoma2 = rand(3000000,8000000);
    $frst = rand(0,9);

    $prima = '4'.$sec.'.'.$aftercoma1;
    $adoua = '2'.$frst.'.'.$aftercoma2;

    $location = $prima.' '.$adoua;
    $stmt = $conn->prepare("INSERT INTO Users (firstname, lastname, email, password, address, posted, conn_date) VALUES (?,?,?,'8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92',?, 0, sysdate())");
	$stmt ->bind_param("ssss",$name,$f,$email,$location);
    $stmt->execute();
    
    $aftercoma1 = rand(0,10000000);
    $sec = rand(3,7);
    $aftercoma2 = rand(3000000,8000000);
    $frst = rand(0,9);

    $prima = '4'.$sec.'.'.$aftercoma1;
    $adoua = '2'.$frst.'.'.$aftercoma2;

    $location = $prima.' '.$adoua;
    $id_user = rand(0,$NUM_OF_RECORDS);
    $event_range = rand(5000,50000);

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
    $stmt = $conn->prepare("INSERT INTO events (id_event,id_user, location, event_range, type, description, event_date) values(?,?, ?, ?, ?, ?,?)");
	$stmt ->bind_param("iisisss", $i,$id_user, $location, $event_range, $type, $desciption,$full_date);
    $stmt->execute();
    $update_stmt = $conn->prepare("update users set posted = ifnull(posted, 0)+1 where id_user = ?");
    $update_stmt->bind_param('i', $id_user);
    $update_stmt->execute();
    $update_stmt->close();
    


    $num_of_comments = rand(1,7);
    for($j=0;$j<$num_of_comments;$j++){
        $id_user = rand(0,$NUM_OF_RECORDS);
        $content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $stmt = $conn->prepare("insert into comments (user_id, event_id, content, post_date) values(?, ?, ?, sysdate())");
        $stmt->bind_param('iis', $id_user, $i, $content);
        $stmt->execute(); 
        
    }

    $num_of_feedbacks = rand (0,5);
    for($j=0;$j<$num_of_feedbacks;$j++){
        $feedback = rand(-1,1);
        if($feedback==0)
            $feedback = 1;
        $stmt = $conn->prepare("insert into feedback (id_user, id_danger , feedback) values(?, ?,?)");
        $stmt->bind_param('iii', $id_user, $i, $feedback);
        $stmt->execute();
    }

    
}

for($i=$NUM_OF_RECORDS;$i<$NUM_OF_RECORDS_TODAY+$NUM_OF_RECORDS;$i++){
    $aftercoma1 = rand(0,10000000);
    $sec = rand(3,7);
    $aftercoma2 = rand(3000000,8000000);
    $frst = rand(0,9);

    $prima = '4'.$sec.'.'.$aftercoma1;
    $adoua = '2'.$frst.'.'.$aftercoma2;

    $location = $prima.' '.$adoua;
    $id_user = rand(0,$NUM_OF_RECORDS+$NUM_OF_RECORDS_TODAY);
    $event_range = rand(5000,50000);

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

    $stmt = $conn->prepare("INSERT INTO events (id_event,id_user, location, event_range, type, description, event_date) values(?,?, ?, ?, ?, ?,sysdate())");
	$stmt ->bind_param("iisiss", $i,$id_user, $location, $event_range, $type, $desciption);
    $stmt->execute();
    $update_stmt = $conn->prepare("update users set posted = ifnull(posted, 0)+1 where id_user = ?");
    $update_stmt->bind_param('i', $id_user);
    $update_stmt->execute();
    $update_stmt->close();


    $num_of_comments = rand(1,7);

    for($j=0;$j<$num_of_comments;$j++){
        $id_user = rand(0,$NUM_OF_RECORDS+$NUM_OF_RECORDS_TODAY);
        $content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $stmt = $conn->prepare("insert into comments (user_id, event_id, content, post_date) values(?, ?, ?, sysdate())");
        $stmt->bind_param('iis', $id_user, $i, $content);
        $stmt->execute();
    }

    $num_of_feedbacks = rand (0,5);
    for($j=0;$j<$num_of_feedbacks;$j++){
        $id_user = rand(0,$NUM_OF_RECORDS+$NUM_OF_RECORDS_TODAY);
        $feedback = rand(-1,1);
        if($feedback==0)
            $feedback = 0;
        $stmt = $conn->prepare("insert into feedback (id_user, id_danger , feedback) values(?, ?,?)");
        $stmt->bind_param('iii', $id_user, $i, $feedback);
        $stmt->execute();
    }
   
}

echo 'done generating events, users, feedback and comments';
?>