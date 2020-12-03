<?php
    $connection = new mysqli("localhost", "myuser", "mypass", "mydb");

    if (isset($_REQUEST['id'])) {
        if ($_REQUEST['id'] == '') {
            // redirect if id was empty
            header("Location: /blog1/dashboard.php");
        }
        $post_id = $_REQUEST['id'];
        
        // grab logged in user id
        session_start();
        $user_id = $_SESSION['user_id'];
        
        // check user id and post id match
        if ($post_user_id != $user_id) {
            // header("Location: /blog1/dashboard.php");
            header("Location: /blog1/post/read.php?id=" . $post_id);
        }

        // grab post details
        // $select_post_query = $connection->prepare("SELECT * FROM posts WHERE id = ? ;");
        // $select_post_query->bind_param("i", $post_id);
        // $select_post_query->execute();
        // $result = $select_post_query->get_result();
        // $post = $result->fetch_assoc();
        // $post_body = $post['body'];
        // $post_user_id = $post['user_id'];
        // $post_timestamp = $post['timestamp'];
        
        // grab poster details
        // $user_query = $connection->prepare("SELECT * FROM posts WHERE id = ? ;");
        // $user_query->bind_param("i", $_REQUEST['post_user_id']);
        // $user_query->execute();
        // $user_result = $user_query->get_result();
        // $poster = $user_result->fetch_assoc();
        // $poster_username = $poster['username'];
        // $poster_username = $poster['fname'];

        $body = $_REQUEST['body'];
        if (strlen($body) > 499) {
            $body = substr($body, 0, 499);
        }
        $timestamp = date("Y-m-d H:i:s");

        // run the update query
        $update_query = $connection->prepare("UPDATE posts SET body = ?, timestamp = ? WHERE id = ?;");
        // $update_query = $connection->prepare("INSERT INTO posts (body, timestamp, user_id) VALUES (?, ?, ?) ;");
        $update_query->bind_param("sss", $body, $timestamp, $post_id);
        $update_query->execute();
        // $result = $update_query->get_result();
        // header("Location: /blog1/dashboard.php");
        header("Location: /blog1/post/read.php?id=" . $post_id);
  
    }
    header("Location: /blog1/post/read.php?id=" . $post_id);
?>