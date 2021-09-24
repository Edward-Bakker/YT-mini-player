<?php
    include 'php/functions.php';
    general::start();
?>
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
        <?php if(cookies::getSettingBool('darktheme')): ?>
            <link href="css/darkStyles.css" rel="stylesheet" type="text/css">
        <?php else: ?>
            <link href="css/styles.css" rel="stylesheet" type="text/css">
        <?php endif; ?>
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
                <a href="settings.php">Settings</a>
            </nav>
            <div id="div-content-handleAdmin">
                <?php
                    if($_POST['submit']) {
                        $title = filter_input(INPUT_POST, 'titleInput', FILTER_SANITIZE_SPECIAL_CHARS);
                        $artist = filter_input(INPUT_POST, 'artistInput', FILTER_SANITIZE_SPECIAL_CHARS);
                        $videoID = filter_input(INPUT_POST, 'idInput', FILTER_SANITIZE_SPECIAL_CHARS);

                        if(!empty($title) && !empty($artist) && !empty($videoID)) {
                            if(!(strlen($title) > 60) && !(strlen($artist) > 60) && !(strlen($videoID) > 15) ) {
                                if(form::handleAdminInput($title, $artist, $videoID)) {
                                    echo "<h2>Your entry has been entered</h2>";
                                    header("Refresh: 3; url=index.php", true, 303);
                                } else {
                                    echo "<h2>Something went wrong</h2>";
                                }
                            } else {
                                echo "<h2>One of your entries was too long</h2>";
                            }
                        } else {
                            $error = [];
                            if(empty($title))
                                array_push($error, "title");
                            if(empty($artist))
                                array_push($error, "artist");
                            if(empty($videoID))
                                array_push($error, "videoID");

                            echo "<h2>Please fill in " . implode(", ", $error) . ".</h2>";
                        }
                    }
                ?>
            </div>
        </main>
    </body>
</html>
