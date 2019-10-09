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
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
    <h1>My Friend System</h1>
    <h2>Registration Page</h2>

    <fieldset>
        <legend>Registration Form</legend>
        <form id="signup_form" class="form" method="POST">
            <label for="email">Email: </label>
            <input type="text" name="email" maxlength="50" value="<?= $email; ?>" /> <br>

            <label for="profile">Profile Name:</label>
            <input type="text" name="profile" maxlength="30" value="<?= $profile ?>"/> <br>

            <label for="password">Password:</label>
            <input type="password" name="password" maxlength="20"/> <br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" maxlength="20"/> <br>

            <button type="submit" value="register" class="form_btn">Register</button>
            <button type="reset" value="clear" class="form_button">Clear</button>
        </form>
    </fieldset>

    <p><a href="index.php">Home</a></p>
    
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
                } 
                else {
                    echo "<p>Error: " . $conn->error . "</p>";
                }
                $result->free();
                $conn->close();

                $_SESSION['login'] = "yes";
                $_SESSION['user'] = $email;
                header("location:friendadd.php");
            } else {
                echo "<p>$err</p>";
            }
        
        } else {
            echo "<p>Error!</p>";
        } 
    ?>
</body>
</html>