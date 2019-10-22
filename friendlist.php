<?php 
    session_start();
    require_once("functions/settings.php");
    if (!(isset($_SESSION['login']) && $_SESSION['login'] === "yes")) {
        echo "<p>Error 404</p>";
    } else {

        global $conn;
        $friendlist = array(array());
        array_pop($friendlist);
        $id;
       // $name = array();
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
        if (isset($_GET['deleted_id'])) {
            $deleted_id = $_GET['deleted_id'];
            $unfriendSQL = "DELETE FROM myfriends
                            WHERE 
                                (friend_id1 = '" . $id . "' AND  friend_id2 = '" . $deleted_id . "')
                            OR 
                                (friend_id1 = '" . $deleted_id . "' AND friend_id2 = '" . $id . "'); ";
            if (!$result = $conn->query($unfriendSQL)) {
                echo "<p>Error occured: " . $conn->erro . "</p>";
            }
        } else {
            echo "<p>deleted not set!</p>";
        }
        
        echo "<h1 class='page_header'>My Friend System</h1>";
        
        
        $sql = "SELECT myfriends.friend_id2 AS ID, friends.profile_name AS Name 
                FROM myfriends 
                INNER JOIN friends ON myfriends.friend_id2 = friends.friend_id
                WHERE myfriends.friend_id1 = '" . $id . "';";
        
        if ($result = $conn->query($sql)) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($friendlist, $row);
                }
            } 
            $result->free();
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
        
        if (count($friendlist) > 0) {
            echo "<table border='1px'>";
            echo "<tr><th>ID</th><th>Name</th><th></th></tr>";
            for ($i = 0; $i < count($friendlist); $i++) {
                echo "<form action='friendlist.php' method='GET' >";
                echo "<input type='hidden' name='deleted_id' value='" . $friendlist[$i]['ID'] . "'/>";
                echo "<tr><td>" . $friendlist[$i]['ID'] . "</td>" 
                    . "<td>" . $friendlist[$i]['Name'] . "</td>"
                    . "<td>" . "<input type='submit' name='deleted' value = 'Unfriend'/></td>";
                echo "</form>";
            }
            echo "</table>";

        } else {
            echo "<p>You don't have any friends!</p>";
        }

        
    
    }

    echo "<p><a href='friendadd.php'>Add Friend</a></p>";
    echo "<p><a href='logout.php'>Log Out</a></p>";
?>