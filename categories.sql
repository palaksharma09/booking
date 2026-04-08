-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2026 at 09:24 PM
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
-- Database: `servicebooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `slug`, `title`, `subtitle`, `description`, `image`, `created_at`) VALUES
(1, 'home', 'Home Services', 'Professional home maintenance and cleaning services', 'From deep cleaning to electrical repairs, our home service professionals are here to make your life easier. Book trusted experts for all your home needs.', 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', '2026-03-20 18:10:12'),
(2, 'salon', 'Salon Services', 'Beauty and wellness services at your doorstep', 'Pamper yourself with premium beauty services delivered to your home. Our expert stylists and beauticians use top-quality products.', 'https://images.pexels.com/photos/3993449/pexels-photo-3993449.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2', '2026-03-20 18:10:12'),
(3, 'garage', 'Garage Services', 'Expert car care and maintenance', 'Keep your vehicle in top condition with our professional garage services. From regular maintenance to emergency repairs, we\'ve got you covered.', 'https://images.unsplash.com/photo-1530046339160-ce3e530c7d2f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', '2026-03-20 18:10:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
