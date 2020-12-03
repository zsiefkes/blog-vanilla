<?php
    // check for existing session and redirect to login page if session variables aren't set
    if (!isset($_SESSION)) {
        // for some reason it's showing a set session even after i've "unset" one on logout, so... just a second check to see if there isn't a username key in the session array. redirect to homepage if so.
        session_start();
        if (!array_key_exists('username', $_SESSION)) {
            header("Location: /blog1/index.php");
        } else {
            // user is currently logged in. save user variables to session store.
            $fname = $_SESSION['fname'];
            $username = $_SESSION['username'];
            $user_id = $_SESSION['user_id'];

            // establish database connection
            $servername = "localhost";
            $dbusername = "myuser";
            $dbpassword = "mypass";
            $dbname = "mydb";
            $connection = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
        }
    } else {
        // in theory if there is no session set, redirect to homepage
        header("Location: /blog1/index.php");
    } 
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="js/dashboard-script.js"></script>    
    <title>Blog</title>
</head>
<body>
    <?php
        // $date = date_create('2000-01-01');
        // echo date_format($date, 'Y-m-d H:i:s');
        // $timestamp = date("Y-m-d H:i:s");
        // echo $timestamp;
        // um check if a user is logged in... we only get the dashboard if we're logged in... right?
        // so ..................... how tf we do this lol
        // session_start();
        // echo $fname, $username;
    ?>
    <nav>
        <ul>
            <li><a href="/blog1/dashboard.php">Home</a></li>
            <?php
                if (array_key_exists('username', $_SESSION)) { ?>
                    <li><a href="user/read.php">Profile</a></li>
                <?php }
            ?>
            <li><a href="session/end.php">Logout</a></li>
        </ul>
    </nav>
    <section>
        <?php
            if ($_SESSION['just_reenabled'] == true) { ?>
                <h2>Welcome back, <?= $fname ?>!</h2>
        <?php } else { ?>
            <h2>What's on your mind, <?= $fname ?>?</h2>
        <?php } ?>
        <p class="char-remaining">
            Characters: <span id="char-remaining-count"></span>
        </p>
        <form action="post/create.php" method="post">
            <textarea name="body" id="post-textarea" cols="60" rows="10"></textarea>
            <input type="hidden" name="user_id" value=<?= $user_id ?>>
            <button type="submit" class="submit-button button-disabled" disabled>Submit</button>
        </form>
    </section>
    <section>
        <h2>Posts</h2>
        <div id="posts-list">
        <?php
            // query table
            $result = mysqli_query($connection, "SELECT * FROM posts ORDER BY timestamp DESC;");
            // order by timestamp desc returns posts in ascending order i.e. with most recent post first.
            foreach ($result as $post) { 
                // grab details of poster
                $post_user_id = $post['user_id'];
                $post_id = $post['id'];
                $user_query = $connection->prepare("SELECT * FROM users WHERE id = ?;");
                $user_query->bind_param("i", $post_user_id);
                $user_query->execute();
                $user_result = $user_query->get_result();
                $user_row = $user_result->fetch_assoc();
                ?>

                <!-- display first ??? characters of post with link to full post -->
                <a class="post-link" href="/blog1/post/read.php?id=<?=$post_id?>">
                    <div class="post-container">
                        <span class="timestamp">
                            Posted by 
                            <a href="user/read.php?id=<?=$post_user_id?>">
                                <?= $user_row['username'] ?>
                            </a>
                            at <?= $post['timestamp'] ?>
                            <?php
                                if ($post_user_id == $user_id) { ?>
                                    <a class="edit-post" href="post/read.php?id=<?=$post_id?>&edit=1">Edit post</a>
                                    <a class="delete-post" onclick="return confirm('Are you sure you wish to delete this post?')" href="post/destroy.php?id=<?=$post_id?>">Delete post</a>
                                <?php }
                            ?>
                        </span>
                        <p>
                            <?= $post['body']; ?>
                        </p>
                    </div>
                </a>
            <?php }
        ?>
        </div>
    </section>    
</body>
</html>