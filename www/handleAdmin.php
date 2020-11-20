<?php include 'php/functions.php'; ?>
<!doctype html>
<!--
    File: handleAdmin.php
    Author: Sam Klop - https://github.com/samklop

    Description:
    This file handles the admin input
-->
<html lang="en">
    <head>
        <title>YT Mini Player - Admin</title>
        <link rel='stylesheet' href='css/styles.css' type="text/css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <h1><a id="header-left" href="index.php">YouTube Mini Player</a></h1>
        </header>
        <main>
            <nav>
                <a href="index.php">Overview</a>
                <a href="admin.php">Admin</a>
            </nav>
            <div id="div-content-handleAdmin">
                <?php
                    if($_POST['submit']) {
                        $title = filter_input(INPUT_POST, 'titleInput', FILTER_SANITIZE_STRING);
                        $artist = filter_input(INPUT_POST, 'artistInput', FILTER_SANITIZE_STRING);
                        $videoID = filter_input(INPUT_POST, 'idInput', FILTER_SANITIZE_STRING);

                        if(!empty($title) && !empty($artist) && !empty($videoID)) {
                            if(!(strlen($title) > 60) && !(strlen($artist) > 60) && !(strlen($videoID) > 15) ) {
                                if(form::handleAdminInput($title, $artist, $videoID)) {
                                    echo "<h2>Your entry has been entered</h2>";
                                } else {
                                    echo "<h2>Something went wrong</h2>";
                                }
                            } else {
                                echo "<h2>One of your entries was too long</h2>";
                            }
                        } else {
                            echo "<h2>Please fill in all entries</h2>";
                        }
                    }
                ?>
            </div>
        </main>
    </body>
</html>
