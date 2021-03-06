<?php
    // check for existing session and redirect to login page if session variables aren't set
    if (!isset($_SESSION)) {
        session_start();
        if (array_key_exists('username', $_SESSION)) {
            // user is currently logged in. save user variables to session store.
            $fname = $_SESSION['fname'];
            $username = $_SESSION['username'];
            $user_id = $_SESSION['user_id'];
        } else {
            header("Location: ../index.php");
        }
    } 
    
    // establish database connection
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
        <ul class="top-navbar">
            <li class="nav-item"><a href="../dashboard.php">Home</a></li>
            <?php
                if (array_key_exists('username', $_SESSION)) { ?>
                    <li class="nav-item"><a href="../user/read.php">Profile</a></li>
                <?php }
            ?>
            <li class="nav-item"><a href="../session/end.php">Logout</a></li>
        </ul>
    </nav>
    <section>
        <h2>Deactivate account</h2>
        <div class="delete-info">
            <p>
                Deactivating your account will hide your posts and profile from other users. If you would like to retrieve your posts and reactivate your account, simply log in again. Enter your password if you would like to deactivate your account.
            </p>
            <form class="delete-form" action="deactivate.php?id=<?=$user_id?>" method="post">
                <div>
                    <label for="password_current">Password:</label>
                    <input type="password" name="password">
                </div>
                <input type="hidden" name="user_id" value=<?=$user_id?>>
                <input type="submit" value="Deactivate account">
                <a href="read.php?id=<?=$user_id?>">Return to profile</a>
            </form>
            <?php if (array_key_exists('error_msg', $_SESSION)) { ?>
                <p class="error-message" style="color: red; style: block;"><?=$_SESSION['error_msg']?></p>
        <?php } ?>
    
            <h2>Delete account</h2>
    
            <p>Deleting your account will remove all of your posts and is permanent. Your account information and posts will not be retrievable. Are you sure you want to do this? If so, enter your password below.</p>
            <form class="delete-form" action="destroy.php?id=<?=$user_id?>" method="post">
                <div>
                    <label for="password_current">Password:</label>
                    <input type="password" name="password">
                </div>
                <input type="hidden" name="user_id" value=<?=$user_id?>>
                <input type="submit" value="Delete account">
                <a href="read.php?id=<?=$user_id?>">Don't delete</a>
            </form>
        </div>
    </section>
     
</body>
</html>