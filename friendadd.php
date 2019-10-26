    <?php 
        session_start();

        require_once("functions/settings.php");
        require_once("functions/validation_functions.php");

        if (!(isset($_SESSION['user']) && $_SESSION['user'] !== null)) {
           echo "<p>Error 404</p>";
        } else {
            global $conn;
            $id;
            $pageno;
            $total_pages = 0;
            $no_records = 5;
            $friendsuggestion = array(array());
            array_pop($friendsuggestion);


            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }

            $offset = ($pageno -1) * $no_records;

            $user_profile = fetch_profile($_SESSION['user']);
            $id = $user_profile['friend_id'];
            $no_friends = $user_profile['num_of_friends'];
            echo "<h1 class='page_header'>My Friend System</h1>";
            
            if (isset($_GET['added_id'])) {
                $added_id = $_GET['added_id'];
                    if (!relationship_exist($id, $added_id)) {
                        $addMsg = add_friend($id, $added_id);
                        echo $addMsg;
                    } 
            } 
            echo "<p>Number of friends: " . $no_friends . "</p>";
            $no_friends = $user_profile['num_of_friends'];

            $friendsuggestion = friend_suggestion($id, $offset, $no_records, $total_pages);

            echo "<p>Total pages: $total_pages</p>";
            

            if (count($friendsuggestion) > 0) {
                for ($i = 0; $i < count($friendsuggestion); $i++) {
                    $friendsuggestion[$i]['num_of_mutuals'] = count_mutualfriends($id, $friendsuggestion[$i]['friend_id']);
                }
                
                echo "<table border='1px'>";
                    for ($i = 0; $i < count($friendsuggestion); $i++) {
                        echo "<form action='friendadd.php' method='GET'>";
                        echo "<input type='hidden' name='added_id' value='" . $friendsuggestion[$i]['friend_id'] . "'/>";
                        echo "<tr><td>" . $friendsuggestion[$i]['profile_name'] . "</td>"
                        . "<td>" . $friendsuggestion[$i]['num_of_mutuals'] . " mutual friend(s)" . "</td>"
                        . "<td>" .  "<input type='submit' value='Add Friend'/></td>";
                        echo "</form>";
                }
                    echo "</table>";
            }  else {
                    echo "<p>No friend suggestion!</p>";
            }  
      }
    ?>
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
    <ul class="pagination">
        <li><a href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>
    <p><a href="logout.php">Logout</a></p>
    <p><a href='index.php'>Home Page></a></p>
    <p><a href="friendlist.php">Friend List</a></p>
    <p><a href="about.php">About</a></p>
</body>
</html>