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
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
    <h1 class="page_header">My Friend System</h1>
    <h2>Login Page</h2>

    <fieldset>
        <legend>Login Form</legend>
        <form id="login_form" class="form" action="login.php" method="POST">
            
            <label for="email">Email: </label>
            <input type="text" name="email" maxlength="50" value="<?= $email; ?>"/> <br>

            <label for="password">Password: </label>
            <input type="password" name="password" maxlength="20"/> <br>
        
            <button type="submit" value="login" class="form_btn">Login</button>
            <button type="reset" value="clear" class="form_btn">Clear</button>
        </form>
    </fieldset>

    <p><a href="index.php">Home</a></p>
</body>
<?php 
    require_once("functions/validation_functions.php");

    $err = "";
    if ((isset($_POST['email']))  && (isset($_POST['password']))) {
        if (empty_check($_POST['email'])) {
            $err = $err . "<p>Email is empty!</p>";
        }

        if ($err == "") {
            if (password_check($_POST['password'], $_POST['email'])) {
                $_SESSION['login'] = "yes";
                $_SESSION['user'] = $email;
                header("location:friendlist.php");
            } else {
                echo "<p>Email does not exist or wrong password!</p>";
            }
        } else {
            echo $err;
        }
    }
?>
</html>