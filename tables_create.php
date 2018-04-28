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
            $sql = "CREATE DATABASE " . $dbname;
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
        $sql = "DROP TABLE Action;";
        if ($conn->query($sql) == TRUE){
            echo "Done drop Action <br>";
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
            address VARCHAR(50) NOT NULL,
            conn_date DATE
        )";
        if ($conn->query($sql) == TRUE){
            echo "Done create Users <br>";
        }else{
            echo "Error: " . $conn->error;
        }
        //..
        $sql = "CREATE TABLE Action (
            id_danger INT(6) PRIMARY KEY,
            id_user INT(6),
            status INT(2)
        )";
        if ($conn->query($sql) == TRUE){
            echo "Done create Action <br>";
        }else{
            echo "Error: " . $conn->error;
        }

        $sql = "INSERT INTO Users (firstname, lastname, email, password, address, conn_date) VALUES ('Jhon','Doe','john_doe@myemail.com','D74FF0EE8DA3B9806B18C877DBF29BBDE50B5BD8E4DAD7A3A725000FEB82E8F1','Iasi, Romania',sysdate())";
        if (!$conn->query($sql) == TRUE){
            echo "Error: " . $conn->error;
        }

    
    $conn->close();

?>
