<?php
    $servername = "localhost";
    $dbusername = "myuser";
    $dbpassword = "mypass";
    $dbname = "mydb";
    return $connection = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
?>