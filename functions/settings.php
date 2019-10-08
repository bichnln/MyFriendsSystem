<?php 
    $host = "feenix-mariadb.swin.edu.au";
    $user = "s101668056";
    $password = "140898";
    $db = "s101668056_db";

    $conn = new mysqli($host, $user, $password, $db);

    if ($conn->connect_error) {
        die ("Connection failed: " . $conn->connect_error);
    } else {
        echo "Connect successfully!";
    }
    
?>