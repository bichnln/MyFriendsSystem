<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="description" content="My Friend System"/>
    <meta name="keywords" content="Assignmetn 2"/>
    <meta name="author" content="Le Ngoc Bich Nguyen"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
</head>
<body>
<div class='container'>
    <div class = 'page-header'>
        <h1 class="page_header">My Friend System</h1>
    </div>

    <div style = "<?php 
            if (isset($_SESSION['user']) && $_SESSION['user'] !== null) 
            {
                echo 'display:block';
            } else {
                echo 'display:none';
            }
        ?>"> 
        <ul class="nav nav-tabs justify-content-end">
            <li class="nav-item active">
                <a class="nav-link active" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="friendlist.php">Friend List</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="friendadd.php">Add Friend</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>

    <div style = " <?php 
            if (!isset($_SESSION['user']))
            {
                echo 'display:block';
            } else {
                echo 'display:none';
            }   
    
    ?>">
            <ul class="nav nav-tabs justify-content-end">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php">Sign Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li> -->
            </ul>
    
    </div>
    <br>
    <h2>Welcome to My Friend System</h2>


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
        if ($conn->query($sql_create_table_friends) === FALSE) {
            
        
            echo "<p>Error creating table: " . $conn->error . "</p>";
        }

        // use connection object created in functions/settings.php
        // to create table my_friends
        if ($conn->query($sql_create_table_myfriends) === FALSE) {
            
            echo "<p>Error creating table: " . $conn->error . "</p>";
        }
    ?>
</div>
</body>
</html>