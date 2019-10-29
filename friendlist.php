<?php 
    session_start();

    require_once("functions/settings.php");
    require_once("functions/validation_functions.php");

    if (!(isset($_SESSION['user']) && $_SESSION['user'] !== null)) {
        header ("location: login.php");
    } 
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
        <h1>My Friend System</h1>
    </div>

    <br>

    <ul class="nav nav-tabs justify-content-end">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Friend List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="friendadd.php">Add Friend</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    </ul>

    <br>

    <?php
        global $conn;
        $friendlist = array(array());
        array_pop($friendlist);
        $user_profile = fetch_profile($_SESSION['user']);

        $id = $user_profile['friend_id'];
        $profile_name = $user_profile['profile_name'];
        if (isset($_GET['deleted_id'])) 
        {
            $deleted_id = $_GET['deleted_id'];
            $unfriend_msg = unfriend($id, $deleted_id);
        } 

        echo "<h2>$profile_name</h2>";
        
        $friendlist = get_friendlist($id);
        $no_friends = count($friendlist);
        if ($no_friends > 0) 
        {
            echo "<p class='font-weight-normal'>Total number of friends: " . $no_friends . "</p>";
            echo "<br>";
            echo "<h4 >Friend List</h4>";

            echo "<table class='table table-hover table-bordered'>";
            echo "<tr><th>ID</th><th>Name</th><th></th></tr>";
            for ($i = 0; $i < count($friendlist); $i++) 
            {
                echo "<form action='friendlist.php' method='GET' >";
                echo "<input type='hidden' name='deleted_id' value='" . $friendlist[$i]['ID'] . "'/>";
                echo "<tr><td>" . $friendlist[$i]['ID'] . "</td>" 
                    . "<td>" . $friendlist[$i]['ProfileName'] . "</td>"
                    . "<td>" . "<input type='submit' class='btn btn-outline-dark' name='deleted' value = 'Unfriend'/></td>";
                echo "</form>";
            }
            echo "</table>";
        } 
        else 
        {
            echo "<div class='alert alert-warning' role='alert'>
                You don't have any friends!            
             </div>";
        }
    ?>

    <a class="btn btn-primary" href="friendadd.php" role="button">Add Friends</a>
    <a class="btn btn-dark" href="logout.php" role="button">Logout</a>

</div>
</body>
</html>