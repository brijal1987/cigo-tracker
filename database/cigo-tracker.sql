-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 28, 2020 at 12:49 PM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cigo-tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `order_type_id` int(11) NOT NULL,
  `order_value` varchar(255) DEFAULT NULL,
  `schedule_date` date NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=>Pending,2=>Assigned,3=>On Route,4=>Done,5=>Cancelled',
  `lat` varchar(255) NOT NULL,
  `lon` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `first_name`, `last_name`, `email`, `phone`, `order_type_id`, `order_value`, `schedule_date`, `street_address`, `city`, `state`, `zip_code`, `country_id`, `status`, `lat`, `lon`, `created_at`, `updated_at`) VALUES
(1, 'Brijal', 'Savaliya', 'brijal.savaliya@gmail.com', '989865443', 2, '99.99', '2020-03-06', '1109 N Highland St', 'Arlington', 'VA', '', 2, 1, '38.886672', '-77.094735', 1582891612, 1582891612),
(2, 'Kyle', 'Howard', 'kyle@test.com', '97766665555', 1, '99.99', '2020-03-07', '525 University Ave', 'Toronto', 'ON', '', 1, 1, '41.905021', '-90.864035', 1582892009, 1582892009),
(5, 'Sam', 'William', 'brijal.savaliya@gmail.com', '989865443', 1, '99.99', '2020-03-10', '1109 N Highland St', 'Arlington', 'VA', '', 2, 1, '38.886672', '-77.094735', 1582892140, 1582892140);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
