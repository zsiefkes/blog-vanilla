<?php
    // check for existing session and redirect to login page if session variables aren't set
    if (!isset($_SESSION)) {
        session_start();
        if (!array_key_exists('username', $_SESSION)) {
            header("Location: /blog1/index.php");
        }
    } else {
        header("Location: /blog1/index.php");
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Blog</title>
</head>
<body>
    <?php
        // $date = date_create('2000-01-01');
        // echo date_format($date, 'Y-m-d H:i:s');
        // $timestamp = date("Y-m-d H:i:s");
        // echo $timestamp;
        // um check if a user is logged in... we only get the dashboard if we're logged in... right?
        // so ..................... how tf we do this lol
        // session_start();
        $fname = $_SESSION['fname'];
        $username = $_SESSION['username'];
        // echo $fname, $username;
    ?>
    <!-- a logout button belongs in the nav.... -->
    <nav>
        <ul>
            <li><a href="/blog1/dashboard.php">Home</a></li>
            <li><a href="/blog1/session/end.php">Logout</a></li>
        </ul>
    </nav>
    <section>
        <h2>What's on your mind, <?= $fname ?>?</h2>
        <p class="char-remaining">
            Characters: <span id="char-remaining-count"></span>
        </p>
        <form action="post/create.php" method="post">
            <textarea name="body" class="post-textarea" cols="60" rows="10"></textarea>
            <button type="submit" class="submit-button">Submit</button>
        </form>
    </section>
    <?php 
        $servername = "localhost";
        $username = "myuser";
        $password = "mypass";
        $dbname = "mydb";
        // $conn = mysqli_connect(, "myuser", "mypass", "mydb");
        // $connection = new mysqli($servername, $username, $password, $dbname);
        $connection = mysqli_connect($servername, $username, $password, $dbname);
        // check connection
        // if (!$connection) {
        //     die("Connection failed: " . mysqli_connect_error());
        // }

        ?>
    <section>
        <h2>Posts</h2>
        <div id="posts-list"></div>
        <?php
            // query table
            $result = mysqli_query($connection, "SELECT * FROM posts ORDER BY timestamp DESC;");
            // order by timestamp desc returns posts in ascending order i.e. with most recent post first.
            foreach ($result as $row) { ?>
            <!-- // for ($i = count($result); $i > -1; $i--) { ?> -->
                <div class="post-container">
                    <!-- <div> -->
                        <span class="timestamp">Posted at: <?= $row['timestamp'] ?></span>
                    <!-- </div> -->
                    <p>
                        <?= $row['body']; ?>
                        <!-- // $result[$i]['body'];  -->
                    </p>
                </div>
            <?php }
        ?>
        <!-- <div class="post-container">
            <div>
                Posted at: ....
            </div>
            <p>
                The post stuff...
            </p>
        </div> -->
    </section>    
    <script src="script.js"></script>    
</body>
</html>