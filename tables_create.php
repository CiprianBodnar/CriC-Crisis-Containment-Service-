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

        $sql = "DROP TABLE Users;";
        if ($conn->query($sql) == TRUE){
            echo "Done drop Users<br>";
        }else{
            echo "Error: " . $conn->error;
        }
        //..
        $sql = "DROP TABLE Reports;";
        if ($conn->query($sql) == TRUE){
            echo "Done drop Action <br>";
        }else{
            echo "Error: " . $conn->error;
        }
        $sql = "DROP TABLE Feedback;";
        if ($conn->query($sql) == TRUE){
            echo "Done drop Feedback <br>";
        }else{
            echo "Error: " . $conn->error;
        }
        $sql = "DROP TABLE Reset_Pwd;";
        if ($conn->query($sql) == TRUE){
            echo "Done drop Reset_Pwd <br>";
        }else{
            echo "Error: " . $conn->error;
        }
        $sql = "DROP TABLE Person_Finder;";
        if ($conn->query($sql) == TRUE){
            echo "Done drop Person Finder<br>";
        }else{
            echo "Error: " . $conn->error;
        }
        //..
        $sql = "CREATE TABLE Users (
            id_user INT(6)  AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL,
            password CHAR(64) NOT NULL,
            address VARCHAR(80) NOT NULL,
            conn_date DATE
        )";
        if ($conn->query($sql) == TRUE){
            echo "Done create Users <br>";
        }else{
            echo "Error: " . $conn->error;
        }
        //..
        $sql = "CREATE TABLE Reports (
            id_danger INT(6),
            id_user INT(6)
        )";
        if ($conn->query($sql) == TRUE){
            echo "Done create Action <br>";
        }else{
            echo "Error: " . $conn->error;
        }

        $sql = "CREATE TABLE Feedback (
            id_user INT(6) NOT NULL,
            id_danger INT(6) NOT NULL,
            feedback INT(2) NOT NULL
            )";
         if ($conn->query($sql) == TRUE){
            echo "Done create Feedback <br>";
        }else{
            echo "Error: " . $conn->error;
        }
        /*..*/
        $sql = "CREATE TABLE Reset_Pwd (
            email VARCHAR(50) NOT NULL,
            ekey VARCHAR(50) NOT NULL
            )";
         if ($conn->query($sql) == TRUE){
            echo "Done create Reset_Pwd <br>";
        }else{
            echo "Error: " . $conn->error;
        }
        /*..*/
        $sql = "CREATE TABLE Person_Finder (
            name VARCHAR(30) NOT NULL,
            details VARCHAR(150)
            )";
         if ($conn->query($sql) == TRUE){
            echo "Done create Person_Finder <br>";
        }else{
            echo "Error: " . $conn->error;
        }
    
        $sql = "INSERT INTO Users (firstname, lastname, email, password, address, conn_date) VALUES ('Jhon','Doe','john_doe@myemail.com','D74FF0EE8DA3B9806B18C877DBF29BBDE50B5BD8E4DAD7A3A725000FEB82E8F1','Iasi, Romania',sysdate())";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error;
        }
        
        $sql = "INSERT INTO Reports (id_user, id_danger) VALUES (1,1);";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error;
        }
        $sql = "INSERT INTO Reports (id_danger, id_user) VALUES (2,1);";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error;
        }
        $sql = "INSERT INTO Reports (id_danger, id_user) VALUES (3,1);";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error;
        }
        $sql = "INSERT INTO Reports (id_danger, id_user) VALUES (4,1);";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error;
        }
        $sql = "INSERT INTO Reports (id_danger, id_user) VALUES (5,1);";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error;
        }

        $sql = "INSERT INTO Person_Finder (name, details) VALUES ('Alabama HotPocket','E prajit baiatu');";
        if (!$conn->query($sql) ){
            echo "Error: " . $conn->error;
        }

    
    $conn->close();

?>
