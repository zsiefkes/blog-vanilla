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
        
        // check user id and post id match
        if ($post_user_id != $user_id) {
            header("Location: ../post/read.php?id=" . $post_id);
        }

        // limit body chars and set timestamp
        $body = $_REQUEST['body'];
        if (strlen($body) > 499) {
            $body = substr($body, 0, 499);
        }
        $timestamp = date("Y-m-d H:i:s");

        // run the update query
        $update_query = $connection->prepare("UPDATE posts SET body = ?, timestamp = ? WHERE id = ?;");
        $update_query->bind_param("sss", $body, $timestamp, $post_id);
        $update_query->execute();
        header("Location: ../post/read.php?id=" . $post_id);
  
    }
    header("Location: ../post/read.php?id=" . $post_id);
?>