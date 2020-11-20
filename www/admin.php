<?php include 'php/functions.php'; ?>
<!doctype html>
<!--
    File: admin.php
    Author: Sam Klop - https://github.com/samklop

    Description:
    The admin page of the yt mini player assignment, allows you to add new videos
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
            <div id="div-content-admin">
                <h2>Admin Page</h2>
                <form action="handleAdmin.php" method="post">
                    <label for="titleInput">Title</label>
                    <input class="inputbox" id="titleInput" type="text" name="titleInput" placeholder="Title" required>

                    <label for="artistInput">Artist</label>
                    <input class="inputbox" id="artistInput" type="text" name="artistInput" placeholder="Artist" required>

                    <label for="idInput">ID</label>
                    <input class="inputbox" id="idInput" type="text" name="idInput" placeholder="ID" required>

                    <input type="submit" name="submit" value="Submit">
                </form>
            </div>
        </main>
    </body>
</html>
