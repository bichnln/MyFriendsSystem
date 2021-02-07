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
        <h1>My Friend System</h1>
    </div>

    <br>
    
    <div style = "<?php 
            if (isset($_SESSION['user']) && $_SESSION['user'] !== null) 
            {
                echo 'display:block';
            } else {
                echo 'display:none';
            }
        ?>"> 
        <ul class="nav nav-tabs justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="friendlist.php">Friend List</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="friendadd.php">Add Friend</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">About</a>
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
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php">Sign Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">About</a>
                </li>
            </ul>
    
    </div>

            

</div>
</body>
</html>