<?php 
        session_start();
        if (!(isset($_SESSION['user']) && $_SESSION['user'] !== null)) {
            header("location: login.php");
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

    <ul class="nav nav-tabs justify-content-end">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="friendlist.php">Friend List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Add Friend</a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
        </li> -->
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    </ul>
    <br>

    <?php 
        require_once("functions/settings.php");
        require_once("functions/validation_functions.php");

        global $conn;
        $id;
        $pageno;
        $total_pages = 0;

        $friendsuggestion = array(array());
        array_pop($friendsuggestion);
        
        if (!isset($_SESSION['no_records'])) 
        {
            $_SESSION['no_records'] = 5;
        }

        if (isset($_GET['no_records']) && $_GET['no_records'] !== null && $_GET['no_records'] !== '0' && pattern_check($_GET['no_records'], "number"))
        {
            $_SESSION['no_records'] = $_GET['no_records'];
        }

                 
        $no_records = $_SESSION['no_records'];

        if (isset($_GET['pageno'])) 
        {
            $pageno = $_GET['pageno'];
        } 
        else 
        {
            $pageno = 1;
        }

        $offset = ($pageno -1) * $no_records;

        $user_profile = fetch_profile($_SESSION['user']);
        $id = $user_profile['friend_id'];
        $profile_name = $user_profile['profile_name'];
        $no_friends = $user_profile['num_of_friends'];
            
        if (isset($_GET['added_id'])) 
        {
            $added_id = $_GET['added_id'];
            if (!relationship_exist($id, $added_id)) 
            {
                $addMsg = add_friend($id, $added_id);
                echo $addMsg;
            } 
        } 

        echo "<h2>$profile_name</h2>";
        echo "<p class='font-weight-normal'>Total number of added friends: " . $no_friends . "</p>";
        

        $no_friends = $user_profile['num_of_friends'];
        $friendsuggestion = friend_suggestion($id, $offset, $no_records, $total_pages);

        
            
        if (count($friendsuggestion) > 0) 
        {
            echo "<br>";
            echo "<h4 >Friend Suggestions</h4>";
            echo "<form action='friendadd.php' method='GET'>
                    <div class='input-group mb-3'>
                        <input type='text' class='form-control' value='" . $no_records . "' aria-describedby='basic-addon2' name='no_records'>
                        <div class='input-group-append'>
                            <span class='input-group-text' id='basic-addon2'>Records per page</span>
                        </div>
                    </div>
                </form>";

            for ($i = 0; $i < count($friendsuggestion); $i++) 
            {
                $friendsuggestion[$i]['num_of_mutuals'] = count_mutualfriends($id, $friendsuggestion[$i]['friend_id']);
            }
            echo "<table class='table table-hover table-bordered'>";
            echo "<tr><th>Name</th><th>Number of mutual friends</th><th></th></tr>";
                for ($i = 0; $i < count($friendsuggestion); $i++) 
                {
                    echo "<form action='friendadd.php' method='GET'>";
                    echo "<input type='hidden' name='added_id' value='" . $friendsuggestion[$i]['friend_id'] . "'/>";
                    echo "<tr><td>" . $friendsuggestion[$i]['profile_name'] . "</td>"
                        . "<td>" . $friendsuggestion[$i]['num_of_mutuals'] . " mutual friend(s)" . "</td>"
                        . "<td>" .  "<input type='submit' class='btn btn-outline-success' value='Add Friend'/></td>";
                    echo "</form>";
                }
                    echo "</table>";
        }  
        else 
        {
            echo "<div class='alert alert-warning' role='alert'>
                    No friend suggestion!            
             </div>";
            
        }  
    ?>

    <div style=" <?php if($total_pages <= 1) {echo 'display:none';} ?>">
    <p>Total pages: <?php echo $total_pages ?> </p>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
            <!-- <li><a href="?pageno=1">1</a></li> -->
                <li class=" <?php if($pageno <= 1){ echo 'disabled'; } ?> page-item ">
                    <a class='page-link' href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); }  ?>">
                        <span aria-hidden="true">&larr;</span> Previous
                    </a>
                </li>

                <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> page-item">
                    <a class='page-link' href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">
                        Next <span aria-hidden="true">&rarr;</span></a>
                    </a>
                </li>
            
            </ul>
        </nav>
    </div>

</ul>

</div>
</body>
</html>