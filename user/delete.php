<?php
    // check for existing session and redirect to login page if session variables aren't set
    if (!isset($_SESSION)) {
        // for some reason it's showing a set session even after i've "unset" one on logout, so... just a second check to see if there isn't a username key in the session array. redirect to homepage if so.
        session_start();
        if (array_key_exists('username', $_SESSION)) {
            // user is currently logged in. save user variables to session store.
            $fname = $_SESSION['fname'];
            $username = $_SESSION['username'];
            $user_id = $_SESSION['user_id'];
        }
    } 
    
    // establish database connection
    // $servername = "localhost";
    // $dbusername = "myuser";
    // $dbpassword = "mypass";
    // $dbname = "mydb";
    // $connection = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
    $connection = include_once("../connect-to-db.php");

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title></title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="../dashboard.php">Home</a></li>
            <?php
                if (array_key_exists('username', $_SESSION)) { ?>
                    <li><a href="../user/read.php">Profile</a></li>
                <?php }
            ?>
            <li><a href="../session/end.php">Logout</a></li>
        </ul>
    </nav>
    <section>
        <h1>Delete account</h1>

        <div class="edit-user-details">
            <p>Deleting your account will remove all of your posts and is permanent. Your account information and posts will not be retrievable. Are you sure you want to do this? If so, enter your password below.</p>
            <form action="destroy.php?id=<?=$user_id?>" method="post">
                <div>
                    <label for="password_current">Password:</label>
                    <input type="password" name="password">
                </div>
                <input type="hidden" name="user_id" value=<?=$user_id?>>
                <input type="submit" id="submit-user-form" value="Delete account">
                <a href="read.php?id=<?=$user_id?>">Don't delete</a>
            </form>
        </div>
    </section>
     
</body>
</html>