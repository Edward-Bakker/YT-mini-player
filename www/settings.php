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
            <div id="div-content-settings">
                <?php
                    if(isset($_POST['submit'])) {
                        $darktheme = filter_input(INPUT_POST, 'darkthemeInput', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                        if(isset($darktheme) && $darktheme[0] === "1") {
                            cookies::setDarkThemeSetting();
                        } else {
                            cookies::setLightthemeSetting();
                        }
                        header("location: settings.php", true, 303);
                    }
                ?>
                <h2>Settings</h2>
                <form action="settings.php" method="post">
                    <input class="checkbox" id="darkthemeInput" type="checkbox" name="darkthemeInput[]" value="1" <?php echo (cookies::getDarkthemeSetting()) ? 'checked' : ''?> >
                    <label for="darkthemeInput">Darktheme</label><br>

                    <input type="submit" name="submit" value="Submit">
                </form>
            </div>
        </main>
    </body>
</html>
