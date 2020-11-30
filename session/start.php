<?php
    $connection = new mysqli("localhost", "myuser", "mypass", "mydb");

    if (isset($_REQUEST['username'])) {
        if ($_REQUEST['username'] === '' || $_REQUEST['password'] === '') {
            // back to homepage
            header("Location: /blog1/index.php");
        } else {
            // grab password hash from the database corresponding to current user
            // note don't surround the question mark here with quotation marks else it won't see it as a parameter. :/
            $query = $connection->prepare("SELECT password FROM users WHERE username = ?;");
            $query->bind_param("s", $_REQUEST['username']);
            $query->execute();
            $result = $query->get_result();
            // while ($row = $result->fetch_assoc()) {
            //     $password_hash = $row['password'];
            //     // printing result to check
            //     // echo $row['password']."<br>";
            // }
            $row = $result->fetch_assoc();
            $password_hash = $row['password'];
            // check submitted password matches the hashed password...
            if (password_verify($_REQUEST['password'], $password_hash)) {
                echo 'true!';
                // oh my god holy fucking shit IT WORKS YESSSSSSSSSSSSSSSSSSSSSSS
                // okay now we need to start a session :S weird
                // start session and redirect to dashboard
                
                // grab user details... yeah?   
                $user_query = $connection->prepare("SELECT * FROM users WHERE username = ?;");
                $user_query->bind_param("s", $_REQUEST['username']);
                $user_query->execute();
                $user_result = $user_query->get_result();
                // while ($row = $result->fetch_assoc()) {
                    //     $password_hash = $row['password'];
                    //     // printing result to check
                    //     // echo $row['password']."<br>";
                    // }
                $user_row = $user_result->fetch_assoc();
                $user_id = $user_row['id'];
                $username = $user_row['username'];
                $fname = $user_row['fname'];
                $user_enabled = $user_row['enabled'];

                // if user is disabled, want to offer them option to reenable their account.
                // or maybe just do it automatically cause they trying to log in. maybe add a boolean to the session array about 'just_reenabled' or some shit and display welcome back, fname! on the dashboard if so
                if ($user_enabled == 0) {
                    // make the user enabled
                    $enable_query = $connection->prepare("UPDATE users SET enabled = 1 WHERE id = ?;");
                    $enable_query->bind_param("i", $user_id);
                    $enable_query->execute();

                    // add 'just_reenabled = true' to the session
                    $_SESSION['just_reenabled'] = true;
                } else {
                    $_SESSION['just_reenabled'] = false;
                }
                
                // echo $user_id;
                // echo $user_enabled;
                // echo $user_row;
                
                // start session and save some stuff to it?
                session_start();
                $_SESSION['just_reenabled'] = false;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['fname'] = $fname;
                $login_time = date("Y-m-d H:i:s");
                $_SESSION['login_time'] = $login_time;
                echo $_SESSION['login_time'];
                $session_id = session_id();
                // sid
                // session id is SID
                // save these things to the database....
                $session_query = $connection->prepare("INSERT INTO user_sessions (session_id, user_id, login_time) VALUES (?, ?, ?);");
                echo $session_id;
                echo $user_id;
                echo $login_time;
                $session_query->bind_param("sis", $session_id, $user_id, $login_time);
                $session_query->execute();  
                $session_result = $session_query->get_result();
                // $session_row = $session_result->fetch_assoc();
                // echo $session_row;
                
                // header("Location: /blog1/dashboard.php");

                    
                // we need to add a session to the db. what the actual fuck :S
                // if (session_status() == PHP_SESSION_ACTIVE) {
                // /* 	Use a REPLACE statement to:
                //     - insert a new row with the session id, if it doesn't exist, or...
                //     - update the row having the session id, if it does exist.
                // */
                // // $session_query = "REPLACE INTO user_sessions (session_id, user_id, login_time) VALUES (:sid, :accountId, NOW())";
                // $session_query = "REPLACE INTO user_sessions (session_id, user_id, login_time) VALUES (?, ?, NOW())";
                // $sesion_query->bind_param("ss", )
                // $values = array(':sid' => session_id(), ':accountId' => $this->id);
                
                header("Location: /blog1/dashboard.php");
            } else {
                echo 'no :(';
            }

            // $username = $_REQUEST['username'];
            // // $timestamp = date("Y-m-d H:i:s");



            // $hash_pass = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
            
            // // $query = $connection->prepare("INSERT INTO users (username, password) VALUES (?, ?) ;");
            // $query->bind_param("ss", $_REQUEST['username'], $hash_pass);
            // $query->execute();
            // $result = $query->get_result();
            // // we're not doing anything with the result.... should I be checking it was like, um. what's the word. successful or some shit? yeah?
            // // echo $result;
            // session_start();
            // // if successful ... 
            // header("Location: /blog1/dashboard.php");
        }
    } else {
        // check for existing session and grab info
        if (!isset($_SESSION)) { 
            session_start();
        }

    }
    // echo $_REQUEST['username'];
?>