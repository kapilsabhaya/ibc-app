<?php
  /* $servername = "db002.db.13972570.hostedresource.com";
    $username = "db002";
    $password = "G54d6rytv@df!D";*/


$servername = "localhost";
$username = "root";
$password = "";
    $dbname = "databaseemcy212";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>