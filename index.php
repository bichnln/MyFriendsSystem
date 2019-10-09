<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="description" content="My Friend System"/>
    <meta name="keywords" content="Assignmetn 2"/>
    <meta name="author" content="Le Ngoc Bich Nguyen"/>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
    <header class="page_header">
        <h1>My Friend System</h1>
    </header>
    <hr>
    <p>Name: Le Ngoc Bich Nguyen</p>
	<p>Student ID: 101668056</p>
	<p>Email: <a href="mailto:101668056@student.swin.edu.au? subject=subject text">101668056@student.swin.edu.au</a></p>
	<p>I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from any other student's work or from any other source.</p>

    <p><a href="signup.php">Sign Up</a></p>
    <p><a href="login.php">Login</a></p>
    <p><a href="about.php">About</a></p>


    <?php 
        require_once("functions/settings.php");
        $sql_create_table_friends = "CREATE TABLE IF NOT EXISTS friends(
                                            friend_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                                            friend_email VARCHAR(50) NOT NULL,
                                            password VARCHAR(20) NOT NULL,
                                            profile_name VARCHAR(30) NOT NULL,
                                            date_started DATE NOT NULL,
                                            num_of_friends INT UNSIGNED);";

        $sql_create_table_myfriends = "CREATE TABLE IF NOT EXISTS myfriends(
                                            friend_id1 INT NOT NULL,
                                            friend_id2 INT NOT NULL);";

        // use connection object created in functions/settings.php
        // to create table friends
        if ($conn->query($sql_create_table_friends) === TRUE) {
            echo "<p>Table created successfully!</p>";
        } else {
            echo "<p>Error creating table: " . $conn->error . "</p>";
        }

        // use connection object created in functions/settings.php
        // to create table my_friends
        if ($conn->query($sql_create_table_myfriends) === TRUE) {
            echo "<p>Table create successfully!</p>";
        } else {
            echo "<p>Error creating table: " . $conn->error . "</p>";
        }
    ?>
</body>
</html>