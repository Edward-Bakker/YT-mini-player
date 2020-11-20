SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Compatible with newer MySQL versions. (After MySQL-5.5)
-- This SQL uses utf8mb4 and has CURRENT_TIMESTAMP function.
--

--
-- Creates database `ytminiplayer` unless it already exists and uses `ytminiplayer`
-- Default Schema
--

CREATE DATABASE IF NOT EXISTS `ytminiplayer` DEFAULT CHARACTER SET utf8mb4;
USE `ytminiplayer`;

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
    `id`                        INT NOT NULL AUTO_INCREMENT,
    `song_title`                VARCHAR(64) NOT NULL,
    `artist_name`               VARCHAR(64) NOT NULL,
    `playback_id`               VARCHAR(16) NOT NULL,

    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
--
-- Creates default user `ytminiplayer_user` with password `changeme` unless it already exists
-- Granting permissions to user `ytminiplayer_user`, created below
-- Reloads the privileges from the grant tables in the MySQL system database.
--

CREATE USER IF NOT EXISTS `ytminiplayer_user`@`localhost` IDENTIFIED BY 'changeme';
GRANT SELECT, UPDATE, INSERT ON `ytminiplayer`.* TO 'ytminiplayer_user'@'localhost';
FLUSH PRIVILEGES;
