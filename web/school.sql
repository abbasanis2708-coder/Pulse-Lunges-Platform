-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 10 juil. 2026 à 16:20
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `school`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_`
--

CREATE TABLE `admin_` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin_`
--

INSERT INTO `admin_` (`id`, `name`, `email`, `password`, `date_of_birth`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$MaNj43CTPqF4o9sK0jMfseop0BubBvqG9ptptJgK1YL7GN0UaxPWu', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `cours_id` int(11) NOT NULL,
  `nom_cours` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `description` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`cours_id`, `nom_cours`, `teacher_id`, `description`) VALUES
(8, 'COUR 1', 5, 'Pulse Lunges est une plateforme d&amp;#039;apprentissage auditif qui vous permet d&amp;#039;améliorer vos compétences et votre compréhension dans divers domaines grâce à des cours audio. Notre approche innovante combine l&amp;#039;écoute active et l&amp;#039;apprentissage interactif pour vous offrir une expérience d&amp;#039;apprentissage immersive et enrichissante.\r\n\r\nQue vous souhaitiez améliorer votre maîtrise d&amp;#039;une langue étrangère, acquérir de nouvelles connaissances dans un domaine spécifique ou simplement développer vos compétences personnelles, Pulse Lunges vous propose une sélection diversifiée de cours audio adaptés à vos besoins.\r\n\r\nChaque cours audio est conçu de manière professionnelle et couvre des sujets variés, allant de la littérature à la science, en passant par l&amp;#039;histoire, la musique et bien plus encore. Vous pouvez écouter les cours à votre rythme, où que vous soyez, en utilisant notre plateforme conviviale.\r\n\r\nNous croyons en l&amp;#039;apprentissage par l&amp;#039;écoute active, car cela vous permet de développer votre compréhension auditive, d&amp;#039;améliorer votre prononciation et d&amp;#039;élargir votre vocabulaire de manière naturelle. Les cours audio sont accompagnés de descriptions détaillées et d&amp;#039;exercices interactifs pour renforcer votre apprentissage et vous aider à progresser rapidement.\r\n\r\nRejoignez la communauté de Pulse Lunges et découvrez une nouvelle façon passionnante d&amp;#039;apprendre. Plongez-vous dans l&amp;#039;univers des cours audio et laissez votre esprit s&amp;#039;épanouir grâce à l&amp;#039;apprentissage auditif. Commencez dès aujourd&amp;#039;hui et ouvrez les portes d&amp;#039;un monde de connaissances et d&amp;#039;opportunités.'),
(9, 'cours 1', 8, 'Pulse Lunges est une plateforme d&amp;#039;apprentissage auditif qui vous permet d&amp;#039;améliorer vos compétences et votre compréhension dans divers domaines grâce à des cours audio. Notre approche innovante combine l&amp;#039;écoute active et l&amp;#039;apprentissage interactif pour vous offrir une expérience d&amp;#039;apprentissage immersive et enrichissante. Que vous souhaitiez améliorer votre maîtrise d&amp;#039;une langue étrangère, acquérir de nouvelles connaissances dans un domaine spécifique ou simplement développer vos compétences personnelles, Pulse Lunges vous propose une sélection diversifiée de cours audio adaptés à vos besoins. Chaque cours audio est conçu de manière professionnelle et couvre des sujets variés, allant de la littérature à la science, en passant par l&amp;#039;histoire, la musique et bien plus encore. Vous pouvez écouter les cours à votre rythme, où que vous soyez, en utilisant notre plateforme conviviale. Nous croyons en l&amp;#039;apprentissage par l&amp;#039;écoute active, car cela vous permet de développer votre compréhension auditive, d&amp;#039;améliorer votre prononciation et d&amp;#039;élargir votre vocabulaire de manière naturelle. Les cours audio sont accompagnés de descriptions détaillées et d&amp;#039;exercices interactifs pour renforcer votre apprentissage et vous aider à progresser rapidement. Rejoignez la communauté de Pulse Lunges et découvrez une nouvelle façon passionnante d&amp;#039;apprendre. Plongez-vous dans l&amp;#039;univers des cours audio et laissez votre esprit s&amp;#039;épanouir grâce à l&amp;#039;apprentissage auditif. Commencez dès aujourd&amp;#039;hui et ouvrez les portes d&amp;#039;un monde de connaissances et d&amp;#039;opportunités.'),
(10, 'cours 2', 8, 'dfjns&quot;&quot; &amp; &#039; &#039; &#039;dsvsd');

-- --------------------------------------------------------

--
-- Structure de la table `cours_audio`
--

CREATE TABLE `cours_audio` (
  `cours_id` int(11) DEFAULT NULL,
  `audio_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cours_audio`
--

INSERT INTO `cours_audio` (`cours_id`, `audio_file`) VALUES
(8, 'adultCASE1.mp3'),
(8, 'adultcase3a.mp3'),
(10, 'adultCASE1.mp3');

-- --------------------------------------------------------

--
-- Structure de la table `demande_student`
--

CREATE TABLE `demande_student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `qst_quiz_1`
--

CREATE TABLE `qst_quiz_1` (
  `qst_id` int(11) NOT NULL,
  `quiz1_id` int(11) DEFAULT NULL,
  `n_question` int(11) DEFAULT NULL,
  `question_text` text DEFAULT NULL,
  `option_1` text DEFAULT NULL,
  `option_2` text DEFAULT NULL,
  `option_3` text DEFAULT NULL,
  `option_4` text DEFAULT NULL,
  `audio_file` varchar(255) DEFAULT NULL,
  `cas_clinique` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `qst_quiz_1`
--

INSERT INTO `qst_quiz_1` (`qst_id`, `quiz1_id`, `n_question`, `question_text`, `option_1`, `option_2`, `option_3`, `option_4`, `audio_file`, `cas_clinique`) VALUES
(1, 1, 1, 'what is my name', 'abdessalem', 'yahia', 'ahmed', 'abderazak', 'adultCASE1.mp3', 'pnumo'),
(2, 1, 2, 'what is my age', '22', '21', '220', '200', 'adultcase3a.mp3', 'heart'),
(3, 1, 3, 'what is the date', '11', 'lkdsjv', 'skjv', 'sjdvlk', 'adultcase3a.mp3', 'kjkjkkj'),
(4, 2, 1, 'what is my name', 'abdessalem', 'yahia', 'ahmed', 'abderazak', 'adultcase3a.mp3', 'pnumo'),
(5, 2, 2, 'what is my username', '22', '21', '220', '200', 'adultcase3a.mp3', 'heart'),
(7, 3, 1, 'Quel symptôme est le plus typiquement associé à l’angine de poitrine (angor) ?', 'Douleur thoracique qui survient à l&#039;effort et disparaît au repos', 'Douleur aiguë localisée à un point précis de la poitrine', 'Douleur thoracique augmentée à la palpation', 'Douleur thoracique soulagée par le changement de position', 'adultCASE1.mp3', 'Depuis environ 3 mois, le patient décrit une douleur rétrosternale survenant lors d’efforts modérés (ex. : monter une côte ou porter des courses). La douleur est décrite comme une sensation de serrement ou de poids, irradiant parfois dans le bras gauche. Elle disparaît au repos après quelques minutes. Pas de douleur au repos, ni la nuit. Pas de dyspnée ni de palpitations associées.');

-- --------------------------------------------------------

--
-- Structure de la table `qst_quiz_2`
--

CREATE TABLE `qst_quiz_2` (
  `qst_id` int(11) NOT NULL,
  `quiz2_id` int(11) DEFAULT NULL,
  `n_question` int(11) DEFAULT NULL,
  `question_text` text DEFAULT NULL,
  `option_1` varchar(255) DEFAULT NULL,
  `option_2` varchar(255) DEFAULT NULL,
  `option_3` varchar(255) DEFAULT NULL,
  `option_4` varchar(255) DEFAULT NULL,
  `cas_clinique` text DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sexe` varchar(10) DEFAULT NULL,
  `condition_physique` varchar(255) DEFAULT NULL,
  `examen` text DEFAULT NULL,
  `diagnostics_passes_et_actuels` text DEFAULT NULL,
  `poids` decimal(5,2) DEFAULT NULL,
  `masse_corporelle` decimal(5,2) DEFAULT NULL,
  `frequence_cardiaque` int(11) DEFAULT NULL,
  `fonction_cardiaque` varchar(255) DEFAULT NULL,
  `lieu_l_auscultation_cardiaque` varchar(255) DEFAULT NULL,
  `antecedents_medicaux_familiaux` text DEFAULT NULL,
  `option_correct` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `qst_quiz_2`
--

INSERT INTO `qst_quiz_2` (`qst_id`, `quiz2_id`, `n_question`, `question_text`, `option_1`, `option_2`, `option_3`, `option_4`, `cas_clinique`, `age`, `sexe`, `condition_physique`, `examen`, `diagnostics_passes_et_actuels`, `poids`, `masse_corporelle`, `frequence_cardiaque`, `fonction_cardiaque`, `lieu_l_auscultation_cardiaque`, `antecedents_medicaux_familiaux`, `option_correct`) VALUES
(1, 1, 1, 'what is my name', 'abdessalem', 'yahia', 'yacine', 'abderazak', 'pnumo', 22, 'homme', 'actif', 'Normal', 'nice', 120.00, 230.00, 12, '11', '20', '11', 2),
(2, 1, 2, 'what is my age', '22', '21', 'yzid', '200', 'heart', 12, 'homme', 'actif', 'Normal', 'lkdsj', 120.00, 23.00, 10, '11', '01', 'nice', 1),
(3, 2, 1, 'what is my name', 'abdessalem', 'yahia', 'ahmed', 'abderazak', 'pnumo', 22, 'homme', 'actif', 'Normal', 'nice', 120.00, 230.00, 12, '11', '20', '11', 2),
(4, 3, 1, 'azeaez', 'azeae', 'azeaea', 'eazeazeza', 'dfsfsd', 'dfsdfsf', 0, 'femme', 'calme', 'Normal', 'sdfdsvdxv', 0.00, 0.00, 0, 'dfvdfvcx', 'vfdbfg', 'fbdvdfv', 0);

-- --------------------------------------------------------

--
-- Structure de la table `qst_quiz_3`
--

CREATE TABLE `qst_quiz_3` (
  `id_cas` int(11) NOT NULL,
  `quiz3_id` int(11) NOT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `reponse_modele` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `qst_quiz_3`
--

INSERT INTO `qst_quiz_3` (`id_cas`, `quiz3_id`, `theme`, `question`, `reponse_modele`) VALUES
(44, 45, 'douleur thoracique', '[\n    \"Pouvez-vous décrire la douleur ?\"\n]', '[\n    \"C’est comme un poids ou une gêne au milieu de la poitrine.\"\n]'),
(45, 45, 'facteurs déclenchants', '[\n    \"Que faisiez-vous quand la douleur a commencé ?\"\n]', '[\n    \"Je montais les escaliers quand ça a commencé\"\n]'),
(46, 45, 'facteurs calmants', '[\n    \"Qu’est-ce qui soulage la douleur ?\"\n]', '[\n    \"Quand je m\'arrête et que je me repose, la douleur passe.\"\n]'),
(47, 45, 'irradiation', '[\n    \"La douleur se propage-t-elle ailleurs ?\"\n]', '[\n    \"Oui, parfois ça va dans le bras gauche.\"\n]'),
(48, 45, 'durée', '[\n    \"Combien de temps dure chaque épisode de douleur ?\"\n]', '[\n    \"Ça dure quelques minutes, peut-être cinq\"\n]'),
(58, 48, 'douleur thoracique', '[\n    \"Qu\'est-ce qui vous a amenée à consulter ?\"\n]', '[\n    \"Une douleur dans la poitrine, comme une oppression\"\n]'),
(59, 48, 'facteurs déclenchants', '[\n    \"À quel moment ressentez-vous cela ?\"\n]', '[\n    \"Quand je monte les escaliers\"\n]'),
(60, 48, 'durée', '[\n    \"Depuis combien de temps avez-vous ce problème ?\"\n]', '[\n    \"Depuis trois jours.\"\n]'),
(61, 48, 'traitements en cours', '[\n    \"Prenez-vous un traitement actuellement ?\"\n]', '[\n    \"Non.\"\n]'),
(72, 51, 'douleur thoracique', '[\n    \"Avez-vous un médicament que vous utilisez en cas de douleur thoracique ?\"\n]', '[\n    \"oui comme une pression sur le thoraxe\"\n]');

-- --------------------------------------------------------

--
-- Structure de la table `quiz1`
--

CREATE TABLE `quiz1` (
  `quiz1_id` int(11) NOT NULL,
  `nom_quiz` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz1`
--

INSERT INTO `quiz1` (`quiz1_id`, `nom_quiz`, `teacher_id`) VALUES
(1, 'QUIZ TEST NOW', 5),
(2, 'QUIZ TEST NOW 2', 5),
(3, 'Angor', 8);

-- --------------------------------------------------------

--
-- Structure de la table `quiz2`
--

CREATE TABLE `quiz2` (
  `quiz2_id` int(11) NOT NULL,
  `nom_quiz` varchar(50) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz2`
--

INSERT INTO `quiz2` (`quiz2_id`, `nom_quiz`, `teacher_id`) VALUES
(1, 'examen', 5),
(2, 'vcl', 5),
(3, 'eaaz', 8);

-- --------------------------------------------------------

--
-- Structure de la table `quiz3`
--

CREATE TABLE `quiz3` (
  `quiz3_id` int(11) NOT NULL,
  `nom_quiz` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `tentative_max` int(11) DEFAULT 5,
  `diagnostic_final` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz3`
--

INSERT INTO `quiz3` (`quiz3_id`, `nom_quiz`, `teacher_id`, `description`, `tentative_max`, `diagnostic_final`) VALUES
(45, 'Douleur thoracique - Cas clinique 1', 8, 'Femme de 64 ans, douleur thoracique évoluant depuis 3 jours, survenant à l’effort et calmée au repos. Antécédents inconnus. Tension 135/80, pouls régulier.', 10, 'Angor d’effort probable.'),
(48, 'Consultation pour gêne récente', 8, 'Patiente de 64 ans se présentant pour un motif de consultation récent.\nElle rapporte des symptômes survenus à plusieurs reprises ces derniers jours.', 15, 'Angor d’effort stable (angine de poitrine stable)'),
(51, 'cas5', 8, 'description patiet', 1, 'infractus');

-- --------------------------------------------------------

--
-- Structure de la table `quiz_audio`
--

CREATE TABLE `quiz_audio` (
  `quiz2_id` int(11) DEFAULT NULL,
  `qst_id` int(11) DEFAULT NULL,
  `audio_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz_audio`
--

INSERT INTO `quiz_audio` (`quiz2_id`, `qst_id`, `audio_file`) VALUES
(1, 1, 'adultCASE1.mp3'),
(1, 1, 'adultCASE1.mp3'),
(1, 2, 'adultCASE1.mp3'),
(2, 3, 'adultcase3a.mp3'),
(2, 3, 'adultCASE1.mp3'),
(3, 4, 'adultcase3a.mp3');

-- --------------------------------------------------------

--
-- Structure de la table `quiz_resultat1`
--

CREATE TABLE `quiz_resultat1` (
  `quiz1_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `resultat` decimal(5,2) DEFAULT NULL,
  `question_correct` int(11) DEFAULT NULL,
  `question_incorrect` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz_resultat1`
--

INSERT INTO `quiz_resultat1` (`quiz1_id`, `student_id`, `resultat`, `question_correct`, `question_incorrect`) VALUES
(1, 19659, 3.00, 3, 2),
(2, 19659, 1.00, 1, 3),
(2, 19650, 2.00, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `quiz_resultat2`
--

CREATE TABLE `quiz_resultat2` (
  `quiz2_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `resultat` decimal(5,2) DEFAULT NULL,
  `question_correct` int(11) DEFAULT NULL,
  `question_incorrect` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz_resultat2`
--

INSERT INTO `quiz_resultat2` (`quiz2_id`, `student_id`, `resultat`, `question_correct`, `question_incorrect`) VALUES
(2, 19659, 3.00, 3, 1),
(2, 19650, 1.00, 1, 2),
(3, 19668, 1.00, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `quiz_resultat3`
--

CREATE TABLE `quiz_resultat3` (
  `quiz3_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `question_posee` text DEFAULT NULL,
  `theme_revele` varchar(255) DEFAULT NULL,
  `diagnostic` text DEFAULT NULL,
  `resultat` float DEFAULT NULL,
  `date_de_passage` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz_resultat3`
--

INSERT INTO `quiz_resultat3` (`quiz3_id`, `student_id`, `question_posee`, `theme_revele`, `diagnostic`, `resultat`, `date_de_passage`) VALUES
(45, 19650, 'Est-ce qu\'un massage local aide à calmer la douleur ?,facteurs calmants', 'facteurs calmants', NULL, 0.997852, '2025-06-11 09:53:41'),
(45, 19662, '- Qu’est-ce qui soulage votre douleur ?\n- Est-ce que la douleur apparaît uniquement quand vous faites un effort ?\n- Pouvez-vous me décrire cette douleur ? Est-ce une sensation de brûlure, de pression, ou autre chose ?\n- Depuis combien de temps ressentez-vous cette douleur ?', '- facteurs calmants\n- facteurs déclenchants\n- douleur thoracique\n- durée', 'testdiag', 10, '2025-06-09 14:17:47'),
(45, 19663, '- Pouvez-vous me décrire cette douleur ? Est-ce une sensation de brûlure, de pression, ou autre chose ?\n- Qu’est-ce qui soulage votre douleur ?\n- epuis combien de temps ressentez-vous cette douleur ?epuis combien de temps ressentez-vous cette douleur ?', '- douleur thoracique\n- facteurs calmants\n- durée', 'azazazresultat', 6.5, '2025-06-09 14:23:53'),
(45, 19664, '- Est-ce que la douleur apparaît quand vous faites un effort ?\n- Depuis combien de temps avez-vous mal à la poitrine ?\n- La douleur se propage-t-elle vers votre bras ?\n- Quel type de douleur ressentez-vous dans la poitrine ?\n- Est-ce que ça s\'améliore en vous relaxant ?\n- Avez-vous un médicament que vous utilisez en cas de douleur thoracique ?', '- facteurs déclenchants\n- durée\n- irradiation\n- douleur thoracique\n- facteurs calmants', 'Angore', 10, '2025-06-11 09:46:25'),
(48, 19650, 'ERRER', 'douleur thoracique', NULL, 0.837052, '2026-02-03 07:42:56'),
(48, 19664, '-    \"À quel moment ressentez-vous cela ?\"\n- [     \"Depuis combien de temps avez-vous ce problème ?\" ]\n- Depuis combien de temps avez-vous ce problème ?\n- À quel moment ressentez-vous cela ?', '- douleur thoracique\n- durée', 'leo messi', NULL, '2026-07-03 15:43:33');

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `student`
--

INSERT INTO `student` (`student_id`, `name`, `email`, `password`, `date_of_birth`) VALUES
(19650, 'harrati zakaria', 'zaki@gmail.com', '$2y$10$7sAbIQY5xUJYq19iIFMG7u/sLIc9NJc8L1PEI92XgG5VFN0iLkoju', '2005-05-03'),
(19659, 'mohamed', 'zi@ail.com', '$2y$10$/3pgsI18IW/EgI/hHtRQi.8nWKqb8ENgqwAm52FDwEMcWSYskLdy6', '2023-05-16'),
(19662, 'nassim', 'nassimb@gmail.com', '$2y$10$9gi3p1NHdvlAT4DEVlrP/e9PP.I638yyprao6Fw82FBYPrX1ICZTe', '2025-06-13'),
(19663, 'mama', 'mama@gmail.com', '$2y$10$.jwK6y5RoyP445hTV6AbyOfcx4ywhUEnHTWPEwmGpdwurAw6QlA2O', '2025-06-04'),
(19664, 'anis', 'anis@gmail.com', '$2y$10$BOD0CGlif/F/sJGHBarHluzdZ2eKsbtkpHfQISL9WC7bUli8JIy/a', '2025-05-29'),
(19666, 'moh', 'moh@gmail.com', '$2y$10$sPJTdEkQ0zWlfyp5LIywruAlPsIXgEJ4CWS2xgcsaHtH9DUlNUZDq', '2000-03-03'),
(19668, 'amine', 'amine@gmail.com', '$2y$10$9wdvNi.7nNF0Q1RxZ7TTLeH3VRIpjZ6eZMGcOX1BF.4UweZarADO.', '2025-06-11');

-- --------------------------------------------------------

--
-- Structure de la table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `name`, `email`, `password`, `date_of_birth`) VALUES
(2, 'mohamedd', 'yacine@admin.com', '$2y$10$ijW8yTmYvgWl0NuXreQru.jiysLnrGfiO9UVrCc0r7a.7g4cVvAqO', '1997-07-09'),
(5, 'sehaba karim', 'sehab@gmail.com', '$2y$10$W1KGyw8S9jg729FzrbV98eugaYz2QnrMitrfTYYoLQ2nvZM.ns4aC', '1983-06-08'),
(8, 'mohamed', 'sehaba@gmail.com', '$2y$10$QFaJkPUC279U6cdip0vSt.0k2EFlc4v8Ls4ZIfKvNXMu/JhlRD.ba', '2023-05-18');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin_`
--
ALTER TABLE `admin_`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`cours_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Index pour la table `cours_audio`
--
ALTER TABLE `cours_audio`
  ADD KEY `cours_id` (`cours_id`);

--
-- Index pour la table `demande_student`
--
ALTER TABLE `demande_student`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `qst_quiz_1`
--
ALTER TABLE `qst_quiz_1`
  ADD PRIMARY KEY (`qst_id`),
  ADD KEY `quiz1_id` (`quiz1_id`);

--
-- Index pour la table `qst_quiz_2`
--
ALTER TABLE `qst_quiz_2`
  ADD PRIMARY KEY (`qst_id`),
  ADD KEY `quiz2_id` (`quiz2_id`);

--
-- Index pour la table `qst_quiz_3`
--
ALTER TABLE `qst_quiz_3`
  ADD PRIMARY KEY (`id_cas`),
  ADD KEY `quiz3_id` (`quiz3_id`);

--
-- Index pour la table `quiz1`
--
ALTER TABLE `quiz1`
  ADD PRIMARY KEY (`quiz1_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Index pour la table `quiz2`
--
ALTER TABLE `quiz2`
  ADD PRIMARY KEY (`quiz2_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Index pour la table `quiz3`
--
ALTER TABLE `quiz3`
  ADD PRIMARY KEY (`quiz3_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Index pour la table `quiz_audio`
--
ALTER TABLE `quiz_audio`
  ADD KEY `quiz2_id` (`quiz2_id`),
  ADD KEY `qst_id` (`qst_id`);

--
-- Index pour la table `quiz_resultat1`
--
ALTER TABLE `quiz_resultat1`
  ADD KEY `quiz1_id` (`quiz1_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Index pour la table `quiz_resultat2`
--
ALTER TABLE `quiz_resultat2`
  ADD KEY `quiz2_id` (`quiz2_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Index pour la table `quiz_resultat3`
--
ALTER TABLE `quiz_resultat3`
  ADD PRIMARY KEY (`quiz3_id`,`student_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Index pour la table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Index pour la table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin_`
--
ALTER TABLE `admin_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `cours_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `demande_student`
--
ALTER TABLE `demande_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `qst_quiz_1`
--
ALTER TABLE `qst_quiz_1`
  MODIFY `qst_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `qst_quiz_2`
--
ALTER TABLE `qst_quiz_2`
  MODIFY `qst_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `qst_quiz_3`
--
ALTER TABLE `qst_quiz_3`
  MODIFY `id_cas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT pour la table `quiz3`
--
ALTER TABLE `quiz3`
  MODIFY `quiz3_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT pour la table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19669;

--
-- AUTO_INCREMENT pour la table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `cours_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Contraintes pour la table `cours_audio`
--
ALTER TABLE `cours_audio`
  ADD CONSTRAINT `cours_audio_ibfk_1` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`cours_id`);

--
-- Contraintes pour la table `qst_quiz_1`
--
ALTER TABLE `qst_quiz_1`
  ADD CONSTRAINT `qst_quiz_1_ibfk_1` FOREIGN KEY (`quiz1_id`) REFERENCES `quiz1` (`quiz1_id`);

--
-- Contraintes pour la table `qst_quiz_2`
--
ALTER TABLE `qst_quiz_2`
  ADD CONSTRAINT `qst_quiz_2_ibfk_1` FOREIGN KEY (`quiz2_id`) REFERENCES `quiz2` (`quiz2_id`);

--
-- Contraintes pour la table `qst_quiz_3`
--
ALTER TABLE `qst_quiz_3`
  ADD CONSTRAINT `qst_quiz_3_ibfk_1` FOREIGN KEY (`quiz3_id`) REFERENCES `quiz3` (`quiz3_id`);

--
-- Contraintes pour la table `quiz1`
--
ALTER TABLE `quiz1`
  ADD CONSTRAINT `quiz1_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Contraintes pour la table `quiz2`
--
ALTER TABLE `quiz2`
  ADD CONSTRAINT `quiz2_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Contraintes pour la table `quiz3`
--
ALTER TABLE `quiz3`
  ADD CONSTRAINT `quiz3_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Contraintes pour la table `quiz_audio`
--
ALTER TABLE `quiz_audio`
  ADD CONSTRAINT `quiz_audio_ibfk_1` FOREIGN KEY (`quiz2_id`) REFERENCES `quiz2` (`quiz2_id`),
  ADD CONSTRAINT `quiz_audio_ibfk_2` FOREIGN KEY (`qst_id`) REFERENCES `qst_quiz_2` (`qst_id`);

--
-- Contraintes pour la table `quiz_resultat1`
--
ALTER TABLE `quiz_resultat1`
  ADD CONSTRAINT `quiz_resultat1_ibfk_1` FOREIGN KEY (`quiz1_id`) REFERENCES `quiz1` (`quiz1_id`),
  ADD CONSTRAINT `quiz_resultat1_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Contraintes pour la table `quiz_resultat2`
--
ALTER TABLE `quiz_resultat2`
  ADD CONSTRAINT `quiz_resultat2_ibfk_1` FOREIGN KEY (`quiz2_id`) REFERENCES `quiz2` (`quiz2_id`),
  ADD CONSTRAINT `quiz_resultat2_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Contraintes pour la table `quiz_resultat3`
--
ALTER TABLE `quiz_resultat3`
  ADD CONSTRAINT `quiz_resultat3_ibfk_1` FOREIGN KEY (`quiz3_id`) REFERENCES `quiz3` (`quiz3_id`),
  ADD CONSTRAINT `quiz_resultat3_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
