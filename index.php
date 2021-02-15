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
    <link rel="stylesheet" type="text/css"  href="style.css"/>
    <script
      src="https://kit.fontawesome.com/6c6865fb6d.js"
      crossorigin="anonymous"
    ></script>
    
</head>
<body>
<div class='container'>
    <!-- <div class = 'page-header'>
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
    </ul> -->



        <div class="form-container">
                 
            <div class="form-header"><h1>Login</h1></div>

            
            <form id="login_form" class="form" action="index.php" method="POST">
                
            <div class='form-group'>
               
                <input type="text" class="form-control" name="email" maxlength="50" value="<?= $email; ?>" placeholder="Email" required/> 
            </div>

            <div class='form-group'>
                
                <input type="password" class="form-control" name="password" maxlength="20"
                placeholder="Password" required/>
            </div>

                <button type="submit" value="login" class="btn btn-outline-primary">Login</button>
                <!-- <button type="reset" value="clear" class="btn btn-outline-secondary">Clear</button> -->
            </form>

            <div class="signup-link">
                <a href="signup.php">Sign up for an account</a>
            </div>
            
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
                    
                }}
            // } else {
            //     echo "<div class='alert alert-warning' role='alert'>"
            //     . $err 
            //     . "</div>";
                
            // }
        }
    } 
    ?>
            
        </div>

        <br>

   

</div>

</body>

</html>