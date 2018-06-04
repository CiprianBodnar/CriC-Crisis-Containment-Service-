<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CricDB";

    $conn = new mysqli($servername, $username, $password);

    if($conn -> connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    
    $conn -> select_db($dbname);
    if($result = $conn->query("SELECT DATABASE()")){
        $row = $result -> fetch_row();
        if($row[0] === NULL){
            $sql = "CREATE DATABASE " . $dbname . " CHARACTER SET utf16 collate utf16_unicode_ci ";
            if(!$conn->query($sql)){
                die("Failed to create DB ");
            }
            $conn -> select_db($dbname);
        }
    
    }
        //drop users
        $sql = "DROP TABLE Users;";
        if ($conn->query($sql) == TRUE){
            echo "Done drop Users<br>";
        }else{
            echo "Error: " . $conn->error."<br>";
        }

        //drop notifications
         $sql = "DROP TABLE notifications;";
         if ($conn->query($sql) == TRUE){
             echo "Done drop notifications <br>";
         }else{
             echo "Error: " . $conn->error."<br>";
         }

        //drop events

        $sql = "DROP TABLE events;";
        if ($conn->query($sql) == TRUE){
            echo "Done drop events <br>";
        }else{
            echo "Error: " . $conn->error."<br>";
        }
        //..

        //drop feedback
        $sql = "DROP TABLE Feedback;";
        if ($conn->query($sql) == TRUE){
            echo "Done drop Feedback <br>";
        }else{
            echo "Error: " . $conn->error."<br>";
        }
        //drop reset_pwd
        $sql = "DROP TABLE Reset_Pwd;";
        if ($conn->query($sql) == TRUE){
            echo "Done drop Reset_Pwd <br>";
        }else{
            echo "Error: " . $conn->error."<br>";
        }

        //drop person_finder
        $sql = "DROP TABLE Person_Finder;";
        if ($conn->query($sql) == TRUE){
            echo "Done drop Person Finder<br>";
        }else{
            echo "Error: " . $conn->error."<br>";
        }

        $sql = "DROP TABLE comments;";
        if ($conn->query($sql) == TRUE){
            echo "Done drop comments<br>";
        }else{
            echo "Error: " . $conn->error."<br>";
        }
        //..
        $sql = "CREATE TABLE Users (
            id_user INT(6)  AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL,
            password CHAR(64) NOT NULL,
            address VARCHAR(80) NOT NULL,
            posted INT(6),
            conn_date DATETIME
        )";
        if ($conn->query($sql) == TRUE){
            echo "Done create Users <br>";
        }else{
            echo "Error: " . $conn->error."<br>";
        }
        //..
        // $sql = "CREATE TABLE Reports (
        //     id_danger INT(6),
        //     id_user INT(6)
        // )";

        $sql = "CREATE TABLE events (
            id_event INT(6) NOT NULL primary key auto_increment,
            id_user INT(6) NOT NULL,
            location varchar(50) NOT NULL,
            event_range INT(9) not null,
            type varchar(15) not null,
            description text not null,
            event_date datetime not null
            )";
        if ($conn->query($sql) == TRUE){
            echo "Done create events <br>";
        }
        else{
            echo "Error: " . $conn->error."<br>";
        }

        $sql = "CREATE TABLE Feedback (
            id_user INT(6) NOT NULL,
            id_danger INT(6) NOT NULL,
            feedback INT(2) NOT NULL
            )";
         if ($conn->query($sql) == TRUE){
            echo "Done create Feedback <br>";
        }else{
            echo "Error: " . $conn->error."<br>";
        }
        /*..*/
        $sql = "CREATE TABLE Reset_Pwd (
            email VARCHAR(50) NOT NULL,
            ekey VARCHAR(50) NOT NULL
            )";
         if ($conn->query($sql) == TRUE){
            echo "Done create Reset_Pwd <br>";
        }else{
            echo "Error: " . $conn->error."<br>";
        }
        /*..*/
        $sql = "CREATE TABLE Person_Finder (
            id INT(6) NOT NULL PRIMARY KEY auto_increment,
            id_user_in_danger INT(6) NOT NULL,
            id_user_posting INT(6) NOT NULL,
            details VARCHAR(150),
            address VARCHAR(80),
            conn_date DATETIME
            )";
         if ($conn->query($sql) == TRUE){
            echo "Done create Person_Finder <br>";
        }else{
            echo "Error: " . $conn->error."<br>";
        }

        $sql = "CREATE TABLE comments (
            id INT(6) NOT NULL PRIMARY KEY auto_increment,
            user_id int(6) not null,
            event_id int(6) not null,
            content text not null,
            post_date DATETIME not null
            )";
         if ($conn->query($sql) == TRUE){
            echo "Done create comments <br>";
        }else{
            echo "Error: " . $conn->error."<br>";
        }

        $sql = "CREATE TABLE notifications (
            id INT(6) NOT NULL PRIMARY KEY auto_increment,
            user_id int(6) NOT NULL,
            infos text,
            notification_date DATETIME NOT NULL
            )";
        
        if ($conn->query($sql) == TRUE){
            echo "Done create notification <br>";
        }else{
            echo "Error: " . $conn->error."<br>";
        }
    
        $sql = "INSERT INTO Users (firstname, lastname, email, password, address, conn_date) VALUES ('Jhon','Doe','john_doe@myemail.com','D74FF0EE8DA3B9806B18C877DBF29BBDE50B5BD8E4DAD7A3A725000FEB82E8F1','46.05178614016413 23.53747432532782',sysdate())";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error."<br>";
        }
            
        $sql = "INSERT INTO events (id_user, location, event_range, type, description, event_date) values(1, '46.05178614016413 23.53747432532782',50000,'flood', 'Description 1', STR_TO_DATE('1-01-2012', '%d-%m-%Y'))";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error."<br>";
        }
        $sql = "INSERT INTO events (id_user, location, event_range, type, description, event_date) values(1, '47.376147952677464 25.731042861637434',3500,'fire', 'Description 2', STR_TO_DATE('1-01-2010', '%d-%m-%Y'))";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error."<br>";
        }
        $sql = "INSERT INTO events (id_user, location, event_range, type, description, event_date) values(1, '47.8433692 25.9116992', 5000,'person', 'Description 3', STR_TO_DATE('1-01-2014', '%d-%m-%Y'))";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error."<br>";
        }
        $sql = "INSERT INTO events (id_user, location, event_range, type, description, event_date) values(1, '46.942902018973214 23.178674297477528', 100000,'snowstorm', 'Description 4', STR_TO_DATE('1-01-2017', '%d-%m-%Y'))";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error."<br>";
        }
        $sql = "INSERT INTO events (id_user, location, event_range, type, description, event_date) values(1, '45.7838705 26.4059382', 99999,'earthquake', 'Description 5', STR_TO_DATE('08-05-2018', '%d-%m-%Y'))";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error."<br>";
        }

       

    
    $conn->close();

?>
