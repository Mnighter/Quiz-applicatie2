-- Maak de database aan
CREATE DATABASE IF NOT EXISTS `quiz-applicatie`;
USE `quiz-applicatie`;

-- Tabel voor de quizvragen
CREATE TABLE IF NOT EXISTS `questions` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `question` VARCHAR(255) NOT NULL,
    `choices` TEXT NOT NULL, -- Opslaan als JSON voor meerdere keuzes
    `answer` VARCHAR(255) NOT NULL,
    `type` ENUM('multiple-choice', 'open') NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel voor gebruikersresultaten (optioneel)
CREATE TABLE IF NOT EXISTS `results` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_name` VARCHAR(100) NOT NULL,
    `score` INT(11) NOT NULL,
    `total_questions` INT(11) NOT NULL,
    `percentage` DECIMAL(5,2) NOT NULL,
    `quiz_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Voeg voorbeeldvragen toe (optioneel)
INSERT INTO `questions` (`question`, `choices`, `answer`, `type`) VALUES
('Wat is de hoofdstad van Frankrijk?', '["Berlijn", "Londen", "Parijs", "Madrid"]', 'Parijs', 'multiple-choice'),
('Welke taal is het meest gebruikt voor web development?', '["Python", "JavaScript", "C++", "Java"]', 'JavaScript', 'multiple-choice'),
('Wie schreef "To Kill a Mockingbird"?', '["Harper Lee", "J.K. Rowling", "F. Scott Fitzgerald", "Ernest Hemingway"]', 'Harper Lee', 'multiple-choice'),
('Wat is de hoofdstad van Turkije?', NULL, 'Ankara', 'open');
