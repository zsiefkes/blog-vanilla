<?php
    // $connection = new mysqli("localhost", "myuser", "mypass", "mydb");
    $connection = include_once("../connect-to-db.php");

    // grab logged in user id and request parameters
    session_start();
    $user_id = $_SESSION['user_id'];
    $update_user_id = $_REQUEST['id'];
    $username = $_REQUEST['username'];
    $fname = $_REQUEST['fname'];
    
    // check user id and request user id match
    if ($update_user_id != $user_id) {
        header("Location: ../dashboard.php");
    }

    // check old password matches
    $query = $connection->prepare("SELECT password FROM users WHERE id = ?;");
    $query->bind_param("i", $_REQUEST['user_id']);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    $current_password_hash = $row['password'];
    
    // check if user is updating their password
    $isChangingPassword = $_REQUEST['password_change'];
    echo $username, $fname, $isChangingPassword;
    
    // check submitted password matches the hashed password...
    if (password_verify($_REQUEST['password_current'], $current_password_hash)) {
        // excellent! grab request parameters and prepare update query

        // if we're updating the password,
        if ($isChangingPassword) {
            // create new password hash
            $new_pass_hash = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
            // and run update query
            $update_query = $connection->prepare("UPDATE users SET username = ?, fname = ?, password = ? WHERE id = ?;");
            $update_query->bind_param("sssi", $username, $fname, $new_pass_hash, $user_id);
            $update_query->execute();
            
        } else {
            // otherwise just run update query without setting password
            $update_query = $connection->prepare("UPDATE users SET username = ?, fname = ? WHERE id = ?;");
            $update_query->bind_param("ssi", $username, $fname, $user_id);
            $update_query->execute();
        }

        // and now ... remove any error message and redirect back to the user's profile page.
        session_start();
        unset($_SESSION['error_msg']);
        header("Location: read.php?id=" . $user_id);
    } else {
        // password didn't match. redirect back to profile page and set error message on session
        session_start();
        $_SESSION['error_msg'] = "Incorrect password.";
        header("Location: read.php?edit=1&id=" . $user_id);
    }   

?>