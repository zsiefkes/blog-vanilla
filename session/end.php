<?php
    // how do we close a user session? just reset the session variables? :S
    if (!isset($_SESSION)) {
        session_start();
    }
    session_unset();
    session_destroy();
    $_SESSION = array();
    header("Location: ../index.php");
?>