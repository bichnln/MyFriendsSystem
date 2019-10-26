<?php 
    // TODO: change to feenix!
    $host = "localhost";
    $user = "root";
    $password = "root";
    $db = "assign2";

    $conn = new mysqli($host, $user, $password, $db);

    if ($conn->connect_error) {
        die ("Connection failed: " . $conn->connect_error);
    } 
?>