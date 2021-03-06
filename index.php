<?php
    // check for existing session and redirect to dashboard page if user is logged in
    if (!isset($_SESSION)) {
        session_start();
        if (array_key_exists('username', $_SESSION)) {
            header("Location: ../dashboard.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Log In or Sign Up</title>
</head>
<body>
    <h1>DEEGO</h1>
    <p>
        To view all posts, log in or sign up.
    </p>
    <p>
        This service will always be free! YOU are the product ;)
    </p>
    <h2>Log In</h2>
    
    <form action="session/start.php" method="post">
    <div>
        Username: <input type="text" name="username">
    </div>
    <div>
        Password: <input type="password" name="password">
    </div>
    <input type="submit" value="Login" id="login-button">
</form>
    
    <?php if (array_key_exists('error_msg', $_SESSION)) { ?>
        <p class="error-message" style="color: red; style: block;"><?=$_SESSION['error_msg']?></p>
    <?php } ?>
    
    <h2>Sign Up</h2>
    <form action="user/create.php" method="post">
    <div>
        Username: <input type="text" name="username">
    </div>
    <div>
        First name: <input type="text" name="fname">
    </div>
    <div>
        Password: <input type="password" name="password">
    </div>
        <input type="submit" value="Register" id="signup-button">
    </form>
</body>
</html>