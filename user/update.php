<?php
    $connection = new mysqli("localhost", "myuser", "mypass", "mydb");

    // so. I am going to grab in the username and first name from the bloody request.
    // oh. maybe first check the password matches.
    // start the session and grab logged in user id

    // grab logged in user id and request id
    session_start();
    $user_id = $_SESSION['user_id'];
    $update_user_id = $_REQUEST['id'];
    
    // check user id and request user id match
    if ($update_user_id != $user_id) {
        // header("Location: /blog1/dashboard.php");
        header("Location: ../dashboard.php");
    }

    // check old password matches
    $query = $connection->prepare("SELECT password FROM users WHERE id = ?;");
    $query->bind_param("i", $_REQUEST['user_id']);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    $current_password_hash = $row['password'];

    // check submitted password matches the hashed password...
    $username = $_REQUEST['username'];
    $fname = $_REQUEST['fname'];
    // are we updating the password?
    $isChangingPassword = $_REQUEST['password_change'];
    echo $username, $fname, $isChangingPassword;

    if (password_verify($_REQUEST['password_current'], $current_password_hash)) {
        echo "yep :)";
        // excellent! grab request parameters and prepare update query

        // if we're updating the password
        if ($isChangingPassword) {
            // create new password hash
            $new_pass_hash = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
            // write and run update query
            $update_query = $connection->prepare("UPDATE users SET username = ?, fname = ?, password = ? WHERE id = ?;");
            $update_query->bind_param("sssi", $username, $fname, $new_pass_hash, $user_id);
            $update_query->execute();
            
        } else {
            // otherwise just run update query without setting password
            $update_query = $connection->prepare("UPDATE users SET username = ?, fname = ? WHERE id = ?;");
            $update_query->bind_param("ssi", $username, $fname, $user_id);
            $update_query->execute();
        }

        // and now ... redirect to the user's dashboard, I guess?
        // or nah, their profile page.
        header("Location: read.php?id=" . $user_id);
        
        // $update_query = $connection->prepare("UPDATE posts SET body = ?, timestamp = ? WHERE id = ?;");
        // // $update_query = $connection->prepare("INSERT INTO posts (body, timestamp, user_id) VALUES (?, ?, ?) ;");
        // $update_query->bind_param("sss", $body, $timestamp, $post_id);
        // $update_query->execute();
    } else {
        // echo "nope :(";
        // password didn't match. redirect back to profile page... should really communicate error message about this
        header("Location: read.php?id=" . $user_id);
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

        // $query = $connection->prepare("SELECT password FROM users WHERE username = ?;");
        // $query->bind_param("s", $_REQUEST['username']);
        // $query->execute();
        // $result = $query->get_result();
        // // while ($row = $result->fetch_assoc()) {
        // //     $password_hash = $row['password'];
        // //     // printing result to check
        // //     // echo $row['password']."<br>";
        // // }
        // $row = $result->fetch_assoc();
        // $password_hash = $row['password'];
        // check submitted password matches the hashed password...
        // if (password_verify($_REQUEST['password'], $password_hash)) {
        //     echo 'true!';
        //     // oh my god holy fucking shit IT WORKS YESSSSSSSSSSSSSSSSSSSSSSS
        //     // okay now we need to start a session :S weird
        //     // start session and redirect to dashboard
            
        //     // grab user details... yeah?   
        //     $user_query = $connection->prepare("SELECT * FROM users WHERE username = ?;");
        //     $user_query->bind_param("s", $_REQUEST['username']);
        //     $user_query->execute();
        //     $user_result = $user_query->get_result();
        //     // while ($row = $result->fetch_assoc()) {
        //         //     $password_hash = $row['password'];
        //         //     // printing result to check
        //         //     // echo $row['password']."<br>";
        //         // }
        //     $user_row = $user_result->fetch_assoc();
        //     $user_id = $user_row['id'];
        //     $username = $user_row['username'];
        //     $fname = $user_row['fname'];
        //     $user_enabled = $user_row['enabled'];
        
        
        
        // // run the update query
        // $update_query = $connection->prepare("UPDATE posts SET body = ?, timestamp = ? WHERE id = ?;");
        // // $update_query = $connection->prepare("INSERT INTO posts (body, timestamp, user_id) VALUES (?, ?, ?) ;");
        // $update_query->bind_param("sss", $body, $timestamp, $post_id);
        // $update_query->execute();
        // // $result = $update_query->get_result();
        // // header("Location: /blog1/dashboard.php");
        // header("Location: /blog1/post/read.php?id=" . $post_id);
        // }
  
    // header("Location: /blog1/post/read.php?id=" . $post_id);
?>