<?php
    // $connection = new mysqli("localhost", "myuser", "mypass", "mydb");
    $connection = include_once("../connect-to-db.php");

    // grab logged in user id and request id
    session_start();
    $user_id = $_SESSION['user_id'];
    $update_user_id = $_REQUEST['id'];
    
    // check user id and request user id match
    if ($update_user_id != $user_id) {
        header("Location: ../dashboard.php");
    }

    // grab password from database
    $query = $connection->prepare("SELECT password FROM users WHERE id = ?;");
    $query->bind_param("i", $_REQUEST['user_id']);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    $current_password_hash = $row['password'];

    // check submitted password matches the hashed password...
    // $username = $_REQUEST['username'];
    // $fname = $_REQUEST['fname'];

    if (password_verify($_REQUEST['password'], $current_password_hash)) {
        echo "yep :)";
        // excellent! we're going to query the post table and delete all of this user's posts, then query the user's table and remove that user.
        $remove_posts_query = $connection->prepare("DELETE FROM posts WHERE user_id = ?;");
        $remove_posts_query->bind_param("i", $user_id);
        $remove_posts_query->execute();

        // and now delete the user!
        $delete_user_query = $connection->prepare("DELETE FROM users WHERE id = ?");
        $delete_user_query->bind_param("i", $user_id);
        $delete_user_query->execute();

        // end session
        header("Location: ../session/end.php");

    } else {
        // echo "nope :(";
        // password didn't match. redirect back to profile page... should really communicate error message about this
        header("Location: read.php?id=" . $user_id);
    }   
?>