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
    if (password_verify($_REQUEST['password'], $current_password_hash)) {
        // run update query
        $update_query = $connection->prepare("UPDATE users SET enabled = 0 WHERE id = ?;");
        $update_query->bind_param("i", $user_id);
        $update_query->execute();

        // end session
        header("Location: ../session/end.php");

    } else {
        // password didn't match. redirect back to profile page... should really communicate error message about this
        session_start();
        $_SESSION['error_msg'] = "Incorrect password.";
        header("Location: delete.php?id=" . $user_id);
    }   
?>