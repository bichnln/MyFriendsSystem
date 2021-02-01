<?php 
    $cleardb_url = parse_url(getenv("mysql://bde0813befe43f:db931998@us-cdbr-east-03.cleardb.com/heroku_fbb2daf5acdfb47?reconnect=true"));
    $host = "us-cdbr-east-03.cleardb.com";
    $user = "bde0813befe43f";
    $password = "db931998";
    $db = "heroku_fbb2daf5acdfb47";

    $conn = new mysqli($host, $user, $password, $db);

    if ($conn->connect_error) {
        die ("Connection failed: " . $conn->connect_error);
    } 
?>