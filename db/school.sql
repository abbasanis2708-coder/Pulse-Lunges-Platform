-- 1. SUPPRESSION ET CRÉATION DE LA STRUCTURE COMPLÈTE
SET NAMES utf8mb4;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `admin_`;
DROP TABLE IF EXISTS `cours`;
DROP TABLE IF EXISTS `cours_audio`;
DROP TABLE IF EXISTS `demande_student`;
DROP TABLE IF EXISTS `qst_quiz_1`;
DROP TABLE IF EXISTS `qst_quiz_2`;
DROP TABLE IF EXISTS `qst_quiz_3`;
DROP TABLE IF EXISTS `quiz1`;
DROP TABLE IF EXISTS `quiz2`;
DROP TABLE IF EXISTS `quiz3`;
DROP TABLE IF EXISTS `quiz_audio`;
DROP TABLE IF EXISTS `quiz_resultat1`;
DROP TABLE IF EXISTS `quiz_resultat2`;
DROP TABLE IF EXISTS `quiz_resultat3`;
DROP TABLE IF EXISTS `student`;
DROP TABLE IF EXISTS `teacher`;

CREATE TABLE `admin_` (`id` int NOT NULL AUTO_INCREMENT, `name` varchar(255) NOT NULL, `email` varchar(255) NOT NULL, `password` varchar(255) NOT NULL, `date_of_birth` date NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `teacher` (`teacher_id` int NOT NULL AUTO_INCREMENT, `name` varchar(255) NOT NULL, `email` varchar(255) NOT NULL, `password` varchar(255) NOT NULL, `date_of_birth` date DEFAULT NULL, PRIMARY KEY (`teacher_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `student` (`student_id` int NOT NULL AUTO_INCREMENT, `name` varchar(255) NOT NULL, `email` varchar(255) NOT NULL, `password` varchar(255) NOT NULL, `date_of_birth` date DEFAULT NULL, PRIMARY KEY (`student_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `cours` (`cours_id` int NOT NULL AUTO_INCREMENT, `nom_cours` varchar(255), `teacher_id` int, `description` longtext, PRIMARY KEY (`cours_id`), FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `cours_audio` (`cours_id` int, `audio_file` varchar(255), FOREIGN KEY (`cours_id`) REFERENCES `cours` (`cours_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `quiz1` (`quiz1_id` int NOT NULL, `nom_quiz` varchar(255), `teacher_id` int, PRIMARY KEY (`quiz1_id`), FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `quiz2` (`quiz2_id` int NOT NULL, `nom_quiz` varchar(50), `teacher_id` int, PRIMARY KEY (`quiz2_id`), FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `quiz3` (`quiz3_id` int NOT NULL AUTO_INCREMENT, `nom_quiz` varchar(255), `teacher_id` int, `description` text, `tentative_max` int DEFAULT 5, `diagnostic_final` text, PRIMARY KEY (`quiz3_id`), FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `qst_quiz_1` (`qst_id` int NOT NULL AUTO_INCREMENT, `quiz1_id` int, `n_question` int, `question_text` text, `option_1` text, `option_2` text, `option_3` text, `option_4` text, `audio_file` varchar(255), `cas_clinique` text, PRIMARY KEY (`qst_id`), FOREIGN KEY (`quiz1_id`) REFERENCES `quiz1` (`quiz1_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `qst_quiz_2` (`qst_id` int NOT NULL AUTO_INCREMENT, `quiz2_id` int, `n_question` int, `question_text` text, `option_1` varchar(255), `option_2` varchar(255), `option_3` varchar(255), `option_4` varchar(255), `cas_clinique` text, `age` int, `sexe` varchar(10), `condition_physique` varchar(255), `examen` text, `diagnostics_passes_et_actuels` text, `poids` decimal(5,2), `masse_corporelle` decimal(5,2), `frequence_cardiaque` int, `fonction_cardiaque` varchar(255), `lieu_l_auscultation_cardiaque` varchar(255), `antecedents_medicaux_familiaux` text, `option_correct` int, PRIMARY KEY (`qst_id`), FOREIGN KEY (`quiz2_id`) REFERENCES `quiz2` (`quiz2_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `qst_quiz_3` (`id_cas` int NOT NULL AUTO_INCREMENT, `quiz3_id` int NOT NULL, `theme` varchar(255), `question` text, `reponse_modele` text, PRIMARY KEY (`id_cas`), FOREIGN KEY (`quiz3_id`) REFERENCES `quiz3` (`quiz3_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `quiz_resultat1` (`quiz1_id` int, `student_id` int, `resultat` decimal(5,2), `question_correct` int, `question_incorrect` int, FOREIGN KEY (`quiz1_id`) REFERENCES `quiz1` (`quiz1_id`), FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `quiz_resultat2` (`quiz2_id` int, `student_id` int, `resultat` decimal(5,2), `question_correct` int, `question_incorrect` int, FOREIGN KEY (`quiz2_id`) REFERENCES `quiz2` (`quiz2_id`), FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `quiz_resultat3` (`quiz3_id` int NOT NULL, `student_id` int NOT NULL, `question_posee` text, `theme_revele` varchar(255), `diagnostic` text, `resultat` float, `date_de_passage` timestamp DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`quiz3_id`, `student_id`), FOREIGN KEY (`quiz3_id`) REFERENCES `quiz3` (`quiz3_id`), FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `quiz_audio` (`quiz2_id` int, `qst_id` int, `audio_file` varchar(255), FOREIGN KEY (`quiz2_id`) REFERENCES `quiz2` (`quiz2_id`), FOREIGN KEY (`qst_id`) REFERENCES `qst_quiz_2` (`qst_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `demande_student` (`id` int NOT NULL AUTO_INCREMENT, `name` varchar(255) NOT NULL, `email` varchar(255) NOT NULL, `password` varchar(255) NOT NULL, `date_of_birth` date NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. INSERTION DONNÉES TÉMOINS
INSERT INTO `teacher` (`teacher_id`, `name`, `email`, `password`) VALUES (1, 'Dr. Enseignant', 'prof@faculte.edu', 'pass');
INSERT INTO `student` (`student_id`, `name`, `email`, `password`) VALUES (19650, 'Étudiant Test', 'etudiant@faculte.edu', 'pass');
INSERT INTO `admin_` (`name`, `email`, `password`, `date_of_birth`) VALUES ('Admin', 'admin@admin.edu', 'admin', '1990-01-01');

-- Quiz 1 : QCM Audio
INSERT INTO `quiz1` (`quiz1_id`, `nom_quiz`, `teacher_id`) VALUES (1, 'QCM Cardiologie de base', 1);
INSERT INTO `qst_quiz_1` (`quiz1_id`, `n_question`, `question_text`, `option_1`, `option_2`, `option_3`, `option_4`, `audio_file`) VALUES
(1, 1, 'Quel souffle est entendu sur ce tracé audio ?', 'Rétrécissement aortique', 'Insuffisance mitrale', 'Communication interauriculaire', 'Normal', 'auscultation_test.mp3');

-- Quiz 2 : Examen Clinique
INSERT INTO `quiz2` (`quiz2_id`, `nom_quiz`, `teacher_id`) VALUES (1, 'Examen Clinique Cardiologique', 1);
INSERT INTO `qst_quiz_2` (`quiz2_id`, `n_question`, `question_text`, `option_1`, `option_2`, `option_3`, `option_4`, `cas_clinique`, `option_correct`) VALUES
(1, 1, 'Quelle est la tension artérielle cible pour ce patient ?', '120/80 mmHg', '140/90 mmHg', '160/100 mmHg', '110/70 mmHg', 'Patient hypertendu de 60 ans', 1);

-- Quiz 3 : Cas Clinique (Simulation Dialogue)
INSERT INTO `quiz3` (`quiz3_id`, `nom_quiz`, `teacher_id`, `diagnostic_final`) VALUES (1, 'Douleur Thoracique - Simulation', 1, 'Angor d’effort stable.');
INSERT INTO `qst_quiz_3` (`quiz3_id`, `theme`, `question`, `reponse_modele`) VALUES
(1, 'douleur thoracique', '["Pouvez-vous décrire la douleur ?"]', '["C’est comme un poids ou une gêne au milieu de la poitrine."]'),
(1, 'facteurs déclenchants', '["Que faisiez-vous quand la douleur a commencé ?"]', '["Je montais les escaliers quand ça a commencé."]'),
(1, 'facteurs calmants', '["Qu’est-ce qui soulage la douleur ?"]', '["Quand je m\'arrête et que je me repose, la douleur passe."]'),
(1, 'irradiation', '["La douleur se propage-t-elle ailleurs ?"]', '["Oui, parfois ça va dans le bras gauche."]'),
(1, 'durée', '["Combien de temps dure chaque épisode de douleur ?"]', '["Ça dure quelques minutes, peut-être cinq"]');

