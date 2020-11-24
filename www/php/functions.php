<?php
    /*
        File: functions.php
        Author: Sam Klop - https://github.com/samklop

        Description:
        This file contains all the functions used within this project.
    */

    class general {
        public static function start() {
            if(!cookies::isDarkthemeSet() || !cookies::getDarkthemeSetting())
                cookies::setLightthemeSetting();
            else
                cookies::setDarkThemeSetting();
        }
    }

    class config {
        public static function getYtConfig() {
            $ini = (object) parse_ini_file('../config.ini', true);
            $config = $ini->youtube;

            return (object) $config;
        }

        public static function getDBConfig() {
            $ini = (object) parse_ini_file('../config.ini', true);
            $config = $ini->database;

            return (object) $config;
        }
    }

    class video {
        public static function getSingleEntry($key = null) {
            if($key !== null) {
                $config = config::getDBConfig();
                $mysqli = new mysqli($config->db_host, $config->db_user, $config->db_pass, $config->db_name);
                if(!mysqli_connect_errno()) {
                    if($stmt = $mysqli->prepare("SELECT song_title, artist_name, playback_id FROM videos WHERE id = ?")) {
                        $stmt->bind_param("s", $key);

                        $stmt->execute();

                        $stmt->bind_result($title, $name, $id);

                        $stmt->store_result();

                        $stmt->fetch();

                        if($stmt->num_rows != 0) {
                            $result = [$title, $name, $id];
                        } else {
                            $result = false;
                        }
                        $stmt->close();
                    }
                    $mysqli->close();
                    return $result;
                }
                echo "Connect failed" . mysqli_connect_error();
            }
        }

        public static function getAllEntries() {
            $config = config::getDBConfig();
            $mysqli = new mysqli($config->db_host, $config->db_user, $config->db_pass, $config->db_name);

            if(!mysqli_connect_errno()) {
                if($stmt = $mysqli->prepare("SELECT id, song_title, artist_name, playback_id FROM videos")) {
                    $stmt->bind_result($id, $title, $name, $playback_id);

                    $stmt->execute();

                    $stmt->store_result();

                    $resultArray = [];
                    if($stmt->num_rows != 0) {
                        while($stmt->fetch()) {
                            array_push($resultArray, [$id, $title, $name, $playback_id]);
                        }
                    }
                    $stmt->close();
                }
                $mysqli->close();
                return $resultArray;
            }
            echo "Connect failed" . mysqli_connect_error();
        }

        public static function searchEntries($term) {
            $config = config::getDBConfig();
            $mysqli = new mysqli($config->db_host, $config->db_user, $config->db_pass, $config->db_name);
            $searchTerm = "%" . $term . "%";

            if(!mysqli_connect_errno()) {
                if($stmt = $mysqli->prepare("SELECT id, song_title, artist_name, playback_id FROM videos WHERE song_title LIKE ? OR artist_name LIKE ?")) {
                    $stmt->bind_param("ss", $searchTerm, $searchTerm);

                    $stmt->execute();

                    $stmt->bind_result($id, $title, $name, $playback_id);

                    $stmt->store_result();

                    $resultArray = [];
                    if($stmt->num_rows != 0) {
                        while($stmt->fetch()) {
                            array_push($resultArray, [$id, $title, $name, $playback_id]);
                        }
                    }
                    $stmt->close();
                }
                $mysqli->close();
                return $resultArray;
            }
            echo "Connect failed" . mysqli_connect_error();
        }
    }

    class youtube {
        public static function checkIfVideoExists ($id) {
            $url = "https://www.youtube.com/watch?v=" . $id;
            $file = file_get_contents($url);

            if (!$file)
                return false;

            $result = preg_match('/<title>(.*?)<\/title>/', $file, $matches);

            if (!$result)
                return false;

            $title = preg_replace('/\s+/', ' ', $matches[0]);
            $title = trim($title);

            if ($title !== "YouTube")
                return true;
        }
    }

    class form {
        public static function handleAdminInput($title, $artist, $id) {
            if(youtube::checkIfVideoExists($id)) {
                $config = config::getDBConfig();

                $mysqli = new mysqli($config->db_host, $config->db_user, $config->db_pass, $config->db_name);

                if(!mysqli_connect_errno()) {
                    if($stmt = $mysqli->prepare("INSERT INTO videos (song_title, artist_name, playback_id) VALUES (?, ?, ?)")) {
                        $stmt->bind_param("sss", $title, $artist, $id);

                        $stmt->execute();

                        $stmt->close();
                    }
                    $mysqli->close();
                    return true;
                }
                echo "Connect failed" . mysqli_connect_error();
                return false;
            }
            return false;
        }
    }

    class cookies {
        public static function isDarkthemeSet() {
            if (isset($_COOKIE['darktheme']))
                return true;

            return false;
        }
        public static function getDarkthemeSetting() {
            if(isset($_COOKIE['darktheme']) && $_COOKIE['darktheme'] === "1")
                return true;

            return false;
        }

        public static function setLightthemeSetting() {
            setcookie("darktheme", "0", time() + 86400, "/");
        }

        public static function setDarkThemeSetting() {
            setcookie("darktheme", "1", time() + 86400, "/");
        }
    }
?>
