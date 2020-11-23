<?php
    include 'php/functions.php';
    general::start();
    $key = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
 ?>
<!doctype html>
<!--
    File: video.php
    Author: Sam Klop - https://github.com/samklop

    Description:
    The video page of the yt mini player assignment, allows you to view specific videos
-->
<html lang="en">
    <head>
        <title>YT Mini Player - Video <?php echo $key ?></title>
        <?php if(cookies::getDarkthemeSetting()): ?>
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
            <div id="div-content-video">
                <?php
                    $element = video::getSingleEntry($key);
                    $autoplay = config::getYtConfig()->autoplay;
                    if($element === false) {
                        header("location: index.php", true, 303);
                    }
                ?>
                <iframe src="https://www.youtube-nocookie.com/embed/<?php echo $element[2]?>?autoplay=<?php echo $autoplay?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <h2><?php echo $element[0]?></h2>
                <p><?php echo $element[1]?></p>
            </div>
        </main>
    </body>
</html>
