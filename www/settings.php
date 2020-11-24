<?php
    include 'php/functions.php';
    general::start();
?>
<!doctype html>
<!--
    File: settings.php
    Author: Sam Klop - https://github.com/samklop

    Description:
    The settings page of the yt mini player assignment, allows you to change your settings
-->
<html lang="en">
    <head>
        <title>YT Mini Player - Settings</title>
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
            <div id="div-content-settings">
                <?php
                    if(isset($_POST['submit'])) {
                        $darktheme = filter_input(INPUT_POST, 'darkthemeInput', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
                        $autoplay = filter_input(INPUT_POST, 'autoplayInput', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
                        if(isset($darktheme) && $darktheme[0] === "1")
                            cookies::setSetting('darktheme', '1');
                        else
                            cookies::setSetting('darktheme', '0');

                        if(isset($autoplay) && $autoplay[0] === "1")
                            cookies::setSetting('autoplay', '1');
                        else
                            cookies::setSetting('autoplay', '0');

                        header("location: settings.php", true, 303);
                    }
                ?>
                <h2>Settings</h2>
                <form action="settings.php" method="post">
                    <input class="checkbox" id="darkthemeInput" type="checkbox" name="darkthemeInput[]" value="1" <?php echo (cookies::getSettingBool('darktheme')) ? 'checked' : ''?> >
                    <label for="darkthemeInput">Darktheme</label><br>

                    <input class="checkbox" id="autoplayInput" type="checkbox" name="autoplayInput[]" value="1" <?php echo (cookies::getSettingBool('autoplay')) ? 'checked' : ''?> >
                    <label for="autoplayInput">Autoplay</label><br>

                    <input type="submit" name="submit" value="Save">
                </form>
            </div>
        </main>
    </body>
</html>
