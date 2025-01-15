
DROP DATABASE IF EXISTS `you_demy`;
CREATE DATABASE IF NOT EXISTS `you_demy` 

USE `you_demy`;


DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `fullname` VARCHAR(200) NOT NULL,
  `email` VARCHAR(200) NOT NULL UNIQUE,
  `phone` VARCHAR(20),
  `password` VARCHAR(200) NOT NULL,
  `bio` TEXT,
  `profil_img_url` VARCHAR(255),
  `status` ENUM('active', 'inactive') DEFAULT 'inactive',
  `role` ENUM('etudiant', 'enseignant', 'admin') DEFAULT 'etudiant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE users 
MODIFY role ENUM('etudiant', 'enseignant', 'admin') DEFAULT 'etudiant';

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL,
  `description` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `description` TEXT NOT NULL,
  `contenu` TEXT NOT NULL,
  `category_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('draft', 'published') DEFAULT 'draft',
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `cours_tags`;
CREATE TABLE IF NOT EXISTS `cours_tags` (
  `cours_id` INT NOT NULL,
  `tag_id` INT NOT NULL,
  PRIMARY KEY (`cours_id`, `tag_id`),
  FOREIGN KEY (`cours_id`) REFERENCES `cours`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `enseignant`;
CREATE TABLE IF NOT EXISTS `enseignant` (
  `enseignant_id` INT NOT NULL,
  `cours_id` INT NOT NULL,
  PRIMARY KEY (`enseignant_id`, `cours_id`),
  FOREIGN KEY (`enseignant_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`cours_id`) REFERENCES `cours`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `date_inscription` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `etudiant_id` INT NOT NULL,
  `cours_id` INT NOT NULL,
  PRIMARY KEY (`etudiant_id`, `cours_id`),
  FOREIGN KEY (`etudiant_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`cours_id`) REFERENCES `cours`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



