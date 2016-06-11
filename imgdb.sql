--
-- Datenbank: `imgdb`
--

CREATE DATABASE IF NOT EXISTS imgdb CHARACTER SET 'utf8mb4';
USE imgdb;

CREATE USER 'imgdb'@'localhost' IDENTIFIED BY '';

GRANT SELECT, DELETE, UPDATE, INSERT ON imgdb.* TO 'imgdb'@'localhost';

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `gallery_id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `private` tinyint DEFAULT NULL,
  FOREIGN KEY (id_user) REFERENCES User(user_id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `image_id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_gallery` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `file_path` varchar(200) DEFAULT NULL,
  FOREIGN KEY (id_gallery) REFERENCES Gallery(gallery_id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `tag_id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image_tag`
--

CREATE TABLE IF NOT EXISTS `image_tag` (
  `image_tag_id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_image` int(11) DEFAULT NULL,
  `id_tag` int(11) DEFAULT NULL,
  FOREIGN KEY (id_image) REFERENCES Image(image_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_tag) REFERENCES Tag(tag_id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------


INSERT INTO User (nickname, email, password) VALUES('gibbixer', 'test@gibb.ch', '$2y$10$zQdpVZEwA2EL5Q/8hQPO8OnSV5krrz67khYpVZhZbaNcVDyeJjT02');
