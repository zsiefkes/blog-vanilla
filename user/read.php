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
    $connection = include_once("../connect-to-db.php");

    // load in variable corresponding to this user's profile
    if (isset($_REQUEST['id'])) {
        $profile_id = $_REQUEST['id'];
        
        // server request to grab profile user's data
        $profile_query = $connection->prepare("SELECT * FROM users WHERE id = ?;");
        $profile_query->bind_param("i", $profile_id);
        $profile_query->execute();
        $profile_result = $profile_query->get_result();
        $profile = $profile_result->fetch_assoc();
        $profile_username = $profile['username'];
        $profile_fname = $profile['fname'];
        $profile_joined = $profile['reg_time'];
        
        // if id was not provided in url, check if user is logged in and default to their profile
    } else if (array_key_exists('user_id', $_SESSION)) {
        header("Location: read.php?id=" . $_SESSION['user_id']);
        
        // user not logged in, no id provided, redirect to landing page
    } else {
        header("Location: ../index.php");
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <?php
        // only need the javascript if it's your profile page
        if ($user_id == $profile_id) { ?>
            <script src="../js/user-read.js"></script>    
        <?php }
    ?>
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
        <h1><?=$profile_username?>'s page</h1>
        <ul class="user-details">
            <li>Name: <?=$profile_fname?></li>
            <li>Member since: <?=$profile_joined?></li>
            <?php
                // if it's your profile, provide options to edit user details.
                if ($user_id == $profile_id) { ?>
                    <li>
                        <a id="edit-user-button" href="#">Edit details</a>
                    </li>
                <?php }
            ?>
            <!-- the editing stuff that will be hidden by default: -->
        </ul>
        <div class="edit-user-details" style="display: none;">
            <form action="update.php?id=<?=$profile_id?>" method="post">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" name="username" value=<?=$profile_username?>>
                </div>
                <div>
                    <label for="fname">First name:</label>
                    <input type="text" name="fname" value=<?=$profile_fname?>>
                </div>
                <div style="color: red;">Enter old password to update.</div>
                <div>
                    <label for="password_current">Current password:</label>
                    <input type="password" name="password_current">
                </div>
                <input type="hidden" name="user_id" value=<?=$user_id?>>
                <div>
                    <a id="edit-password-button" href="#">Change password</a>
                </div>
                <div id="new-password-container">
                    <label for="password">New password:</label>
                    <input type="password" name="password">
                    <label for="password-check">Confirm new password:</label>
                    <input type="password" name="password-check">
                </div>    
                <input type="hidden" name="password_change" value=0 id="password-change-flag">
                <span id="form-error"></span>              
                <input type="submit" id="submit-user-form" value="Update details">
                <!-- <a id="deactivate-user-button" style="diplay: none;" href="deactivate-portal">Deactivate account</a> -->
                <a id="delete-user-button" style="display: none;" href="delete.php">Delete account</a>
            </form>
        </div>
        <!-- <ul class="profile-details">
            <li>Name: <?= $profile_username ?></li>
        </ul> -->
    </section>
    <section>
        <h2>Posts by <?= $profile_username ?></h2>
        <div id="posts-list"></div>
        <?php
            // query posts table
            // $posts = mysqli_query($connection, "SELECT * FROM posts WHERE user_id = $profile_id ORDER BY timestamp DESC;");
            // grab all posts by profile user
            $posts_query = $connection->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY timestamp DESC;");
            $posts_query->bind_param("i", $profile_id);
            $posts_query->execute();
            $posts = $posts_query->get_result();
            // $posts = $posts_result->fetch_assoc();
            // order by timestamp desc returns posts in ascending order i.e. with most recent post first.
            foreach ($posts as $row) { 
                // grab post details
                $post_user_id = $row['user_id'];
                $post_id = $row['id'];
                ?>
                <div class="post-container">
                    <span class="timestamp">Posted by <?= $profile_username ?> at <?= $row['timestamp'] ?></span>
                    <?php
                        if ($post_user_id == $user_id) { ?>
                            <a class="edit-post" href="../post/read.php?id=<?=$post_id?>&edit=1">Edit post</a>
                            <a class="delete-post" onclick="return confirm('Are you sure you wish to delete this post?')" href="post/destroy.php?id=<?=$post_id?>">Delete post</a>
                        <?php }
                    ?>
                    <p>
                        <?= $row['body']; ?>
                    </p>
                </div>
            <?php }
        ?>
    </section>    
</body>
</html>