-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2025 at 08:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pak_cricket`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `detail` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `image_url`, `detail`, `created_at`) VALUES
(1, 'Shaheen Afridi shines in Test series!', 'Shaheen takes 10 wickets in the 2nd Test match against India.', 'https://example.com/shaheen.jpg', 'In a thrilling Test match, Shaheen Afridi took 10 wickets...', '2025-07-26 05:50:48');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `matches` int(11) DEFAULT 0,
  `runs` int(11) DEFAULT 0,
  `nationality` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `team` varchar(100) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `star_player` tinyint(1) DEFAULT 0,
  `born` varchar(100) DEFAULT NULL,
  `major_teams` varchar(255) DEFAULT NULL,
  `batting_style` varchar(100) DEFAULT NULL,
  `bowling_style` varchar(100) DEFAULT NULL,
  `overview` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `name`, `image`, `matches`, `runs`, `nationality`, `role`, `team`, `featured`, `star_player`, `born`, `major_teams`, `batting_style`, `bowling_style`, `overview`) VALUES
(1, 'Babar Azam', 'babar azam.jpg', 270, 11000, 'Pakistan', 'Batter', 'pakistan', 1, 0, '5/may/1989', 'pakitsan,peshawar zalmi', 'right handed batsman', 'right arm', 'babar azam is pakitani player born in pakitan lahore'),
(2, 'Shaheen Afridi', 'shaheen afridi.jpg', 130, 200, 'Pakistan', NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, NULL),
(3, 'Mohammad Rizwan', 'rizwan.jpeg', 150, 4800, 'Pakistan', NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, NULL),
(4, 'Shadab Khan', 'shadab khan.jpg', 140, 2300, 'Pakistan', NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, NULL),
(5, 'Fakhar Zaman', 'fakhar zaman.jpg', 160, 5100, 'Pakistan', NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, NULL),
(6, 'Muhammad Haris', 'muhammad haris.jpg', 0, 0, 'Pakistan', NULL, NULL, 0, 0, '15 October 1994', 'Pakistan, Karachi Kings', 'Right-hand bat', 'Right-arm offbreak', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `player_stats`
--

CREATE TABLE `player_stats` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `format` enum('T20','ODI','Test') DEFAULT NULL,
  `matches` int(11) DEFAULT 0,
  `innings` int(11) DEFAULT 0,
  `runs` int(11) DEFAULT 0,
  `wickets` int(11) DEFAULT 0,
  `strike_rate` float DEFAULT 0,
  `average` float DEFAULT 0,
  `hundreds` int(11) DEFAULT 0,
  `fifties` int(11) DEFAULT 0,
  `ducks` int(11) DEFAULT 0,
  `sixes` int(11) DEFAULT 0,
  `fours` int(11) DEFAULT 0,
  `highest_score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player_stats`
--

INSERT INTO `player_stats` (`id`, `player_id`, `format`, `matches`, `innings`, `runs`, `wickets`, `strike_rate`, `average`, `hundreds`, `fifties`, `ducks`, `sixes`, `fours`, `highest_score`) VALUES
(1, 1, 'T20', 100, 95, 3300, 5, 132.5, 45.5, 3, 29, 2, 100, 250, 122),
(2, 1, 'ODI', 110, 108, 5400, 8, 89.4, 57, 17, 23, 4, 120, 310, 158),
(3, 1, 'Test', 50, 90, 3900, 12, 55.2, 48.3, 8, 14, 3, 70, 190, 143);

-- --------------------------------------------------------

--
-- Table structure for table `psl_matches`
--

CREATE TABLE `psl_matches` (
  `id` int(11) NOT NULL,
  `team_1` varchar(100) DEFAULT NULL,
  `team_2` varchar(100) DEFAULT NULL,
  `match_date` date DEFAULT NULL,
  `match_time` time DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `psl_matches`
--

INSERT INTO `psl_matches` (`id`, `team_1`, `team_2`, `match_date`, `match_time`, `location`) VALUES
(1, 'Lahore Qalandars', 'Multan Sultans', '2025-02-15', '19:00:00', 'National Stadium, Karachi'),
(2, 'Karachi Kings', 'Peshawar Zalmi', '2025-02-16', '15:00:00', 'Gaddafi Stadium, Lahore'),
(3, 'Islamabad United', 'Quetta Gladiators', '2025-02-17', '19:00:00', 'Rawalpindi Cricket Stadium'),
(4, 'Multan Sultans', 'Karachi Kings', '2025-02-18', '19:00:00', 'Multan Cricket Stadium');

-- --------------------------------------------------------

--
-- Table structure for table `psl_players`
--

CREATE TABLE `psl_players` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `batting_style` varchar(100) DEFAULT NULL,
  `bowling_style` varchar(100) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `matches` int(11) DEFAULT NULL,
  `runs` int(11) DEFAULT NULL,
  `wickets` int(11) DEFAULT NULL,
  `strike_rate` float DEFAULT NULL,
  `average` float DEFAULT NULL,
  `fifties` int(11) DEFAULT NULL,
  `hundreds` int(11) DEFAULT NULL,
  `sixes` int(11) DEFAULT NULL,
  `fours` int(11) DEFAULT NULL,
  `highest_score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `psl_players`
--

INSERT INTO `psl_players` (`id`, `name`, `image`, `team_id`, `role`, `batting_style`, `bowling_style`, `nationality`, `age`, `matches`, `runs`, `wickets`, `strike_rate`, `average`, `fifties`, `hundreds`, `sixes`, `fours`, `highest_score`) VALUES
(1, 'Babar Azam', 'babar zalmi.jpg', 1, 'Captain', 'Right-hand bat', 'Right-arm offbreak', 'Pakistan', 29, 85, 2935, 0, 130.45, 45.3, 26, 5, 85, 312, 115),
(3, 'Mohammad Haris', 'haris zalmi.jpg', 1, 'Wicket-keeper Batsman', 'Right-hand bat', 'N/A', 'Pakistan', 23, 35, 762, 0, 142.2, 32.7, 5, 1, 40, 89, 86),
(6, 'Tom Kohler-Cadmore', 'tom zalmi.jpg', 1, 'Batsman', 'Right-hand bat', 'N/A', 'England', 29, 30, 798, 0, 138.5, 31.8, 6, 1, 52, 74, 92),
(7, 'Mohammad Rizwan', 'rizwan.jpg', 2, 'Captain ', 'Right-hand bat', 'Right-arm medium', 'Pakistan', 32, 75, 2200, 0, 128.5, 45.2, 16, 1, 85, 190, 104),
(8, 'Shan Masood', 'shan_masood.jpg', 2, 'Batsman', 'Left-hand bat', 'Right-arm medium', 'Pakistan', 33, 60, 1650, 2, 119.3, 30.2, 11, 0, 50, 140, 88),
(9, 'Kieron Pollard', 'ihsan zalmi.jpg', 1, 'All-rounder', 'Right-hand bat', 'Right-arm medium-fast', 'West Indies', 37, 95, 2150, 56, 145.8, 32.8, 10, 3, 112, 186, 109),
(10, 'Ihsanullah', 'ihsanullah.jpg', 2, 'Bowler', 'Right-hand bat', 'Right-arm fast', 'Pakistan', 21, 32, 120, 47, 98.2, 12.5, 0, 0, 9, 15, 20),
(11, 'Tim David', 'tim_david.jpg', 2, 'Batsman', 'Right-hand bat', 'Offbreak', 'Australia', 29, 45, 970, 5, 146.7, 34.2, 5, 2, 67, 99, 92),
(13, 'Saim Ayub', 'saim zalmi.jpg', 1, 'Batsman', 'Left handed batter', 'Right arm offbreak', 'Pakistan', 23, 89, 2297, 10, 143.29, NULL, NULL, 3, 115, 234, 98);

-- --------------------------------------------------------

--
-- Table structure for table `psl_points`
--

CREATE TABLE `psl_points` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `matches` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `losses` int(11) DEFAULT 0,
  `ties` int(11) DEFAULT 0,
  `no_result` int(11) DEFAULT 0,
  `points` int(11) DEFAULT 0,
  `nrr` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `psl_points`
--

INSERT INTO `psl_points` (`id`, `team_id`, `matches`, `wins`, `losses`, `ties`, `no_result`, `points`, `nrr`) VALUES
(1, 1, 5, 3, 2, 0, 0, 6, 0.45);

-- --------------------------------------------------------

--
-- Table structure for table `psl_teams`
--

CREATE TABLE `psl_teams` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `page_link` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `psl_teams`
--

INSERT INTO `psl_teams` (`id`, `name`, `logo`, `page_link`) VALUES
(1, 'Peshawar Zalmi', 'zalmi.png', 'zalmi.php'),
(2, 'Multan Sultans', 'multan.png', 'multan_sultans.php'),
(3, 'Lahore Qalandars', 'lahore.png', 'lahore_qalanders.php'),
(4, 'Karachi Kings', 'karachi.png', 'karachi_kings.php'),
(5, 'Quetta Gladiators', 'quetta.png', 'quetta_gladiators.php'),
(6, 'Islamabad United', 'islamabad.png', 'islamabad_united.php');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `created_at`) VALUES
(1, 'hello how are you people. welcome to my website', '2025-07-26 07:13:28'),
(2, 'welcome to this app', '2025-07-26 07:18:17'),
(4, 'hello', '2025-07-26 07:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `match_date` date NOT NULL,
  `time` varchar(10) NOT NULL,
  `team1` varchar(100) NOT NULL,
  `team2` varchar(100) NOT NULL,
  `team1_flag` varchar(255) DEFAULT NULL,
  `team2_flag` varchar(255) DEFAULT NULL,
  `venue` varchar(255) NOT NULL,
  `series_name` varchar(255) NOT NULL,
  `result` text DEFAULT NULL,
  `status` enum('upcoming','completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `match_date`, `time`, `team1`, `team2`, `team1_flag`, `team2_flag`, `venue`, `series_name`, `result`, `status`) VALUES
(1, '2025-08-05', '19:00', 'Pakistan', 'India', '/flags/pk.png', '/flags/in.png', 'Gaddafi Stadium', 'India tour of Pakistan', NULL, 'upcoming'),
(2, '2025-07-20', '18:00', 'Pakistan', 'England', '/flags/pk.png', '/flags/eng.png', 'National Stadium', 'England tour of Pakistan', 'Pakistan won by 5 wickets', 'completed'),
(3, '2025-08-10', '19:00', 'Pakistan', 'India', '/flags/pk.png', '/flags/in.png', 'Gaddafi Stadium', 'India tour of Pakistan', NULL, 'upcoming'),
(4, '2025-08-12', '13:30', 'Australia', 'New Zealand', '/flags/au.png', '/flags/nz.png', 'MCG', 'Trans-Tasman Trophy', NULL, 'upcoming'),
(7, '2025-07-15', '18:00', 'Pakistan', 'England', '/flags/pk.png', '/flags/gb.png', 'National Stadium', 'England tour of Pakistan', 'Pakistan won by 5 wickets', 'completed'),
(8, '2025-07-12', '14:00', 'India', 'Australia', '/flags/in.png', '/flags/au.png', 'Wankhede Stadium', 'Australia tour of India', 'Australia won by 3 runs', 'completed'),
(9, '2025-07-05', '11:00', 'New Zealand', 'South Africa', '/flags/nz.png', '/flags/za.png', 'Eden Park', 'SA tour of NZ', 'Match tied', 'completed'),
(10, '2025-07-01', '17:00', 'Bangladesh', 'Afghanistan', '/flags/bd.png', '/flags/af.png', 'Dhaka Stadium', 'Afghanistan tour of Bangladesh', 'Bangladesh won by 2 wickets', 'completed'),
(11, '2025-07-31', '2:30PM', 'pakisrtan', 'india', 'babar zalmi.jpg', 'babar zalmi.jpg', 'lords cricket stadium', 'rtet', '', 'upcoming'),
(12, '2025-07-31', '2:30PM', 'pakisrtan', 'india', 'babar zalmi.jpg', 'babar zalmi.jpg', 'lords cricket stadium', 'rtet', '', 'upcoming'),
(13, '2025-07-31', '2:30PM', 'pakisrtan', 'india', 'babar zalmi.jpg', 'babar zalmi.jpg', 'lords cricket stadium', 'rtet', '', 'upcoming'),
(14, '2025-07-22', '2:30PM', 'pakisrtan', 'Sri Lanka', '', '', 'lords cricket stadium', '', '', 'upcoming'),
(15, '2025-07-24', '16:00', 'Bangladesh', 'Sri Lanka', '', '', 'Sher-e-Bangla Stadium', '', '', 'upcoming');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `profile_image`) VALUES
(4, 'sayyedamaryam4', 'maryamsyed2963@gmail.com', '$2y$10$CbmSZPU3P.T20kbjlKdXNeQJZOSUkXJkAWn/rtRduv1UYVyR0ZoN6', 'user', ''),
(5, 'sayyedamaryam4', 'maryamsyed2963@gmail.com', '$2y$10$kdM6rwhLzwXOdyZw5jRKgeIaBxX0MGIT5FblV09MrQIpupX2uhpfS', 'user', ''),
(6, 'sayyedamaryam4', 'maryamsyed2963@gmail.com', '$2y$10$TuolxBvc.TXOdRVQ7CUxEeGrphz0TVAD.049jmpZYM8o8aatYDAIK', 'user', ''),
(7, 'alisha', 'maryamsyed2963@gmail.com', '$2y$10$ZRTa7UJ79N0.uoYauPJnOef/RoQkYsgYLBYT7OHxRVafYGwj0OE3e', 'admin', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player_stats`
--
ALTER TABLE `player_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Indexes for table `psl_matches`
--
ALTER TABLE `psl_matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `psl_players`
--
ALTER TABLE `psl_players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `psl_points`
--
ALTER TABLE `psl_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `psl_teams`
--
ALTER TABLE `psl_teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
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
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `player_stats`
--
ALTER TABLE `player_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `psl_matches`
--
ALTER TABLE `psl_matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `psl_players`
--
ALTER TABLE `psl_players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `psl_points`
--
ALTER TABLE `psl_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `psl_teams`
--
ALTER TABLE `psl_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `player_stats`
--
ALTER TABLE `player_stats`
  ADD CONSTRAINT `player_stats_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `psl_points`
--
ALTER TABLE `psl_points`
  ADD CONSTRAINT `psl_points_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `psl_teams` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;     
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE blog_likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_ip VARCHAR(45) NOT NULL,
    reaction ENUM('like', 'love', 'funny', 'wow', 'sad', 'angry') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_reaction (post_id, user_ip),
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE
);
CREATE TABLE blog_comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE
);

