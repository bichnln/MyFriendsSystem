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
    <header class='page_header'>
        <h1>My Friend System</h1>
    </header>

    <?php 
        session_start();
        require_once("functions/settings.php");
        global $conn;
        $id;
        $friendsuggestion = array(array());
        array_pop($friendsuggestion);

        echo "<p>" . $_SESSION['user'] . "</p>";
        $sql = "SELECT * FROM friends WHERE friend_email = '" . $_SESSION['user'] . "'; ";

        if ($result = $conn->query($sql)) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $id = $row['friend_id'];
                $profile = $row['profile_name'];
                $email = $row['friend_email'];
                $date_started = $row['date_started'];
                $num_of_friends = $row['num_of_friends'];      
            }
            $result->free();
        }
        if (isset($_GET['added_id'])) {
            $added_id = $_GET['added_id'];
            echo "<p>$added_id</p>";
            $addfriendSQL = "INSERT INTO myfriends (friend_id1, friend_id2) 
                             VALUES ('" . $id . "', '" . $added_id . "'), 
                                    ('" . $added_id . "', '" . $id . "'); ";
            if (!$result = $conn->query($addfriendSQL)) {
                echo "<p>Error occurred: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Added not set!</p>";
        }

        echo "<h1 class='page_header'>My Friend System</h1>";

        $friends_suggested = "SELECT * FROM friends
                                WHERE friend_id NOT IN (
                                    SELECT friend_id1 FROM myfriends
                                    WHERE (myfriends.friend_id1 = '" . $id . "' OR myfriends.friend_id2 = '" . $id . "')
                                    ); ";           
                                    
        if ($result = $conn->query($friends_suggested)) {
            if ($result->num_rows > 0 ) {
                while ($row = $result->fetch_assoc()) {
                    array_push($friendsuggestion, $row);
                }
            }
            $result->free();
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }

        if (count($friendsuggestion) > 0) {
            echo "<table border='1px'>";
                for ($i = 0; $i < count($friendsuggestion); $i++) {
                    echo "<form action='friendadd.php' method='GET'>";
                    echo "<input type='hidden' name='added_id' value='" . $friendsuggestion[$i]['friend_id'] . "'/>";
                    echo "<tr><td>" . $friendsuggestion[$i]['profile_name'] . "</td>"
                       . "<td>" .  "<input type='submit' value='Add Friend'/></td>";
                    echo "</form>";
            }
                echo "</table>";
        }  else {
                echo "<p>No friend suggestion!</p>";
        }

             
      
         
    ?>

</body>