<?php 
    session_start();
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $email = "";
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
<div >
    <div class = 'page-header'>
        <h1 class="page_header">My Friend System</h1>
    </div>

    <ul class="nav nav-tabs justify-content-end">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="signup.php">Sign Up</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
        </li>
    </ul>


        <div class="login-form-container">
        
        <!-- <legend>Login Form</legend> -->
        <form id="login_form" class="form" action="login.php" method="POST">
        <h2>Login</h2>    
        <div class='form-group'>
            <label for="email">Email </label>
            <input type="text" class="form-control" name="email" maxlength="50" value="<?= $email; ?>"
            placeholder="Email"/> 
        </div>

        <div class='form-group'>
            <label for="password">Password </label>
            <input type="password" class="form-control" name="password" maxlength="20"/>
        </div>
        <div class="btn-wrapper">
            <button type="submit" value="login" class="btn btn-outline-primary">Login</button>
            <button type="reset" value="clear" class="btn btn-outline-secondary">Clear</button>
</div>
        </form>
        <img src="3457741.jpg" alt="formimg" />
        </div>


        <br>

    <?php 
    require_once("functions/validation_functions.php");

    if (isset($_SESSION['user']) && ($_SESSION['user'] !== null)) {
        header("location: friendlist.php");
    } else {
        $err = "";
        if ((isset($_POST['email']))  && (isset($_POST['password']))) {
            if (empty_check($_POST['email'])) {
                $err = $err . "Email is empty!";
            }
            if ($err == "") {
                if (password_check($_POST['password'], $_POST['email'])) {
                    $_SESSION['user'] = $email;
                    header("location:friendlist.php");
                } else {
                    echo "<div class='alert alert-danger' role='alert'>
                            Email does not exist or wrong password!
                        </div>";
                }
            } else {
                echo "<div class='alert alert-warning' role='alert'>"
                . $err 
                . "</div>";
            }
        }
    } 
    ?>

</div>


</body>

</html>