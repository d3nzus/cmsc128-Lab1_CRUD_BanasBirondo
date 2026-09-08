SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS `128crud_db`;

CREATE DATABASE IF NOT EXISTS `128crud_db`;

USE `128crud_db`;

CREATE TABLE `category` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `trash_task` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `due_date` DATE NOT NULL,
  `due_time` TIME NOT NULL,
  `priority` ENUM('low', 'med', 'high') NOT NULL DEFAULT 'med',
  `category_id` INT UNSIGNED DEFAULT NULL,
  `done` BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (`id`),
  KEY `idx_trash_task_category` (`category_id`),
  CONSTRAINT `fk_trash_task_category` FOREIGN KEY (`category_id`)
    REFERENCES `category` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `task` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `due_date` DATE NOT NULL,
  `due_time` TIME NOT NULL,
  `priority` ENUM('low', 'med', 'high') NOT NULL DEFAULT 'med',
  `category_id` INT UNSIGNED DEFAULT NULL,
  `done` BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (`id`),
  KEY `fk_task_category` (`category_id`),
  CONSTRAINT `fk_task_category` FOREIGN KEY (`category_id`)
    REFERENCES `category` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Work'),
(2, 'Personal'),
(3, 'School'),
(4, 'Health'),
(5, 'Errands');


INSERT INTO `task` (`id`, `title`, `due_date`, `due_time`, `priority`, `category_id`, `done`) VALUES
(1, 'Finish quarterly report', '2026-09-10', '17:00:00', 'high', 1, FALSE),
(2, 'Buy groceries', '2026-09-08', '18:30:00', 'low', 5, FALSE),
(3, 'Study for database exam', '2026-09-12', '09:00:00', 'high', 3, FALSE),
(4, 'Doctor appointment', '2026-09-09', '10:15:00', 'med', 4, FALSE),
(5, 'Clean the apartment', '2026-09-13', '14:00:00', 'low', 2, FALSE),
(6, 'Submit project proposal', '2026-09-11', '23:59:00', 'high', 1, FALSE),
(7, 'Call mom', '2026-09-08', '20:00:00', 'med', 2, FALSE),
(8, 'Renew gym membership', '2026-09-15', '12:00:00', 'low', 4, FALSE);

COMMIT;