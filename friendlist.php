<?php 
    session_start();
    if (!(isset($_SESSION['login']) && $_SESSION['login'] === "yes")) {
        echo "<p>Error 404</p>";
    } else {
        require_once("functions/settings.php");
        echo "<h1 class='page_header'>My Friend System</h1>";
        
        global $conn;
        $friendlist = array(array());
        array_pop($friendlist);
        $id = array();
        $name = array();
        $sql = "SELECT * FROM friends WHERE friend_email = '" . $_SESSION['user'] . "'; ";

        if ($result = $conn->query($sql)) {
            if ($result->num_rows == 1) {
                while($row = $result->fetch_assoc() ) {
                    $id = $row['friend_id'];
                    $profile = $row['profile_name'];
                    $email = $row['friend_email'];
                    $date_started = $row['date_started'];
                    $num_of_friends = $row['num_of_friends'];
                }
            }
            $result->free();
        }
        $sql = "SELECT myfriends.friend_id2 AS ID, friends.profile_name AS Name 
                FROM myfriends 
                INNER JOIN friends ON myfriends.friend_id2 = friends.friend_id
                WHERE myfriends.friend_id1 = '" . $id . "';";
        
        if ($result = $conn->query($sql)) {
            if ($result->num_rows > 0) {
                while ($row_1 = $result->fetch_array()) {
                    array_push($friendlist, $row_1);
                }
            } 
            $result->free();
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
        
        if (count($friendlist) > 0) {
            echo "<table border='1px'>";
            echo "<tr><th>ID</th><th>Name</th></tr>";
            for ($i = 0; $i < count($friendlist); $i++) {
                echo "<tr><td>" . $friendlist[$i][0] . "</td>" 
                    . "<td>" . $friendlist[$i][1] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>You don't have any friends!</p>";
        }
    
    }

    echo "<p><a href='login.php'>Login</a></p>";
?>