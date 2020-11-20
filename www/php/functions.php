<?php
    /*
        File: functions.php
        Author: Sam Klop - https://github.com/samklop

        Description:
        This file contains all the functions used within this project.
    */

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
    }

    class form {
        public static function handleAdminInput($title, $artist, $id) {
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
    }
?>
