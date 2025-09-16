-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2025 at 03:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bibliotheque`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `publish_year` year(4) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `available` int(11) DEFAULT 1,
  `cover_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `category`, `description`, `publish_year`, `publisher`, `quantity`, `available`, `cover_image`, `created_at`) VALUES
(1, 'L\'Étranger du peuple', 'Albert Camus', '978-2070360024', 'Fiction', '', '2001', '', 1, 0, '1757442229_335791a99bf53d66d69f.jpg', '2025-09-08 23:46:10'),
(2, '1984', 'George Orwell', '978-2070368228', 'Science-Fiction', '', '2005', '', 10, 0, NULL, '2025-09-08 23:46:10'),
(4, 'li', 'Abel Akime Amzad Lanlaye', '12344', 'Jeunesse', 'mmm', '2010', 'Ediction Camara laye', 100, 99, '1757416720_a6f35f1d47b537d9db2b.jpg', '2025-09-09 11:18:40'),
(8, 'Abel , le createur du big bang', 'Abel KPOKOUTA', '12344', 'Fantasy', 'ff', '2024', 'Ediction Camara laye', 100, 100, '1757442306_be6eefa89a2de7a1c652.jpg', '2025-09-09 18:25:06'),
(10, 'el', 'Abel Akime Amzad Lanlaye', '12344', 'Science-Fiction', 'e', '1904', 'Ediction Camara laye', 1, 0, NULL, '2025-09-09 19:42:31'),
(11, 'fm', 'Abel KPOKOUTA', '12344', 'Fiction', 'd', '1921', 'Ediction Camara laye', 1, 1, '1757466776_bb58d6a103da40cff089.png', '2025-09-09 23:34:04'),
(13, '1984', 'George Orwell', '9780451524935', 'Fiction', 'Un roman dystopique qui dépeint une société totalitaire où la liberté individuelle est supprimée.\r\nRésumé : Winston Smith lutte contre la surveillance oppressive de Big Brother et rêve de rébellion.', '1949', 'Secker & Warburg', 5, 5, '1757755903_33c087dd1ef179a14be0.jpg', '2025-09-13 09:00:31'),
(14, 'Le Meilleur des Mondes', 'Aldous Huxley', '9782070368228', '', 'Un classique de la science-fiction qui imagine un futur où les humains sont conditionnés dès la naissance.\r\nRésumé : Bernard Marx commence à questionner ce monde \"parfait\" après avoir rencontré John le Sauvage.', '1932', 'Chatto & Windus', 4, 4, '1757755922_6d6772aa35c678ed8b7d.jpg', '2025-09-13 09:00:31'),
(15, 'Dune', 'Frank Herbert', '9780441013593', '', 'Une épopée galactique autour de la planète Arrakis et de sa ressource précieuse : l\'épice.\r\nRésumé : Paul Atréides doit devenir le leader attendu pour libérer Arrakis.', '1965', 'Chilton Books', 6, 6, '1757755943_6c18ade8b4fb1b106796.jpg', '2025-09-13 09:00:31'),
(16, 'Le Seigneur des Anneaux - La Communauté de l\'Anneau', 'J.R.R. Tolkien', '9780544003415', 'Fantasy', 'Le premier tome de l\'aventure épique en Terre du Milieu.\r\nRésumé : Frodon Sacquet hérite de l\'Anneau Unique et\r\nentreprend un périple pour le détruire.', '1954', 'Allen & Unwin', 7, 7, '1757755964_f69bb3c2e254db8a019f.jpg', '2025-09-13 09:00:31'),
(17, 'Harry Potter à l\'École des Sorciers', 'J.K. Rowling', '9782070643028', 'Jeunesse', 'Le premier tome de la célèbre saga magique.\r\nRésumé : Harry découvre qu\'il est un sorcier et fait sa rentrée à Poudlard.', '1997', 'Bloomsbury', 8, 8, '1757755989_e248b6e24ae674b34ec1.jpg', '2025-09-13 09:00:31'),
(18, 'Les Misérables', 'Victor Hugo', '9782070409181', '', 'Un chef-d\'œuvre de la littérature française qui explore la justice, la rédemption et l\'amour.\r\nRésumé : Jean Valjean cherche la rédemption après sa sortie du bagne.', '0000', 'A. Lacroix & Cie', 4, 4, '1757756248_baff72f7903fec3526e8.jpg', '2025-09-13 09:00:31'),
(19, 'Sun Tzu - L\'Art de la Guerre', 'Sun Tzu', '9782080712898', 'Stratégie', 'Un traité militaire chinois intemporel.\r\nRésumé : Enseignements sur la stratégie et la tactique applicables à la guerre et au management.', '0000', 'Éditions Payot', 5, 5, '1757756388_eaffa6dea0893aa2b723.jpg', '2025-09-13 09:00:31'),
(20, 'La Stratégie Océan Bleu', 'W. Chan Kim & Renée Mauborgne', '9782717859481', 'Stratégie', 'Un guide sur la création de marchés innovants sans concurrence.\r\nRésumé : Comment créer un \"océan bleu\" en réinventant son secteur.', '2005', 'Pearson', 3, 3, '1757756426_6a35fe79de357eaaea28.jpg', '2025-09-13 09:00:31'),
(21, 'Steve Jobs', 'Walter Isaacson', '9781451648539', '', 'La biographie officielle du fondateur d\'Apple.\r\nRésumé : L\'histoire de Steve Jobs, de son enfance à la création d\'Apple et au-delà.', '2011', 'Simon & Schuster', 3, 3, '1757756446_d6b2fda3b03b836997a9.jpg', '2025-09-13 09:00:31'),
(22, 'Elon Musk', 'Ashlee Vance', '9780062301253', '', 'Un portrait détaillé de l\'entrepreneur visionnaire derrière Tesla et SpaceX.\r\nRésumé : Comment Musk veut révolutionner l\'espace et l\'énergie sur Terre.', '2015', 'Ecco', 3, 3, '1757756463_ed5be1b13d956a861011.jpg', '2025-09-13 09:00:31'),
(23, 'Clean Code', 'Robert C. Martin', '9780132350884', 'Informatique', 'Un guide incontournable pour écrire du code de qualité.\r\nRésumé : Bonnes pratiques pour des logiciels maintenables et propres.', '2008', 'Prentice Hall', 5, 5, '1757757375_1f4d8665887855809abf.jpg', '2025-09-13 09:00:31'),
(24, 'Design Patterns', 'Erich Gamma et al.', '9780201633610', 'Informatique', 'Le livre de référence sur les modèles de conception.\r\nRésumé : 23 patrons de conception pour structurer et améliorer le code orienté objet.', '1994', 'Addison-Wesley', 4, 4, '1757757401_ccfb9d8bbd1ac649e3b4.jpg', '2025-09-13 09:00:31'),
(25, 'Introduction à l\'Algorithme', 'Thomas H. Cormen', '9780262033848', 'Informatique', 'Référence académique sur les algorithmes.\r\nRésumé : Études détaillées des structures de données et algorithmes avec preuves mathématiques.', '2009', 'MIT Press', 4, 4, '1757757428_2fd9857436dd9703d628.jpg', '2025-09-13 09:00:31'),
(26, 'Le Petit Prince', 'Antoine de Saint-Exupéry', '9780156013987', 'Jeunesse', 'Un conte philosophique intemporel.\r\nRésumé : Un aviateur rencontre un petit prince venu d\'une autre planète.', '1943', 'Reynal & Hitchcock', 6, 6, '1757757460_27b170ac11c91e1f5eea.jpg', '2025-09-13 09:00:31'),
(27, 'Voyage au Centre de la Terre', 'Jules Verne', '9782253006329', '', 'Un roman d\'aventure et de science-fiction.\r\nRésumé : Le professeur Lidenbrock et son neveu entreprennent une expédition dans les entrailles de la Terre.', '0000', 'Pierre-Jules Hetzel', 5, 5, '1757757491_863782112b68e5bf6ebc.jpg', '2025-09-13 09:00:31'),
(28, 'Fahrenheit 451', 'Ray Bradbury', '9781451673319', '', 'Un roman dystopique où les livres sont interdits et brûlés.\r\nRésumé : Montag, pompier pyromane, commence à douter du système.', '1953', 'Ballantine Books', 5, 5, '1757757516_9249efa8adefdf166b3b.jpg', '2025-09-13 09:00:31'),
(29, 'L\'Homme qui Rit', 'Victor Hugo', '9782070409174', '', 'Roman mêlant drame, amour et réflexion sociale.\r\nRésumé : Gwynplaine, un homme au visage défiguré, lutte contre l\'injustice sociale.', '0000', 'A. Lacroix & Cie', 3, 3, '1757757543_32d0be5b80251f8f94b8.jpg', '2025-09-13 09:00:31'),
(30, 'Les Rois Maudits - Le Roi de Fer', 'Maurice Druon', '9782266082720', 'Histoire', 'Premier tome de la fresque historique sur les rois de France.\r\nRésumé : Philippe le Bel et la malédiction des Templiers.', '1955', 'Del Duca', 4, 4, '1757757568_fe37853596834e2d0329.jpg', '2025-09-13 09:00:31'),
(31, 'Sapiens : Une brève histoire de l\'humanité', 'Yuval Noah Harari', '9780099590088', 'Histoire', 'Essai sur l\'évolution de l\'homo sapiens.\r\nRésumé : Comment l\'espèce humaine a dominé le monde grâce aux mythes et aux récits collectifs.', '2011', 'Harvill Secker', 5, 5, '1757757614_7b518d7bb2a648876459.jpg', '2025-09-13 09:00:31'),
(32, 'L\'Alchimiste', 'Paulo Coelho', '9780061122415', 'Fiction', 'Un roman initiatique sur la quête de soi.\r\nRésumé : Santiago, berger andalou, part à la recherche de sa légende personnelle.', '1988', 'HarperTorch', 6, 6, '1757757656_047414c3536693c5e0ae.jpg', '2025-09-13 09:00:31');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('pending','active','returned','overdue','cancelled') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `book_id`, `user_id`, `loan_date`, `due_date`, `return_date`, `status`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(21, 1, 2, '2025-08-31', '2025-09-30', '2025-09-10', 'returned', 'Emprunt standard', 1, '2025-09-10 02:21:29', '2025-09-10 01:24:23'),
(22, 2, 2, '2025-07-27', '2025-08-26', '2025-08-24', 'returned', 'Retour anticipé', 1, '2025-09-10 02:21:29', '2025-09-10 02:21:29'),
(23, 4, 3, '2025-08-01', '2025-08-31', '2025-08-30', 'returned', 'Bon état', 1, '2025-09-10 02:21:29', '2025-09-10 02:21:29'),
(24, 8, 3, '2025-07-22', '2025-08-21', '2025-09-10', 'returned', 'Relance nécessaire', 1, '2025-09-10 02:21:29', '2025-09-10 11:20:06'),
(26, 11, 3, '2025-06-22', '2025-07-22', NULL, 'cancelled', 'Annulation lecteur', 1, '2025-09-10 02:21:29', '2025-09-10 02:21:29'),
(28, 2, 1, '2025-09-10', '2025-10-10', '2025-09-10', 'returned', '', 12, '2025-09-10 11:13:30', '2025-09-10 11:19:26'),
(29, 2, 2, '2025-09-10', '2025-10-10', NULL, 'active', '', 12, '2025-09-10 12:19:22', '2025-09-10 12:19:22'),
(30, 4, 2, '2025-09-10', '2025-10-10', NULL, 'active', '', 12, '2025-09-10 22:38:57', '2025-09-10 22:38:57'),
(32, 1, 4, '2025-09-10', '2025-10-10', '2025-09-10', 'returned', '', 12, '2025-09-10 22:55:40', '2025-09-10 22:56:21'),
(33, 1, 4, '2025-09-10', '2025-10-10', NULL, 'active', '', 12, '2025-09-10 22:56:30', '2025-09-10 22:56:30'),
(34, 8, 15, '2025-09-12', '2025-10-12', '2025-09-12', 'returned', '', 12, '2025-09-12 01:04:32', '2025-09-12 21:38:11'),
(35, 10, 15, '2025-09-12', '2025-10-12', NULL, 'active', '', 12, '2025-09-12 01:04:49', '2025-09-12 01:04:49'),
(36, 1, 15, '2025-09-12', '2025-10-12', NULL, 'active', NULL, 15, '2025-09-12 22:36:28', '2025-09-12 22:36:28'),
(37, 11, 15, '2025-09-13', '2025-10-13', '2025-09-13', 'returned', NULL, 15, '2025-09-12 23:16:11', '2025-09-13 00:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text NOT NULL,
  `setting_type` enum('string','number','boolean','json') DEFAULT 'string',
  `category` varchar(50) DEFAULT 'general',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `category`, `description`, `created_at`, `updated_at`) VALUES
(1, 'library_name', 'Ma Bibliothèque', 'string', 'general', 'Nom de la bibliothèque', '2025-09-10 21:42:59', '2025-09-10 21:42:59'),
(2, 'loan_duration', '3', 'number', 'loans', 'Durée maximale des emprunts en jours', '2025-09-10 21:42:59', '2025-09-11 00:15:06'),
(3, 'max_books_per_user', '2', 'number', 'loans', 'Nombre maximum de livres par utilisateur', '2025-09-10 21:42:59', '2025-09-12 01:14:49'),
(4, 'email_notifications', '1', 'boolean', 'notifications', 'Activer les notifications email', '2025-09-10 21:42:59', '2025-09-10 21:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `status` enum('student','teacher','professor','librarian','professional','other') DEFAULT 'student',
  `student_id` varchar(50) DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `professional_title` varchar(100) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `is_active` tinyint(1) DEFAULT 0,
  `membership_expiry` date DEFAULT NULL,
  `activation_code` varchar(32) DEFAULT NULL,
  `reset_token` varchar(32) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `phone`, `address`, `date_of_birth`, `status`, `student_id`, `institution`, `specialization`, `professional_title`, `role`, `is_active`, `membership_expiry`, `activation_code`, `reset_token`, `reset_expires`, `created_at`, `updated_at`) VALUES
(1, 'admin@bibliotheque.com', 'abel1234', 'Admin', 'System', '', '', '0000-00-00', 'librarian', '', 'Bibliothèque Centrale', '', '', 'user', 1, NULL, NULL, NULL, NULL, '2025-09-08 23:47:33', '2025-09-10 00:37:38'),
(2, 'etudiant1@universite.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Marie', 'Dupont', NULL, NULL, NULL, 'student', 'ETU12345', 'Université Paris-Sorbonne', NULL, NULL, 'user', 1, NULL, NULL, NULL, NULL, '2025-09-08 23:47:33', '2025-09-08 23:47:33'),
(3, 'professeur@universite.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pierre', 'Martin', NULL, NULL, NULL, 'professor', NULL, 'Université Paris-Diderot', NULL, NULL, 'user', 1, NULL, NULL, NULL, NULL, '2025-09-08 23:47:33', '2025-09-08 23:47:33'),
(4, 'ingenieur@entreprise.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sophie', 'Leroy', NULL, NULL, NULL, 'professional', NULL, 'Google France', NULL, NULL, 'user', 1, NULL, NULL, NULL, NULL, '2025-09-08 23:47:33', '2025-09-08 23:47:33'),
(7, 'admin2@bibliotheque.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'Test', '', '', '0000-00-00', 'librarian', '', '', '', '', 'admin', 1, NULL, NULL, NULL, NULL, '2025-09-09 09:03:11', '2025-09-09 23:23:47'),
(8, 'directeur@bibliotheque.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pierre', 'Durand', NULL, NULL, NULL, 'librarian', NULL, 'Bibliothèque Centrale', NULL, NULL, 'admin', 1, NULL, NULL, NULL, NULL, '2025-09-09 10:21:45', '2025-09-09 10:21:45'),
(9, 'catalogue@bibliotheque.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Marie', 'Lefebvre', NULL, NULL, NULL, 'librarian', NULL, 'Bibliothèque Centrale', NULL, NULL, 'admin', 1, NULL, NULL, NULL, NULL, '2025-09-09 10:21:45', '2025-09-09 10:21:45'),
(10, 'superadmin@bibliotheque.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Super', 'Admin', NULL, NULL, NULL, 'student', NULL, NULL, NULL, NULL, 'admin', 1, NULL, NULL, NULL, NULL, '2025-09-09 10:51:41', '2025-09-09 10:51:41'),
(12, 'superadmmmin@bibliotheque.com', '$2y$10$XEvRZ1gbqccyIPT.un9GferAMJTdBse1qME.ggUtEtgzOq3zFOBOy', 'Super', 'Administrateur', NULL, NULL, NULL, 'librarian', NULL, 'Bibliothèque Centrale', NULL, NULL, 'admin', 1, '2030-09-09', NULL, NULL, NULL, '2025-09-09 10:16:18', '2025-09-09 10:16:18'),
(13, 'agbodojosue@gmail.com', '$2y$10$XoDIVph5wdeRyQrfvXML6.3nEzJ1HolalYTt04E3IqRAUdObl0HZO', 'Josué', 'AGBODO', '0121222324', 'CALAVI', '2006-10-10', 'student', '44444444', 'UNSTIM', 'Ingénerie', '', 'admin', 0, NULL, NULL, NULL, NULL, '2025-09-09 23:25:31', '2025-09-10 22:58:30'),
(15, 'kpokoutaabel@gmail.com', '$2y$10$milrOlNs8bNc8u4tCSwXzOfe1LypU3ziGRuCP/E.Yww7LDqL7k8FG', 'Dimitri', 'KPOKOUTA', '0155697937', 'Godomey / Cocotomey', '2005-10-26', 'student', '44444444', 'UNSTIM', 'Ingénerie', 'Devéloppeur ', 'user', 1, NULL, NULL, NULL, NULL, '2025-09-12 01:00:50', '2025-09-13 21:16:55'),
(16, 'kocouabel@gmail.com', '$2y$10$klYCJxkeC6F1BC3h3tv/VOAZSts85NlEwd84ZmJvEEK5539oOBXRe', 'Abel', 'KPOKOUTA', '0121222324', 'Cocotomey', '2005-10-26', 'student', '44444444', '', 'Ingénerie', '', 'user', 1, '2026-09-13', '5e8a750c15fe4fe8715077f59334f936', NULL, NULL, '2025-09-13 20:04:17', '2025-09-13 20:04:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_institution` (`institution`),
  ADD KEY `idx_membership_expiry` (`membership_expiry`),
  ADD KEY `idx_active` (`is_active`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
