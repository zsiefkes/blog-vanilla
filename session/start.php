<?php
    $connection = include_once("../connect-to-db.php");
    
    if (isset($_REQUEST['username'])) {
        if ($_REQUEST['username'] === '' || $_REQUEST['password'] === '') {
            // back to homepage with error message
            session_start();
            $_SESSION['error_msg'] = "Please enter your username and password.";
            header("Location: ../index.php");
        } else {
            // grab password hash from the database corresponding to current user
            $query = $connection->prepare("SELECT password FROM users WHERE username = ?;");
            $query->bind_param("s", $_REQUEST['username']);
            $query->execute();
            $result = $query->get_result();
            
            // if no user with username found,
            if (mysqli_num_rows($result) == 0) {
                session_start();
                $_SESSION['error_msg'] = "Username not found.";
                header("Location: ../index.php");
            } else {

                $row = $result->fetch_assoc();
                $password_hash = $row['password'];
                // check submitted password matches the hashed password...
                if (password_verify($_REQUEST['password'], $password_hash)) {
                    echo 'true!';

                    // start session and redirect to dashboard
                    
                    // grab user details... yeah?   
                    $user_query = $connection->prepare("SELECT * FROM users WHERE username = ?;");
                    $user_query->bind_param("s", $_REQUEST['username']);
                    $user_query->execute();
                    $user_result = $user_query->get_result();
                    $user_row = $user_result->fetch_assoc();
                    $user_id = $user_row['id'];
                    $username = $user_row['username'];
                    $fname = $user_row['fname'];
                    $user_enabled = $user_row['enabled'];
    
                    // if user is disabled, reenable account and add 'just_reenabled' boolean to user session
                    if ($user_enabled == 0) {
                        // make the user enabled
                        $enable_query = $connection->prepare("UPDATE users SET enabled = 1 WHERE id = ?;");
                        $enable_query->bind_param("i", $user_id);
                        $enable_query->execute();
    
                        // add 'just_reenabled = true' to the session
                        $_SESSION['just_reenabled'] = 1;
                    } else {
                        $_SESSION['just_reenabled'] = 0;
                    }
                    
                    // echo $user_id;
                    // echo $user_enabled;
                    // echo $user_row;
                    
                    // start session and save some stuff to it.
                    session_start();
                    $_SESSION['just_reenabled'] = false;
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $username;
                    $_SESSION['fname'] = $fname;
                    $login_time = date("Y-m-d H:i:s");
                    $_SESSION['login_time'] = $login_time;
                    $session_id = session_id();
    
                    // clear error message
                    unset($_SESSION['error_msg']);

                    // redirect to dashboard
                    header("Location: ../dashboard.php");
                } else {
                    // redirect to home page with an error message
                    session_start();
                    $_SESSION['error_msg'] = "Incorrect password.";
                    header("Location: ../index.php");
                }
            }
        }
    }
?>