<?php
    // $connection = new mysqli("localhost", "myuser", "mypass", "mydb");
    $connection = include_once("../connect-to-db.php");

    if (isset($_REQUEST['id'])) {
        if ($_REQUEST['id'] == '') {
            // redirect if id was empty
            header("Location: ../dashboard.php");
        }
        $post_id = $_REQUEST['id'];

        // grab logged in user id
        session_start();
        $user_id = $_SESSION['user_id'];
        
        // grab post details
        $select_post_query = $connection->prepare("SELECT * FROM posts WHERE id = ? ;");
        $select_post_query->bind_param("i", $post_id);
        $select_post_query->execute();
        $result = $select_post_query->get_result();
        $post = $result->fetch_assoc();
        $post_body = $post['body'];
        $post_user_id = $post['user_id'];
        $post_timestamp = $post['timestamp'];
        
        // grab poster details
        $user_query = $connection->prepare("SELECT * FROM posts WHERE id = ? ;");
        $user_query->bind_param("i", $_REQUEST['post_user_id']);
        $user_query->execute();
        $user_result = $user_query->get_result();
        $poster = $user_result->fetch_assoc();
        $poster_username = $poster['username'];
        $poster_fname = $poster['fname'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <?php
        // only need the javascript if it's a post you made page
        if ($user_id == $post_user_id) { ?>
            <script src="../js/post-read.js"></script>    
        <?php }
    ?>
    <title>View Post</title>
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
    <div class="post-container">
        <span class="timestamp">
            Posted by 
            <a href="../user/read.php?id=<?=$post_user_id?>">
                <?= $poster_username ?>
            </a>
            at <?= $post['timestamp'] ?>
            <?php
                if ($post_user_id == $user_id) { ?>
                    <a class="delete-post" onclick="return confirm('Are you sure you wish to delete this post?')" href="../post/destroy.php?id=<?=$post_id?>">Delete post</a>
                    <!-- <span id="edit-post">Edit post</span> -->
                    <a id="edit-post-button" href="#">Edit post</a>
                <?php }
            ?>

            <!-- hidden container for editing post. made visible via js -->
            <div id="edit-post-container">
                <p class="char-remaining">
                    Characters: <span id="char-remaining-count"></span>
                </p>
                <form action="update.php?id=<?=$post_id?>" method="post">
                    <textarea name="body" id="post-textarea" cols="60" rows="10"></textarea>
                    <input type="hidden" name="user_id" value=<?= $user_id ?>>
                    <button type="submit" class="submit-button button-disabled" disabled>Submit</button>
                </form>
            </div>
        </span>
        <p id="post-body">
            <?= $post['body']; ?>
        </p>
    </div>
</body>
</html>