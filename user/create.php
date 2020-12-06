<?php
    // $connection = new mysqli("localhost", "myuser", "mypass", "mydb");
    $connection = include_once("../connect-to-db.php");

    // grab request parameters and hash password
    $username = $_REQUEST['username'];
    $fname = $_REQUEST['fname'];
    $pass_hash = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);

    // make sure we don't have empty values. set error messages in session and redirect to home page
    if ($_REQUEST['username'] == "") {
        session_start();
        $_SESSION['error_msg'] = "Please provide a username.";
        echo 'sup';
        header("Location: ../index.php");
    } else if ($_REQUEST['fname'] == "") {
        session_start();
        $_SESSION['error_msg'] = "Please provide a first name.";
        header("Location: ../index.php");
    } else if ($_REQUEST['password'] == "") {
        session_start();
        $_SESSION['error_msg'] = "Please provide a password.";
        header("Location: ../index.php");
    } else {

        // make sure user with same username doesn't already exist
        $user_query = $connection->prepare("SELECT * FROM users WHERE username = ?;");
        $user_query->bind_param("s", $username);
        $user_query->execute();
        $user_result = $user_query->get_result();
        $user_row = $user_result->fetch_assoc();
        $user_id = $user_row['id'];
        
        if ($user_id != null) {
            // user with same username already exists. redirect back to home page and set error message on session
            session_start();
            $_SESSION['error_msg'] = "Username is already taken.";
            header("Location: ../index.php");
    
        } else {
            // create user record in db
            $query = $connection->prepare("INSERT INTO users (username, fname, password) VALUES (?, ?, ?) ;");
            $query->bind_param("sss", $username, $fname, $pass_hash);
            $query->execute();
            // $result = $query->get_result();
            // we're not doing anything with the result.... we should be checking that it's successful
    
            // grab id of just created user
            $user_query = $connection->prepare("SELECT * FROM users WHERE username = ?;");
            $user_query->bind_param("s", $username);
            $user_query->execute();
            $user_result = $user_query->get_result();
            $user_row = $user_result->fetch_assoc();
            $user_id = $user_row['id'];
            // $username = $user_row['username'];
            // $fname = $user_row['fname'];
            // $user_enabled = $user_row['enabled']; // 1 by default when you create a user
    
            // start session set session variables
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['fname'] = $fname;
            $_SESSION['just_reenabled'] = false;
            header("Location: ../dashboard.php");
        }
    
    }
?>