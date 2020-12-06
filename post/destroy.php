<?php
    // $connection = new mysqli("localhost", "myuser", "mypass", "mydb");
    $connection = include_once("../connect-to-db.php");

    if (isset($_REQUEST['id'])) {
        if ($_REQUEST['id'] == '') {
            // redirect if id was empty
            header("Location: /blog1/dashboard.php");
        }

        // grab logged in user id
        // if (!isset($_SESSION)) {
        session_start();
        $user_id = $_SESSION['user_id'];
        // } else {
            // header("Location: /blog1/dashboard.php");
        // }
        
        // grab user id of post creator
        $select_post_query = $connection->prepare("SELECT * FROM posts WHERE id = ? ;");
        $select_post_query->bind_param("i", $_REQUEST['id']);
        $select_post_query->execute();
        $result = $select_post_query->get_result();
        $post = $result->fetch_assoc();
        
        // double check logged in user is the creator of the post
        if ($post['user_id'] == $user_id) {

            // delete post from database and redirect
            $delete_post_query = $connection->prepare("DELETE FROM posts WHERE id = ? ;");
            $delete_post_query->bind_param("i", $_REQUEST['id']);
            $delete_post_query->execute();

            if (isset($_REQUEST['redirect_to'])) {
                header("Location: /blog1/" . $_REQUEST['redirect_to']);
            } else {
                header("Location: /blog1/dashboard.php");
            }
        }
        header("Location: /blog1/dashboard.php");
    }
?>