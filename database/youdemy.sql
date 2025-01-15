
DROP DATABASE IF EXISTS `you_demy`;
CREATE DATABASE IF NOT EXISTS `you_demy` 

USE `you_demy`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int   AUTO_INCREMENT PRIMARY KEY,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password_hash` varchar(200) NOT NULL,
  `profil` varchar(50) NOT NULL,
  `tele` int NOT NULL,
  `role` enum('etudiants','enseigants','visiteur') DEFAULT ('visiteur')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int  not  NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int  AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `contenu` varchar(200) NOT NULL,
  `id_categories` int DEFAULT NULL,
  Foreign Key (id_categories) REFERENCES categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `cours_tags`;
CREATE TABLE IF NOT EXISTS `cours_tags` (
  `id_cours` int,
  Foreign Key (id_cours) REFERENCES cours(id),
  
  `id_tags` int,
  Foreign Key (id_tags) REFERENCES tags(id),
  PRIMARY KEY (id_cours,id_tags)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `enseiganments`;
CREATE TABLE IF NOT EXISTS `enseiganments` (
  `id_enseigant` int  ,
  `id_cours` int ,
  Foreign Key (id_enseigant) REFERENCES users(id),
   Foreign Key (id_cours) REFERENCES cours(id),
   PRIMARY KEY (id_enseigant,id_cours),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `id_etudiants` int  ,
  `id_cours` int  ,
  Foreign Key (id_etudiants) REFERENCES users(id),
  Foreign Key (id_cours) REFERENCES cours(id),
  `note` varchar(50),
  PRIMARY KEY(id_etudiants,id_cours)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



