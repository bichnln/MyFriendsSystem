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
            <input type="text" name="email"/> <br>

            <label for="profile">Profile Name:</label>
            <input type="text" name="profile"/> <br>

            <label for="password">Password:</label>
            <input type="password" name="password"/> <br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password"/> <br>

            <button type="submit" value="register" class="form_btn">Register</button>
            <button type="reset" value="clear" class="form_button">Clear</button>
        </form>
    </fieldset>
    
    <?php 
        if (isset($_POST['email']) 
            && isset($_POST['profile'])
            && isset($_POST['password'])
            && isset($_POST['confirm_password'])) 
        {
            
        }

    ?>
</body>
</html>