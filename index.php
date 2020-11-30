<?php
    // check for existing session and redirect to dashboard page if user is logged in
    if (!isset($_SESSION)) {
        // header("Location: /blog1/dashboard.php");
        session_start();
        if (array_key_exists('username', $_SESSION)) {
            header("Location: /blog1/dashboard.php");
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
    <h1>DIGO</h1>
    <h2>Log In</h2>
    <form action="session/start.php">
        <div>
            Username: <input type="text" name="username"><span class="form-error"></span>
        </div>
        <div>
            Password: <input type="password" name="password"><span class="form-error"></span>
        </div>
        <input type="submit" value="Login" id="login-button">
    </form>
    
    
    
    <h2>Sign Up</h2>
    <form action="user/create.php">
    <div>
        Username: <input type="text" name="username"><span class="form-error"></span>
    </div>
    <div>
        First name: <input type="text" name="fname"><span class="form-error"></span>
    </div>
    <div>
        Password: <input type="password" name="password"><span class="form-error"></span>
    </div>
        <input type="submit" value="Register" id="signup-button">
    </form>
</body>
</html>