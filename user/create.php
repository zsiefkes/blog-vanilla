<?php
    $connection = new mysqli("localhost", "myuser", "mypass", "mydb");

    if (isset($_REQUEST['username'])) {
        if ($_REQUEST['username'] === '') {
            // don't save empty post. redirect
            header("Location: /blog1/index.php");
        } else {
            $username = $_REQUEST['username'];
            $fname = $_REQUEST['fname'];
            // $timestamp = date("Y-m-d H:i:s");
            $pass_hash = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
            
            $query = $connection->prepare("INSERT INTO users (username, fname, password) VALUES (?, ?, ?) ;");
            $query->bind_param("sss", $username, $fname, $pass_hash);
            $query->execute();
            $result = $query->get_result();
            // we're not doing anything with the result.... should I be checking it was like, um. what's the word. successful or some shit? yeah?

            $user_query = $connection->prepare("SELECT * FROM users WHERE username = ?;");
            $user_query->bind_param("s", $username);
            $user_query->execute();
            $user_result = $user_query->get_result();
            // while ($row = $result->fetch_assoc()) {
                //     $password_hash = $row['password'];
                //     // printing result to check
                //     // echo $row['password']."<br>";
                // }
            $user_row = $user_result->fetch_assoc();
            $user_id = $user_row['id'];
            // $username = $user_row['username'];
            // $fname = $user_row['fname'];
            // $user_enabled = $user_row['enabled']; // 1 by default when you create a user

            // $_SESSION
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['fname'] = $fname;
            $_SESSION['just_reenabled'] = false;
            header("Location: /blog1/dashboard.php");
        }
    }
    // echo $_REQUEST['username'];
?>