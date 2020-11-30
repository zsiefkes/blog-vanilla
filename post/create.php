<?php
    $connection = new mysqli("localhost", "myuser", "mypass", "mydb");

    if (isset($_REQUEST['body'])) {
        if ($_REQUEST['body'] === '') {
            // don't save empty post. redirect
            header("Location: /blog1/index.php");
        } else {
            $body = $_REQUEST['body'];
            if (count($body) > 499) {
                $body = substr($body, 0, 499);
            }
            $timestamp = date("Y-m-d H:i:s");
            $query = $connection->prepare("INSERT INTO posts VALUES (?, ?) ;");
            $query->bind_param("ss", $_REQUEST['body'], $timestamp);
            $query->execute();
            $result = $query->get_result();
            header("Location: /blog1/dashboard.php");
        }
    }
    // echo $_REQUEST['body'];
?>