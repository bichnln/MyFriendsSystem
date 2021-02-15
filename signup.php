<?php 
    session_start();
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $email = "";
    }
    if (isset($_POST['profile'])) {
        $profile = $_POST['profile'];
    } else {
        $profile = "";
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
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div class='container'>
    <!-- <div class = 'page-header'>
        <h1>My Friend System</h1>
    </div>

    <ul class="nav nav-tabs justify-content-end">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Sign Up</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="login.php">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
        </li>
    </ul> -->

    <div class="form-container">
        <div class="form-header"><h1>Registration Form</h1></div>
        <form id="signup_form" class="form" method="POST">
            <div class='form-group'>
                
                <input type="text" class="form-control" name="email" maxlength="50" value="<?= $email; ?>" placeholder="Email" required/> 
            </div>

            <div class='form-group'>
                
                <input type="text" class="form-control" name="profile" maxlength="30" value="<?= $profile ?>" placeholder="Profile Name" required/> 
            </div>

            <div class='form-group'>
                
                <input type="password" class="form-control" name="password" maxlength="20" placeholder="password" required/>
            </div>

            <div class='form-group'>
               
                <input type="password" class="form-control" name="confirm_password" maxlength="20" placeholder="Confirm password" required/>
            </div>

            <button type="submit" value="register" class="btn btn-outline-primary">Register</button>
            <button type="reset" value="clear" class="btn btn-outline-secondary">Clear</button>
        </form>

        <div class="signup-link"><a href="index.php">Already a member? Click here to sign in</a>

    <br>
    
    <?php 
        require_once("functions/validation_functions.php");
        //require_once("functions/settings.php");
        $err = "";

        if ((isset($_POST['email'])) 
                && (isset($_POST['profile'])) 
                && (isset($_POST['password']))
                && (isset($_POST['confirm_password'])))
        {
            if (empty_check($_POST['email'])) {
                $err = $err . "<p>Email is empty!</p>";
            } 
            if (pattern_check($_POST['email'], "email") === false) {
                $err = $err . "<p>Email is not valid!</p>";
            }
            if (friend_email_exist($_POST['email'])) {
                $err = $err . "<p>Email already existed!</p>";
            }
            if (empty_check($_POST['profile'])) {
                $err = $err . "<p>Profile name is empty!</p>";
            }
            if (!pattern_check($_POST['profile'], "profile")) {
                $err = $err . "<p>Profile Name is not valid!</p>";
            }
            if (!pattern_check($_POST['password'], "password")) {
                $err = $err . "<p>Password is not valid!</p>";
            }
            if (!($_POST['confirm_password'] === $_POST['password'])) {
                $err = $err . "<p>Confirm Password and Password do not match!</p>";
            }
            if ($err == "") {
                $profile = $_POST['profile'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $date = date('d/m/y');

                // sql query to retrieve data
                $sql = "INSERT INTO friends (friend_email, password, profile_name, date_started, num_of_friends) VALUES('$email', '$password', '$profile', '$date', 0)";

                global $conn;
                
                if ($result = $conn->query($sql)) {
                    echo "<p>Data successfully added to database!</p>";
                    //$result->free();
                } 
                else {
                    echo "<p>Error: " . $conn->error . "</p>";
                }
                
                $conn->close();
                $_SESSION['login'] = "yes";
                $_SESSION['user'] = $email;
                header("location:friendadd.php");
            } else {
                echo "<div class='alert alert-warning' role='alert'>"
                     . $err 
                     . "</div>";
            }
        
        } 
    ?>
</div>
</body>
</html>