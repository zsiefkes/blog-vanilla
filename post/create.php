<?php
    $connection = new mysqli("localhost", "myuser", "mypass", "mydb");

    if (isset($_REQUEST['body'])) {
        if ($_REQUEST['body'] === '') {
            // redirect if body was empty
            header("Location: /blog1/index.php");
        } else {
            $body = $_REQUEST['body'];
            // bit of testing here... want to see what values are coming through
            // foreach ($_REQUEST as $key => $value) {
            //     echo "$key: $value" ;
            // }
            // if my front-end character limiting code didn't work...
            $body = $_REQUEST['body'];
            if (strlen($body) > 499) {
                $body = substr($body, 0, 499);
            }
            $timestamp = date("Y-m-d H:i:s");
            $query = $connection->prepare("INSERT INTO posts VALUES (?, ?, ?) ;");
            $query->bind_param("ssi", $body, $timestamp, $_REQUEST['user_id']);
            $query->execute();
            $result = $query->get_result();
            header("Location: /blog1/dashboard.php");
        }
    }
    // echo $_REQUEST['body'];
?>