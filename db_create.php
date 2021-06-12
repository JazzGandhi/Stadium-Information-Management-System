<?php
$servername = "localhost";
$username   = "root";
$password   = "";

// Create connection
// PDO method
try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // set the PDO error mode to exception+
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS stadinfo";
    $conn->exec($sql);
    $sql = "USE stadinfo";
    $conn->exec($sql);

    echo "Connection success";
    echo "<br>";

    $sql ="CREATE table users(
        cuid INT( 10 ) AUTO_INCREMENT PRIMARY KEY,
        uname VARCHAR(20) NOT NULL,
        upassword VARCHAR( 256 ) NOT NULL,
        urole varchar(30),
        salary INT (10) ,
        systemID INT(10))" ;
    $conn->exec($sql);

    echo "users table created";
    echo "<br>";

    $sql ="CREATE table stadinfo (
        systemID INT ( 10 ) AUTO_INCREMENT PRIMARY KEY,
        systemName VARCHAR( 30 ) NOT NULL, 
        creatorcuid INT(10),
        FOREIGN KEY (`creatorcuid`) REFERENCES `users` (`cuid`) ON UPDATE CASCADE ON DELETE SET NULL)" ;
    $conn->exec($sql);

    // $sql="ALTER TABLE stadinfo RENAME COLUMN cuid TO creatorcuid";
    // $conn->exec($sql);

    echo "System table created";
    echo "<br>";

    $sql ="CREATE table schedule (
        s_date Date NOT NULL,
        start_time Time NOT NULL,
        end_time Time NOT NULL,
        title VARCHAR(30) NOT NULL,
        s_description VARCHAR(100) NOT NULL,
        systemID INT(10),
        FOREIGN KEY (`systemID`) REFERENCES `stadinfo` (`systemID`) ON UPDATE CASCADE ON DELETE CASCADE)" ;
    $conn->exec($sql);

    echo "schedule table created";
    echo "<br>";

    $sql = "ALTER TABLE users AUTO_INCREMENT=1000;";
    $conn->exec($sql);
    echo "initial cuid set to '1000' ";
    echo "<br>";

    $sql = "ALTER TABLE stadinfo AUTO_INCREMENT=10000;";
    $conn->exec($sql);
    echo "initial system ID set to '10000' ";
    echo "<br>";

    $sql ="CREATE table management_type(
        mngtype VARCHAR(20) NOT NULL)" ;
    $conn->exec($sql);

    echo "management type table created";
    echo "<br>";

    $sql ="CREATE table staff_type(
        mngtype VARCHAR(20) ,
        staffcuid INT(10) )" ;
    $conn->exec($sql);

    echo "staff type table created";
    echo "<br>";

    $sql = "INSERT INTO management_type  VALUES
            ('Security'),
            ('Resources'),
            ('Restroom'),
            ('Cleaning'),
            ('Guest Relations'),
            ('Operations')
            ;";
    $conn->exec($sql);

    echo "management type inserted";
    echo "<br>";


} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
