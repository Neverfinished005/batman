-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2025 at 04:03 PM
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
-- Database: `flight_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `flight_number` varchar(50) DEFAULT NULL,
  `travel_date` date DEFAULT NULL,
  `departure_city` varchar(100) DEFAULT NULL,
  `arrival_city` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




INSERT INTO `bookings` (`id`, `name`, `email`, `flight_number`, `travel_date`, `departure_city`, `arrival_city`, `price`) VALUES
(5, 'yug', 'jayminhaldr@gmail.com', '13', '2025-05-07', 'Mumbai', 'New York', 750.00),
(6, 'rudra', 'rudra@gmail.com', '14', '2025-04-29', 'New York', 'London', 1200.00),
(7, 'jaymin', 'yug@gmail.com', '15', '2025-04-22', 'Mumbai', 'New York', 750.00),
(8, 'dhariya', 'dhariya@gmail.com', '16', '2025-04-29', 'Delhi', 'London', 650.00),
(10, 'saugaat', 'saugaat@gmail.com', '17', '2025-05-10', 'New York', 'London', 1200.00),
(11, 'yash', 'yash@gmail.com', '13', '2025-05-03', 'Mumbai', 'New York', 750.00),
(12, 'anant', 'anant@gmail.com', '16', '2025-04-29', 'Delhi', 'Mumbai', 250.00),
(13, 'ivek', 'vivek@gmail.com', '12', '2025-04-30', 'Mumbai', 'Dubai', 300.00),
(14, 'vansh', 'vansh@gmail.com', '21', '2025-05-10', 'Chicago', 'Berlin', 800.00),
(15, 'jugal', 'jugal@gmail.com', '22', '2025-05-08', 'Rome', 'Rome', 0.00);



CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `departure_city` varchar(100) DEFAULT NULL,
  `arrival_city` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `flights` (`id`, `departure_city`, `arrival_city`, `price`) VALUES
(1, 'Mumbai', 'New York', 750.00),
(2, 'Delhi', 'London', 650.00),
(3, 'Paris', 'Dubai', 500.00),
(4, 'New York', 'Toronto', 400.00),
(5, 'Los Angeles', 'Tokyo', 950.00),
(6, 'Chicago', 'Berlin', 800.00),
(7, 'Mumbai', 'Dubai', 300.00),
(8, 'London', 'Paris', 200.00),
(9, 'San Francisco', 'Sydney', 1200.00),
(10, 'Toronto', 'Rio de Janeiro', 700.00),
(11, 'Mumbai', 'New York', 750.00),
(12, 'Delhi', 'London', 650.00),
(13, 'Paris', 'Dubai', 500.00),
(14, 'New York', 'Toronto', 400.00),
(15, 'Los Angeles', 'Tokyo', 950.00),
(16, 'Chicago', 'Berlin', 800.00),
(17, 'Mumbai', 'Dubai', 300.00),
(18, 'London', 'Paris', 200.00),

(19, 'Amsterdam', 'Copenhagen', 115.00);




ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;


ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;
COMMIT;

