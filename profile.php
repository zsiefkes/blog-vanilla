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
    $servername = "localhost";
    $dbusername = "myuser";
    $dbpassword = "mypass";
    $dbname = "mydb";
    $connection = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
    
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
    
        // if id was not provided in url, check if user is logged in and default to their profile
    } else if (array_key_exists('user_id', $_SESSION)) {
        header("Location: /blog1/profile.php?id=" . $_SESSION['user_id']);

        // user not logged in, no id provided, redirect to landing page
    } else {
        header("Location: /blog1/index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title></title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="/blog1/dashboard.php">Home</a></li>
            <?php
                if (array_key_exists('username', $_SESSION)) { ?>
                    <li><a href="/blog1/profile.php">Profile</a></li>
                <?php }
            ?>
            <li><a href="/blog1/session/end.php">Logout</a></li>
        </ul>
    </nav>
    <section>
        <?php
            // user profile details
            // their name and... other optional stuff? location?
            // after a user signs up, maybe direct them to their profile to fill shit out, or something
            // location, occupation, website. dunno
            ?>
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
                ?>
                <div class="post-container">
                    <span class="timestamp">Posted by <?= $profile_username ?> at <?= $row['timestamp'] ?></span>
                    <p>
                        <?= $row['body']; ?>
                    </p>
                </div>
            <?php }
        ?>
    </section>    
    <script src="script.js"></script>    
</body>
</html>