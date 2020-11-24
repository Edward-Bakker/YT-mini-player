<?php
    include 'php/functions.php';
    general::start();
?>
<!doctype html>
<!--
    File: index.php
    Author: Sam Klop - https://github.com/samklop

    Description:
    The index page of the yt mini player assignment
-->
<html lang="en">
    <head>
        <title>YT Mini Player - Overview</title>
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
            <form action="index.php" method="post">
                <input class="inputbox" type="text" name="searchInput" placeholder="Searchterm">
                <input type="submit" name="submit" value="Search">
            </form>
        </header>
        <main>
            <nav>
                <a href="index.php">Overview</a>
                <a href="admin.php">Admin</a>
                <a href="settings.php">Settings</a>
            </nav>
            <div id="div-content">
                <?php
                    if(isset($_POST['submit'])) {
                        $searchTerm = filter_input(INPUT_POST, 'searchInput', FILTER_SANITIZE_STRING);
                        if(!empty($searchTerm)) {
                            $entries = video::searchEntries($searchTerm);
                        } else {
                            $entries = video::getAllEntries();
                        }
                    } else {
                        $entries = video::getAllEntries();
                    }
                    foreach($entries as $element): ?>
                        <div class="div-video">
                            <a href="video.php?id=<?php echo $element[0]; ?>"><span></span></a>
                            <div class="div-video-image">
                                <img src="https://img.youtube.com/vi/<?php echo $element[3]; ?>/mqdefault.jpg" alt="Youtube thumbnail">
                            </div>
                            <h2><?php echo $element[1]; ?></h2>
                            <p><?php echo $element[2]; ?></p>
                        </div>
                    <?php endforeach; ?>
            </div>
        </main>
    </body>
</html>
