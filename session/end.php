<?php
    // how do we close a user session? just reset the session variables? :S
    if (!isset($_SESSION)) {
        session_start();
    }
    session_unset();
    session_destroy();
    $_SESSION = array();
    // echo $_SESSION['username'];
    // If it's desired to kill the session, also 
    // delete the session cookie. 
    // Note: This will destroy the session, and 
    // not just the session data! 
    // if (ini_get("session.use_cookies")) { 
    //     $params = session_get_cookie_params(); 
    //     setcookie(session_name(), '', time() - 42000, 
    //         $params["path"], $params["domain"], 
    //         $params["secure"], $params["httponly"] 
    //     ); 
    // } 
    header("Location: /blog1/index.php");
?>