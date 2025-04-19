-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 06:32 PM
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
-- Database: `smartedu`
--

-- --------------------------------------------------------

--
-- Table structure for table `module_english`
--

CREATE TABLE `module_english` (
  `id` int(11) NOT NULL,
  `chapter` varchar(1000) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `description` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_english`
--

INSERT INTO `module_english` (`id`, `chapter`, `title`, `description`) VALUES
(1, '1', 'The Power of Language – Understanding How Words Shape Our World', 'Introduction\nLanguage is more than just a means of communication—it\'s the foundation of how we think, express ourselves, connect with others, and shape the world around us. In this chapter, we will explore how language functions not only as a tool for daily communication but also as a powerful instrument for storytelling, persuasion, emotion, and identity. Understanding the power of language will help you become a more effective speaker, a critical reader, and a confident writer.\n\nWhat Is Language?\nLanguage is a structured system of symbols—words, sounds, gestures, and rules—that allows humans to convey thoughts, feelings, and information. It includes both spoken and written forms and varies widely across cultures and communities.\n\nLanguage is made up of key components:\n\nVocabulary: the collection of words known and used\n\nGrammar: the rules that govern how words are structured into sentences\n\nSyntax: how words are arranged in a sentence\n\nTone: the emotional quality or mood of the message\n\nContext: the situation in which language is used (who, when, where, why)\n\nThe Role of Language in Communication\nLanguage allows us to:\n\nExpress thoughts and emotions: We use language to say how we feel or what we think.\n\nShare knowledge: Through books, conversation, and media, we communicate what we know.\n\nBuild relationships: Language connects people. We use it to relate, empathize, and understand others.\n\nInfluence and persuade: Advertisements, speeches, and debates show how language can influence opinions and actions.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `age`, `created_at`) VALUES
(1, 'renz', 'matthew', 'matthewybamit@ymail.com', 'matthewibamit', '$2y$10$PhgpPvPEXTqayIEiIQx/eu4qjaj3npbVXLo76nyKUdgo1VoUlClCu', 21, '2025-03-23 19:10:29'),
(4, 'dwa', 'awfa', 'matthewybamit@gmail.com', 'matthewibamit', '$2y$10$jyeFF22l6aQATQAYQ/n28uQ2bjso4m8rWBfRzZtW5PCMQsnA9DGqu', 21, '2025-03-23 19:35:31'),
(5, 'Renz Matthew waf', 'Ybamitfa', 'renzmatthew.ybamit@gmail.com', 'nfafnionf', '$2y$10$DqZj9U.ApBRw8ohtFncQvuGMfZhfgxlg5s190K/A62pCBpbnvSWWG', 21, '2025-03-23 19:46:41'),
(6, 'Pogi', 'Talaga', 'pogikotalaga@gmail.com', 'Pogi', '$2y$10$ngW4ACX1j0tAL.oEVmAVK.eVwzYnfiW7Tb9OjG6Q6hGXYZJiU5xri', 20, '2025-04-07 19:18:50'),
(7, 'PogiKo', 'Yon', 'pogikotalaga1@gmail.com', 'PogiKo', '$2y$10$J6018UvuddavsBacJkqnSO0biH/gMosjjqq46GdvKg/lvdSumqMcC', 20, '2025-04-07 19:26:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `module_english`
--
ALTER TABLE `module_english`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `module_english`
--
ALTER TABLE `module_english`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
