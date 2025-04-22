-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2025 at 05:05 PM
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
-- Database: `lumin_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `level` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `cover_photo` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `description`, `level`, `subject`, `cover_photo`, `date_created`, `created_at`) VALUES
(19, 'History of Asia', 'Asia, the largest and most diverse continent on Earth, has been home to some of the world\'s earliest civilizations. From the fertile valleys of Mesopotamia and the Indus River to the ancient dynasties of China, Asia\'s history spans thousands of years and has shaped the world in profound ways. This lesson explores the early civilizations of Asia, their cultures, and their lasting contributions to human history.\r\nAncient Civilizations of Asia\r\nThe earliest civilizations in Asia emerged in river valleys, where fertile land allowed agriculture to flourish. One of the first great civilizations was Mesopotamia, located between the Tigris and Euphrates rivers (present-day Iraq). The Sumerians, Akkadians, Babylonians, and Assyrians ruled this region, developing the earliest known writing system, cuneiform, and the first set of laws, Hammurabi’s Code.\r\nIn South Asia, the Indus Valley Civilization (c. 3300–1300 BCE) developed in present-day Pakistan and northwest India. This highly organized society built well-planned cities such as Mohenjo-Daro and Harappa, with advanced drainage systems and trade networks. The people of this civilization had a writing system that remains undeciphered today.\r\nFurther east, in China, the Shang Dynasty (c. 1600–1046 BCE) was the first recorded dynasty, known for its bronze casting, oracle bones (used for divination), and early forms of Chinese writing. This was followed by the Zhou Dynasty (1046–256 BCE), which introduced the concept of the Mandate of Heaven, the belief that rulers were given the right to rule by the gods.\r\nReligions and Philosophies\r\nAsia is the birthplace of many major religions and philosophies. Hinduism and Buddhism originated in India, shaping the spiritual and cultural traditions of the region. Hinduism, one of the world\'s oldest religions, is based on sacred texts like the Vedas and Upanishads. Buddhism, founded by Siddhartha Gautama (the Buddha) in the 5th-4th century BCE, spread from India to China, Japan, and Southeast Asia, influencing millions.\r\nIn China, Confucianism and Daoism emerged as dominant philosophical traditions. Confucius (551–479 BCE) taught about social harmony, respect for elders, and moral leadership. Meanwhile, Laozi, the founder of Daoism, emphasized living in harmony with nature.\r\nThe Silk Road and Cultural Exchange\r\nTrade routes, such as the Silk Road, connected Asia with Europe and Africa, allowing for the exchange of goods, ideas, and cultures. The Silk Road facilitated the spread of Buddhism from India to China, Persia, and beyond. It also introduced silk, spices, and paper-making techniques to the West.\r\nConclusion\r\nAsia’s ancient civilizations laid the foundations for modern societies. Their innovations in writing, law, religion, and trade influenced cultures across the world. Understanding this early history helps us appreciate Asia’s role in shaping global civilization.', 'Beginner', 'History', 'admin/uploads/covers/68069fce3bbf9_History of Asia.png', '2025-04-22 03:43:10', '2025-04-22 21:15:27'),
(20, 'Pre-Colonial Philippines', 'Pre-colonial Philippines\r\n\r\nBefore the arrival of the Spanish colonizers, the Philippine archipelago was home to thriving communities with distinct cultures, traditions, and governance. These early societies were organized into small, independent settlements called barangays, each led by a datu, or chieftain. The word barangay comes from balangay, a type of boat used by early Austronesian settlers. These communities were often situated along coastlines and rivers, where trade and fishing were central to daily life.\r\n\r\nSocial classes existed within these barangays. The ruling class, known as the maharlika or maginoo, included the datu and his family, as well as warriors and nobles. Beneath them were the timawa, or free citizens, who worked as farmers, fishermen, and traders. The lowest class, the alipin, consisted of individuals who served the higher classes. Unlike slaves in European societies, alipin could earn their freedom through labor or marriage.\r\nAgriculture was the backbone of pre-colonial life. Early Filipinos cultivated rice, taro, sugarcane, and coconuts, among other crops. Farming techniques such as kaingin, or slash-and-burn agriculture, were widely practiced in mountainous areas. In addition to farming, they engaged in fishing, hunting, and raising livestock. Tools were made from wood, stone, and metal, and communities developed specialized crafts like weaving, pottery, and boat-making.\r\n\r\nTrade played a crucial role in the economy. Filipinos had extensive trade networks with neighboring regions, including China, India, and the Middle East. Artifacts such as porcelain, silk, and glass beads found in archaeological sites suggest that early Filipinos exchanged local products like gold, pearls, beeswax, and spices for foreign goods. The presence of foreign merchants also influenced aspects of Filipino culture, including language, fashion, and religious beliefs.\r\nThe religious beliefs of pre-colonial Filipinos were animistic, meaning they believed that spirits resided in natural objects such as trees, mountains, and rivers. They worshiped deities, known as anitos, and performed rituals led by spiritual leaders called babaylan or katalonan. These rituals included offerings, chants, and dances to seek blessings for good harvests, safe journeys, or healing. Some communities also believed in a supreme being, though interpretations varied across regions.\r\nMarriage and family were important aspects of society. Courtship involved elaborate rituals, including the practice of harana, or serenading, and paninilbihan, where a suitor would perform tasks to prove his worth to a woman\'s family. Dowries, known as bigay-kaya, were given as a form of respect. Families were tightly knit, and children were raised to respect their elders, a value that continues in Filipino culture today.\r\nJustice in pre-colonial barangays was based on customary laws, which were often passed down orally. Conflicts were settled by the datu, who acted as both leader and judge. Punishments varied depending on the offense, ranging from fines and labor to exile or death for severe crimes. Some disputes were resolved through trial by ordeal, where the accused had to undergo physical tests, such as retrieving a stone from boiling water, to prove innocence.\r\nThe arts and literature of pre-colonial Filipinos were rich and expressive. Oral traditions, including epic poems, proverbs, and folktales, played a key role in preserving history and values. These stories were passed down through generations, teaching lessons about bravery, love, and morality. Traditional music and dance were integral to celebrations and rituals, often accompanied by indigenous instruments like the kulintang, gong, and kubing.\r\nDespite the absence of a unified government, pre-colonial Filipinos lived in organized societies with structured leadership, economies, and cultural traditions. Their way of life reflected their deep connection with nature, their adaptability, and their ability to sustain thriving communities long before colonial influence.', 'Beginner', 'History', 'admin/uploads/covers/6806a9888df09_Pre-colonial Philippines.png', '2025-04-22 04:20:02', '2025-04-22 21:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_materials`
--

CREATE TABLE `lesson_materials` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `material_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `option_text`, `is_correct`) VALUES
(22, 23, 'Hieroglyphics', 0),
(23, 23, 'Cuneiform', 1),
(24, 23, 'Sanskrit', 0),
(25, 23, 'Latin', 0),
(26, 24, 'Massive pyramids', 0),
(27, 24, 'Advanced drainage systems', 1),
(28, 24, 'Bronze statues', 0),
(29, 24, 'Oracle bone inscriptions', 0),
(30, 25, 'Zhou', 0),
(31, 25, 'Qin', 0),
(32, 25, 'Han', 0),
(33, 25, 'Shang', 1),
(34, 26, 'Daoism', 1),
(35, 26, 'Buddhism', 0),
(36, 26, 'Confucianism', 0),
(37, 26, 'Legalism', 0),
(38, 27, 'Hinduism', 1),
(39, 27, 'Judaism', 0),
(40, 27, 'Christianity', 0),
(41, 27, 'Buddhism', 0),
(42, 28, 'A council of elders', 1),
(43, 28, 'A type of boat', 0),
(44, 28, 'A warrior class', 0),
(45, 28, 'A farming tool', 0),
(46, 29, 'Maharlika', 0),
(47, 29, 'Timawa', 0),
(48, 29, 'Alipin', 1),
(49, 29, 'Babaylan', 0),
(50, 30, 'Harana', 0),
(51, 30, 'Kaingin', 1),
(52, 30, 'Paninilbihan', 0),
(53, 30, 'Bigay-kaya', 0),
(54, 31, 'Porcelain and silk', 1),
(55, 31, 'Guns and steel', 0),
(56, 31, 'Coffee and tobacco', 0),
(57, 31, 'Horses and camels', 0),
(58, 32, 'Leading warriors in battle', 0),
(59, 32, 'Overseeing trade networks', 0),
(60, 32, 'Conducting spiritual rituals', 1),
(61, 32, 'Enforcing customary laws', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` varchar(50) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `question_type`, `points`, `created_at`) VALUES
(23, 13, 'Which ancient Mesopotamian writing system was developed by the Sumerians around 3500 BCE?', 'multiple-choice', 1, '2025-04-22 21:12:29'),
(24, 13, 'The ancient Indus Valley city of Mohenjo‑Daro is especially noted for what feature?', 'multiple-choice', 1, '2025-04-22 21:12:29'),
(25, 13, 'Oracle bones used for divination and early bronze‑casting technology are characteristic of which Chinese dynasty?', 'multiple-choice', 1, '2025-04-22 21:12:29'),
(26, 13, 'Which philosophy, founded by Confucius, emphasizes social harmony, respect for elders, and moral leadership?', 'multiple-choice', 1, '2025-04-22 21:12:29'),
(27, 13, 'Which religion spread from India to China via the Silk Road, beginning in the 1st or 2nd century CE?', 'multiple-choice', 1, '2025-04-22 21:12:29'),
(28, 14, 'What was the origin of the term &quot;barangay&quot; in pre-colonial Philippine societies?', 'multiple-choice', 1, '2025-04-22 21:12:29'),
(29, 14, 'Which social class in pre-colonial barangays could earn their freedom through labor or marriage?', 'multiple-choice', 1, '2025-04-22 21:12:29'),
(30, 14, 'What agricultural technique involved clearing land by cutting and burning vegetation?', 'multiple-choice', 1, '2025-04-22 21:12:29'),
(31, 14, 'Which of the following items were traded by pre-colonial Filipinos with foreign merchants?', 'multiple-choice', 1, '2025-04-22 21:12:29'),
(32, 14, 'What was the role of the babaylan or katalonan in pre-colonial society?', 'multiple-choice', 1, '2025-04-22 21:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `total_points` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `lesson_id`, `title`, `description`, `total_points`, `created_at`) VALUES
(13, 19, 'History of Asia', 'A brain teaser to enhance  your learnings about the history of Asia', 5, '2025-04-22 21:14:45'),
(14, 20, 'Quiz: Pre-colonial Philippines', 'Pre-colonial Philippines to test your knowledge', 5, '2025-04-22 21:14:45');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` int(11) NOT NULL,
  `user_email` varchar(120) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `source` varchar(20) NOT NULL,
  `subject` varchar(64) NOT NULL,
  `content_id` int(11) DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `user_email`, `quiz_id`, `score`, `total_questions`, `source`, `subject`, `content_id`, `date_completed`) VALUES
(3, 'renzmatthew.ybamit@gmail.com', 1, 4, 5, 'video', 'Mathematics', 1, '2025-04-22 21:29:10'),
(4, 'renzmatthew.ybamit@gmail.com', 1, 3, 5, 'read', 'Mathematics', 1, '2025-04-22 21:29:10'),
(5, 'renzmatthew.ybamit@gmail.com', 1, 4, 5, 'video', 'Programming', 1, '2025-04-22 21:29:10'),
(6, 'renzmatthew.ybamit@gmail.com', 1, 3, 5, 'read', 'Programming', 1, '2025-04-22 21:29:10'),
(7, 'renzmatthew.ybamit@gmail.com', 1, 5, 5, 'video', 'Science', 1, '2025-04-22 21:29:10'),
(8, 'renzmatthew.ybamit@gmail.com', 1, 3, 5, 'read', 'Science', 1, '2025-04-22 21:29:10'),
(9, 'renzmatthew.ybamit@gmail.com', 1, 4, 5, 'video', 'Mathematics', 1, '2025-04-22 22:07:32'),
(44, 'renzmatthew.ybamit@gmail.com', 1, 4, 5, 'read', 'Science', 1, '2025-04-22 22:09:49'),
(45, 'renzmatthew.ybamit@gmail.com', 1, 3, 5, 'video', 'Mathematics', 1, '2025-04-22 22:09:49'),
(46, 'renzmatthew.ybamit@gmail.com', 1, 5, 5, 'read', 'Mathematics', 1, '2025-04-22 22:09:49'),
(47, 'renzmatthew.ybamit@gmail.com', 1, 5, 5, 'video', 'Programming', 1, '2025-04-22 22:09:49'),
(48, 'renzmatthew.ybamit@gmail.com', 1, 3, 5, 'read', 'Programming', 1, '2025-04-22 22:09:49'),
(49, 'renzmatthew.ybamit@gmail.com', 1, 5, 5, 'video', 'Science', 1, '2025-04-22 22:09:49'),
(50, 'renzmatthew.ybamit@gmail.com', 1, 5, 5, 'read', 'Science', 1, '2025-04-22 22:09:49'),
(51, 'renzmatthew.ybamit@gmail.com', 13, 2, 5, 'read', 'History', 1, '2025-04-22 22:19:13'),
(52, 'renzmatthew.ybamit@gmail.com', 13, 3, 5, 'read', 'History', 1, '2025-04-22 22:20:06'),
(53, 'ronaldoybamit18@gmail.com', 48, 2, 5, 'video', 'General Knowledge', 58, '2025-04-22 22:22:49'),
(54, 'ronaldoybamit18@gmail.com', 14, 2, 5, 'read', 'History', 1, '2025-04-22 23:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `id` int(11) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `content_type` varchar(20) NOT NULL,
  `content_id` int(11) NOT NULL,
  `priority` int(11) DEFAULT 3,
  `is_viewed` tinyint(1) DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `password_hash` varchar(256) DEFAULT NULL,
  `profile_image` varchar(256) DEFAULT NULL,
  `date_registered` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password_hash`, `profile_image`, `date_registered`, `last_login`, `is_active`) VALUES
(1, 'test@example.com', 'Test', 'User', NULL, NULL, '2025-04-22 21:02:09', NULL, 1),
(2, 'renzmatthew.ybamit@gmail.com', 'Renz', 'Matthew', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJt4TxgotofiNBXpG-cSSAjik-s0-m8UFjgt08oC9Igp2GOQA=s96-c', '2025-04-22 21:02:55', NULL, 1),
(3, 'ronaldoybamit18@gmail.com', 'Ronaldo', 'Ybamit', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJiutjFX9FPcqAmcs6_SaQ392u1ejEH0KHbldHkPzk_CknV8w=s96-c', '2025-04-22 22:22:18', NULL, 1),
(4, 'renzmatthewy@gmail.com', 'Ybamit,', 'Renz', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJd7o_68L0FhczQm8yIiQ0mY-9OSd5-XYuSXLAzUOa_tg5KUMXF=s96-c', '2025-04-22 22:24:07', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_clusters`
--

CREATE TABLE `user_clusters` (
  `id` int(11) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `cluster_id` int(11) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_clusters`
--

INSERT INTO `user_clusters` (`id`, `user_email`, `cluster_id`, `last_updated`) VALUES
(1, 'renzmatthew.ybamit@gmail.com', 0, '2025-04-22 13:31:08'),
(2, 'renzmatthew.ybamit@gmail.com', 0, '2025-04-22 14:22:18'),
(3, 'renzmatthew.ybamit@gmail.com', 0, '2025-04-22 14:23:13'),
(4, 'ronaldoybamit18@gmail.com', 1, '2025-04-22 14:23:13'),
(5, 'renzmatthew.ybamit@gmail.com', 0, '2025-04-22 14:24:07'),
(6, 'ronaldoybamit18@gmail.com', 1, '2025-04-22 14:24:07'),
(7, 'renzmatthew.ybamit@gmail.com', 0, '2025-04-22 14:24:20'),
(8, 'ronaldoybamit18@gmail.com', 1, '2025-04-22 14:24:20');

-- --------------------------------------------------------

--
-- Table structure for table `user_performance`
--

CREATE TABLE `user_performance` (
  `id` int(11) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `avg_score` float DEFAULT 0,
  `quizzes_taken` int(11) DEFAULT 0,
  `learning_style` varchar(50) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_performance`
--

INSERT INTO `user_performance` (`id`, `user_email`, `subject`, `avg_score`, `quizzes_taken`, `learning_style`, `last_updated`) VALUES
(3, 'renzmatthew.ybamit@gmail.com', 'Mathematics', 80, 16, 'video', '2025-04-22 14:09:49'),
(6, 'renzmatthew.ybamit@gmail.com', 'History', 50, 2, 'read', '2025-04-22 14:20:06'),
(7, 'ronaldoybamit18@gmail.com', 'General Knowledge', 40, 1, 'video', '2025-04-22 14:22:49'),
(8, 'ronaldoybamit18@gmail.com', 'History', 40, 1, 'read', '2025-04-22 15:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `video_lessons`
--

CREATE TABLE `video_lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `youtube_url` varchar(255) NOT NULL,
  `level` varchar(50) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `thumbnail_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_lessons`
--

INSERT INTO `video_lessons` (`id`, `title`, `description`, `youtube_url`, `level`, `subject`, `thumbnail_url`, `created_at`) VALUES
(58, 'Introduction to Algebra', 'Learn the basics of algebra including variables, expressions, and equations.', 'https://www.youtube.com/watch?v=NybHckSEQBI', 'Beginner', 'Mathematics', 'https://img.youtube.com/vi/NybHckSEQBI/mqdefault.jpg', '2025-04-22 13:16:47'),
(59, 'Advanced Algebra Concepts', 'Dive deeper into algebraic concepts including quadratic equations and functions.', 'https://www.youtube.com/watch?v=LwCRRUa8yTU', 'Intermediate', 'Mathematics', 'https://img.youtube.com/vi/LwCRRUa8yTU/mqdefault.jpg', '2025-04-22 13:16:47'),
(60, 'Introduction to HTML and CSS', 'Learn the basics of HTML and CSS for web development.', 'https://www.youtube.com/watch?v=G3e-cpL7ofc', 'Beginner', 'Programming', 'https://img.youtube.com/vi/G3e-cpL7ofc/mqdefault.jpg', '2025-04-22 13:16:47'),
(61, 'Introduction to JavaScript', 'Learn the basics of JavaScript programming language.', 'https://www.youtube.com/watch?v=jS4aFq5-91M', 'Beginner', 'Programming', 'https://img.youtube.com/vi/jS4aFq5-91M/mqdefault.jpg', '2025-04-22 13:16:47'),
(62, 'The Basics of Physics', 'Introduction to fundamental concepts in physics.', 'https://www.youtube.com/watch?v=ZM8ECpBuQYE', 'Beginner', 'Science', 'https://img.youtube.com/vi/ZM8ECpBuQYE/mqdefault.jpg', '2025-04-22 13:16:47');

-- --------------------------------------------------------

--
-- Table structure for table `video_questions`
--

CREATE TABLE `video_questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` varchar(50) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_questions`
--

INSERT INTO `video_questions` (`id`, `quiz_id`, `question_text`, `question_type`, `points`, `created_at`) VALUES
(49, 48, 'Sample question 1 for Introduction to Algebra', '', 1, '2025-04-22 21:16:47'),
(50, 48, 'Sample question 2 for Introduction to Algebra', '', 1, '2025-04-22 21:16:47'),
(51, 48, 'Sample question 3 for Introduction to Algebra', '', 1, '2025-04-22 21:16:47'),
(52, 48, 'Sample question 4 for Introduction to Algebra', '', 1, '2025-04-22 21:16:47'),
(53, 48, 'Sample question 5 for Introduction to Algebra', '', 1, '2025-04-22 21:16:47'),
(54, 49, 'Sample question 1 for Advanced Algebra Concepts', '', 1, '2025-04-22 21:16:47'),
(55, 49, 'Sample question 2 for Advanced Algebra Concepts', '', 1, '2025-04-22 21:16:47'),
(56, 49, 'Sample question 3 for Advanced Algebra Concepts', '', 1, '2025-04-22 21:16:47'),
(57, 49, 'Sample question 4 for Advanced Algebra Concepts', '', 1, '2025-04-22 21:16:47'),
(58, 49, 'Sample question 5 for Advanced Algebra Concepts', '', 1, '2025-04-22 21:16:47'),
(59, 50, 'Sample question 1 for Introduction to HTML and CSS', '', 1, '2025-04-22 21:16:47'),
(60, 50, 'Sample question 2 for Introduction to HTML and CSS', '', 1, '2025-04-22 21:16:47'),
(61, 50, 'Sample question 3 for Introduction to HTML and CSS', '', 1, '2025-04-22 21:16:47'),
(62, 50, 'Sample question 4 for Introduction to HTML and CSS', '', 1, '2025-04-22 21:16:47'),
(63, 50, 'Sample question 5 for Introduction to HTML and CSS', '', 1, '2025-04-22 21:16:47'),
(64, 51, 'Sample question 1 for Introduction to JavaScript', '', 1, '2025-04-22 21:16:47'),
(65, 51, 'Sample question 2 for Introduction to JavaScript', '', 1, '2025-04-22 21:16:47'),
(66, 51, 'Sample question 3 for Introduction to JavaScript', '', 1, '2025-04-22 21:16:47'),
(67, 51, 'Sample question 4 for Introduction to JavaScript', '', 1, '2025-04-22 21:16:47'),
(68, 51, 'Sample question 5 for Introduction to JavaScript', '', 1, '2025-04-22 21:16:47'),
(69, 52, 'Sample question 1 for The Basics of Physics', '', 1, '2025-04-22 21:16:47'),
(70, 52, 'Sample question 2 for The Basics of Physics', '', 1, '2025-04-22 21:16:47'),
(71, 52, 'Sample question 3 for The Basics of Physics', '', 1, '2025-04-22 21:16:47'),
(72, 52, 'Sample question 4 for The Basics of Physics', '', 1, '2025-04-22 21:16:47'),
(73, 52, 'Sample question 5 for The Basics of Physics', '', 1, '2025-04-22 21:16:47');

-- --------------------------------------------------------

--
-- Table structure for table `video_question_options`
--

CREATE TABLE `video_question_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_question_options`
--

INSERT INTO `video_question_options` (`id`, `question_id`, `option_text`, `is_correct`) VALUES
(35, 49, 'Option 1 for question 1', 1),
(36, 49, 'Option 2 for question 1', 0),
(37, 49, 'Option 3 for question 1', 0),
(38, 49, 'Option 4 for question 1', 0),
(39, 50, 'Option 1 for question 2', 1),
(40, 50, 'Option 2 for question 2', 0),
(41, 50, 'Option 3 for question 2', 0),
(42, 50, 'Option 4 for question 2', 0),
(43, 51, 'Option 1 for question 3', 1),
(44, 51, 'Option 2 for question 3', 0),
(45, 51, 'Option 3 for question 3', 0),
(46, 51, 'Option 4 for question 3', 0),
(47, 52, 'Option 1 for question 4', 1),
(48, 52, 'Option 2 for question 4', 0),
(49, 52, 'Option 3 for question 4', 0),
(50, 52, 'Option 4 for question 4', 0),
(51, 53, 'Option 1 for question 5', 1),
(52, 53, 'Option 2 for question 5', 0),
(53, 53, 'Option 3 for question 5', 0),
(54, 53, 'Option 4 for question 5', 0),
(55, 54, 'Option 1 for question 1', 1),
(56, 54, 'Option 2 for question 1', 0),
(57, 54, 'Option 3 for question 1', 0),
(58, 54, 'Option 4 for question 1', 0),
(59, 55, 'Option 1 for question 2', 1),
(60, 55, 'Option 2 for question 2', 0),
(61, 55, 'Option 3 for question 2', 0),
(62, 55, 'Option 4 for question 2', 0),
(63, 56, 'Option 1 for question 3', 1),
(64, 56, 'Option 2 for question 3', 0),
(65, 56, 'Option 3 for question 3', 0),
(66, 56, 'Option 4 for question 3', 0),
(67, 57, 'Option 1 for question 4', 1),
(68, 57, 'Option 2 for question 4', 0),
(69, 57, 'Option 3 for question 4', 0),
(70, 57, 'Option 4 for question 4', 0),
(71, 58, 'Option 1 for question 5', 1),
(72, 58, 'Option 2 for question 5', 0),
(73, 58, 'Option 3 for question 5', 0),
(74, 58, 'Option 4 for question 5', 0),
(75, 59, 'Option 1 for question 1', 1),
(76, 59, 'Option 2 for question 1', 0),
(77, 59, 'Option 3 for question 1', 0),
(78, 59, 'Option 4 for question 1', 0),
(79, 60, 'Option 1 for question 2', 1),
(80, 60, 'Option 2 for question 2', 0),
(81, 60, 'Option 3 for question 2', 0),
(82, 60, 'Option 4 for question 2', 0),
(83, 61, 'Option 1 for question 3', 1),
(84, 61, 'Option 2 for question 3', 0),
(85, 61, 'Option 3 for question 3', 0),
(86, 61, 'Option 4 for question 3', 0),
(87, 62, 'Option 1 for question 4', 1),
(88, 62, 'Option 2 for question 4', 0),
(89, 62, 'Option 3 for question 4', 0),
(90, 62, 'Option 4 for question 4', 0),
(91, 63, 'Option 1 for question 5', 1),
(92, 63, 'Option 2 for question 5', 0),
(93, 63, 'Option 3 for question 5', 0),
(94, 63, 'Option 4 for question 5', 0),
(95, 64, 'Option 1 for question 1', 1),
(96, 64, 'Option 2 for question 1', 0),
(97, 64, 'Option 3 for question 1', 0),
(98, 64, 'Option 4 for question 1', 0),
(99, 65, 'Option 1 for question 2', 1),
(100, 65, 'Option 2 for question 2', 0),
(101, 65, 'Option 3 for question 2', 0),
(102, 65, 'Option 4 for question 2', 0),
(103, 66, 'Option 1 for question 3', 1),
(104, 66, 'Option 2 for question 3', 0),
(105, 66, 'Option 3 for question 3', 0),
(106, 66, 'Option 4 for question 3', 0),
(107, 67, 'Option 1 for question 4', 1),
(108, 67, 'Option 2 for question 4', 0),
(109, 67, 'Option 3 for question 4', 0),
(110, 67, 'Option 4 for question 4', 0),
(111, 68, 'Option 1 for question 5', 1),
(112, 68, 'Option 2 for question 5', 0),
(113, 68, 'Option 3 for question 5', 0),
(114, 68, 'Option 4 for question 5', 0),
(115, 69, 'Option 1 for question 1', 1),
(116, 69, 'Option 2 for question 1', 0),
(117, 69, 'Option 3 for question 1', 0),
(118, 69, 'Option 4 for question 1', 0),
(119, 70, 'Option 1 for question 2', 1),
(120, 70, 'Option 2 for question 2', 0),
(121, 70, 'Option 3 for question 2', 0),
(122, 70, 'Option 4 for question 2', 0),
(123, 71, 'Option 1 for question 3', 1),
(124, 71, 'Option 2 for question 3', 0),
(125, 71, 'Option 3 for question 3', 0),
(126, 71, 'Option 4 for question 3', 0),
(127, 72, 'Option 1 for question 4', 1),
(128, 72, 'Option 2 for question 4', 0),
(129, 72, 'Option 3 for question 4', 0),
(130, 72, 'Option 4 for question 4', 0),
(131, 73, 'Option 1 for question 5', 1),
(132, 73, 'Option 2 for question 5', 0),
(133, 73, 'Option 3 for question 5', 0),
(134, 73, 'Option 4 for question 5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `video_quizzes`
--

CREATE TABLE `video_quizzes` (
  `id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `total_points` int(11) DEFAULT 0,
  `time_stamp` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_quizzes`
--

INSERT INTO `video_quizzes` (`id`, `video_id`, `title`, `description`, `total_points`, `time_stamp`, `created_at`) VALUES
(48, 58, 'Quiz on Introduction to Algebra', 'Learn the basics of algebra including variables, expressions, and equations.', 0, 0, '2025-04-22 21:16:47'),
(49, 59, 'Quiz on Advanced Algebra Concepts', 'Dive deeper into algebraic concepts including quadratic equations and functions.', 0, 0, '2025-04-22 21:16:47'),
(50, 60, 'Quiz on Introduction to HTML and CSS', 'Learn the basics of HTML and CSS for web development.', 0, 0, '2025-04-22 21:16:47'),
(51, 61, 'Quiz on Introduction to JavaScript', 'Learn the basics of JavaScript programming language.', 0, 0, '2025-04-22 21:16:47'),
(52, 62, 'Quiz on The Basics of Physics', 'Introduction to fundamental concepts in physics.', 0, 0, '2025-04-22 21:16:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_materials`
--
ALTER TABLE `lesson_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_email` (`user_email`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `subject` (`subject`),
  ADD KEY `source` (`source`);

--
-- Indexes for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `email_2` (`email`);

--
-- Indexes for table `user_clusters`
--
ALTER TABLE `user_clusters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_performance`
--
ALTER TABLE `user_performance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`user_email`,`subject`);

--
-- Indexes for table `video_lessons`
--
ALTER TABLE `video_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_questions`
--
ALTER TABLE `video_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `video_question_options`
--
ALTER TABLE `video_question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `video_quizzes`
--
ALTER TABLE `video_quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `lesson_materials`
--
ALTER TABLE `lesson_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_clusters`
--
ALTER TABLE `user_clusters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_performance`
--
ALTER TABLE `user_performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `video_lessons`
--
ALTER TABLE `video_lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `video_questions`
--
ALTER TABLE `video_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `video_question_options`
--
ALTER TABLE `video_question_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `video_quizzes`
--
ALTER TABLE `video_quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lesson_materials`
--
ALTER TABLE `lesson_materials`
  ADD CONSTRAINT `lesson_materials_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `video_questions`
--
ALTER TABLE `video_questions`
  ADD CONSTRAINT `video_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `video_quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `video_question_options`
--
ALTER TABLE `video_question_options`
  ADD CONSTRAINT `video_question_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `video_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `video_quizzes`
--
ALTER TABLE `video_quizzes`
  ADD CONSTRAINT `video_quizzes_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video_lessons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
