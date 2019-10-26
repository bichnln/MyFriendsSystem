<?php 
    session_start();

    require_once("functions/settings.php");
    require_once("functions/validation_functions.php");

    if (!(isset($_SESSION['user']) && $_SESSION['user'] !== null)) {
        echo "<p>Error 404</p>";
    } else {
        global $conn;
        $friendlist = array(array());
        array_pop($friendlist);
        $user_profile = fetch_profile($_SESSION['user']);

        $id = $user_profile['friend_id'];
        if (isset($_GET['deleted_id'])) {
            $deleted_id = $_GET['deleted_id'];

            $unfriend_msg = unfriend($id, $deleted_id);
        } else {
            echo "<p>deleted not set!</p>";
        }

        echo "<h1 class='page_header'>My Friend System</h1>";

        $friendlist = get_friendlist($id);

        if (count($friendlist) > 0) {
            echo "<table border='1px'>";
            echo "<tr><th>ID</th><th>Name</th><th></th></tr>";
            for ($i = 0; $i < count($friendlist); $i++) {
                echo "<form action='friendlist.php' method='GET' >";
                echo "<input type='hidden' name='deleted_id' value='" . $friendlist[$i]['ID'] . "'/>";
                echo "<tr><td>" . $friendlist[$i]['ID'] . "</td>" 
                    . "<td>" . $friendlist[$i]['ProfileName'] . "</td>"
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