<?php
set_time_limit(240);
include_once('../dbConnect.php');

$EVENT_MIN_RANGE = 5000;
$EVENT_MAX_RANGE = 50000;
$NUMBER_OF_RECORDS = 115;
$NUMBER_OF_RECORDS_TODAY = 15;
$NUMBER_MAX_OF_COMMENTS = 7;
$NUMBER_MAX_OF_FEEDBACK = 5;


function usersInsert($lastname,$firstname,$email,$location,$conn){
    $stmt = $conn->prepare("INSERT INTO Users (firstname, lastname, email, password, address, posted, conn_date) VALUES (?,?,?,'8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92',?, 0, sysdate())");
    $stmt ->bind_param("ssss",$lastname,$firstname,$email,$location);
    $stmt->execute();
    $stmt->close();
}
function eventsInsert($index,$id_user,$location,$event_range,$type,$desciption,$full_date,$conn){
    if($full_date === 'sysdate()'){
        $stmt = $conn->prepare("INSERT INTO events (id_event,id_user, location, event_range, type, description, event_date) values(?,?, ?, ?, ?, ?,sysdate())");
        $stmt ->bind_param("iisiss", $index,$id_user, $location, $event_range, $type, $desciption);
        $stmt->execute();
        $stmt->close();
    }
    else{
        $stmt = $conn->prepare("INSERT INTO events (id_event,id_user, location, event_range, type, description, event_date) values(?,?, ?, ?, ?, ?,?)");
        $stmt ->bind_param("iisisss", $index,$id_user, $location, $event_range, $type, $desciption,$full_date);
        $stmt->execute();
        $stmt->close();
    }
   
}
function usersUpdate($id_user,$conn){
    $update_stmt = $conn->prepare("update users set posted = ifnull(posted, 0)+1 where id_user = ?");
    $update_stmt->bind_param('i', $id_user);
    $update_stmt->execute();
    $update_stmt->close();
}

function commentsInsert($datagen,$index,$conn,$numberOfComments,$date){
    $num_of_comments = rand(1,$numberOfComments);
    $content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
    for($j=0;$j<$num_of_comments;$j++){
        $id_user = $datagen->getIdUser();
        if($date ===0){
            $date = $datagen->getYear();
            $stmt = $conn->prepare("insert into comments (user_id, event_id, content, post_date) values(?, ?, ?, ?)");
            $stmt->bind_param('iiss', $id_user, $index, $content,$date);
            $stmt->execute(); 
            $stmt->close();
        }
        else{
            $stmt = $conn->prepare("insert into comments (user_id, event_id, content, post_date) values(?, ?, ?,sysdate())");
            $stmt->bind_param('iis', $id_user, $index, $content);
            $stmt->execute(); 
            $stmt->close();
        }
        
    }
}

function feedbackInsert($datagen,$index,$conn,$numberOfFedbacks){
    $num_of_feedbacks = rand (0,$numberOfFedbacks);
    for($j=0;$j<$num_of_feedbacks;$j++){
        $id_user = $datagen->getIdUser();
        $feedback = rand(-1,1);
        if($feedback==0)
            $feedback = -1;
        $stmt = $conn->prepare("insert into feedback (id_user, id_danger , feedback) values(?, ?,?)");
        $stmt->bind_param('iii', $id_user, $index, $feedback);
        $stmt->execute();
        $stmt->close();
    }
}



class DataGenerator{

    
    function getLastName(){
        return "John";
    }
    function getFirstName(){
        return "Doe";
    }

    function getLocation(){
        $lat = rand(0,10000000);
        $latInt = rand(3,7);
        $lng = rand(3000000,8000000);
        $LngInt = rand(0,9);
        $lat = '4'.$latInt.'.'.$lat;
        $lng = '2'.$LngInt.'.'.$lng;
        $location = $lat.' '.$lng;
        return $location;
    }

    function getEventRange(){
        return rand(5000,50000);
    }

    function getEventType(){
        $event_type = rand(1,4);
        if($event_type ==1) 
           return  'fire';
        if($event_type ==2)
           return  'flood';
        if($event_type ==3 )
           return  'earthquake';
        if($event_type ==4)
           return  'snowstorm';
    }

    function getIdUser(){
        return rand(0,115);
    }

    function getYear(){
        $year = rand (10,18);
        $year = '20'.$year;
        $month = rand(1,12);
        $day = rand (1,29); 
        $full_date = $year.'/'.$month.'/'.$day; 
        $full_date = date('Y/m/d H:i:s', strtotime($full_date));
        return $full_date;
    }

    function getFeedback(){
        $feedback = rand(-1,1);
        if($feedback==0)
            $feedback = -1;
        return $feedback;
    }

}


    $dataGenerator = new DataGenerator;
    $desciption = "Eveniment intr-o zi oarecare";
    $todaydescription = "Eveniment din ziua curenta";

    ## generare cu date random
    for($i=1;$i<$NUMBER_OF_RECORDS;$i++){
        $lastname = $dataGenerator->getLastName().$i;
        $email  = 'john.doe'.$i.'@myemail.com';
        $id_user = $dataGenerator->getIdUser();
        usersInsert($lastname,$dataGenerator->getFirstName(),$email,$dataGenerator->getLocation(),$conn);
        eventsInsert($i,$id_user,$dataGenerator->getLocation(),$dataGenerator->getEventRange(),$dataGenerator->getEventType(),$desciption,$dataGenerator->getYear(),$conn);
        usersUpdate($id_user,$conn);
        commentsInsert($dataGenerator,$i,$conn,$NUMBER_MAX_OF_COMMENTS,0);
        feedbackInsert($dataGenerator,$i,$conn,$NUMBER_MAX_OF_FEEDBACK);
    }
    ## generare  ziua curenta
    for($i=$NUMBER_OF_RECORDS;$i<$NUMBER_OF_RECORDS_TODAY+$NUMBER_OF_RECORDS;$i++){
        $lastname = $dataGenerator->getLastName().$i;
        $email  = 'john.doe'.$i.'@myemail.com';
        $id_user = $dataGenerator->getIdUser();
        usersInsert($lastname,$dataGenerator->getFirstName(),$email,$dataGenerator->getLocation(),$conn);
        eventsInsert($i,$id_user,$dataGenerator->getLocation(),$dataGenerator->getEventRange(),$dataGenerator->getEventType(),$todaydescription,'sysdate()',$conn);
        usersUpdate($id_user,$conn);
        commentsInsert($dataGenerator,$i,$conn,$NUMBER_MAX_OF_COMMENTS,1);
        feedbackInsert($dataGenerator,$i,$conn,$NUMBER_MAX_OF_FEEDBACK);
    }


    
    echo 'done generating events, users, feedback and comments';

?>



