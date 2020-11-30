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
            $query->bind_param("sss", $_REQUEST['username'], $_REQUEST['fname'], $pass_hash);
            $query->execute();
            $result = $query->get_result();
            // we're not doing anything with the result.... should I be checking it was like, um. what's the word. successful or some shit? yeah?
            // echo $result;
            session_start();
            // $_SESSION
            // $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['fname'] = $fname;
            header("Location: /blog1/dashboard.php");
        }
    }
    // echo $_REQUEST['username'];
?>