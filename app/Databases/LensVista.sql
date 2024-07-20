-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2024 at 03:25 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `LensVista`
--

-- --------------------------------------------------------

--
-- Table structure for table `authentications`
--

CREATE TABLE `authentications` (
  `authentication_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_expiration` date DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `authentications`
--

INSERT INTO `authentications` (`authentication_ID`, `user_ID`, `token`, `token_expiration`, `create_date`, `update_date`) VALUES
(57, 1, '2INbUCQTtQnYOC6UHQ8G56nL2Ic0R0l7kVOtsNcOgAUgyi63jHQStLaaPk1Q', '2025-07-20', '2024-07-20 03:16:26', '2024-07-20 03:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `buyers`
--

CREATE TABLE `buyers` (
  `buyer_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `phone_number` varchar(30) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `street_name` varchar(255) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `nearest_landmark` varchar(100) DEFAULT NULL,
  `building_name/no` varchar(100) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `buyers`
--

INSERT INTO `buyers` (`buyer_ID`, `user_ID`, `phone_number`, `image_url`, `street_name`, `city`, `nearest_landmark`, `building_name/no`, `create_date`, `update_date`) VALUES
(36, 54, '01141074777', 'SGPIRUX2Ca0l2lrJA42z2SW1kZEYXvP9RBzcIYWlkPpOAUAt6KVtzmq5i3Fpp5ayuqa0qbpFwdwzEcDEt3mgvaWQL2Jz99BsCjVG.jpg', 'street 1 and 2', 'giza', 'mall', '555', '2024-07-20 03:09:47', '2024-07-20 03:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `cartItems`
--

CREATE TABLE `cartItems` (
  `cartItem_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `frame_ID` int(11) NOT NULL,
  `frameOption_ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_ID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_ID`, `name`, `description`, `image_url`, `create_date`, `update_date`) VALUES
(1, 'Sunglasses', 'Frames specifically designed to protect eyes from the sun’s harmful UV rays.', 'sunglasses.jpg', '2024-06-09 16:45:23', '2024-06-24 16:45:54'),
(2, 'Reading Glasses', 'Designed to help individuals with close-range vision issues read comfortably.', 'opened-book-eyeglasses.jpg', '2024-06-10 16:45:23', '2024-06-24 16:46:00'),
(3, 'Blue Light Blocking Glasses', 'Glasses that filter out blue light emitted by digital screens, reducing eye strain.', 'glasses-with-slightly-rounded-frame.jpg', '2024-06-11 16:45:23', '2024-06-24 16:46:04'),
(4, 'Sport Glasses', 'Durable and impact-resistant frames designed for sports and outdoor activities.', 'Sport_Glasses.jpg', '2024-06-12 16:45:23', '2024-06-24 16:46:12'),
(5, 'Fashion Glasses', 'Frames chosen for their aesthetic appeal rather than vision correction purposes.', 'Fashion_Glasses.jpg', '2024-06-13 16:45:23', '2024-06-24 16:46:16'),
(6, 'Computer Glasses', 'Designed to reduce eye strain and fatigue caused by prolonged computer use.', 'Computerz_Glasses.jpg', '2024-06-14 16:45:23', '2024-06-24 16:46:20'),
(7, 'Safety Glasses', 'Protective eyewear designed to prevent eye injuries in hazardous work environments.', 'safety-glasses-864648_640.jpg', '2024-06-15 16:45:23', '2024-06-24 16:46:23'),
(8, 'Swim Goggles', 'Goggles designed to provide clear underwater vision during swimming and water sports.', 'Swim_Goggles.jpg', '2024-06-16 16:45:23', '2024-06-24 16:46:28'),
(9, 'Prescription Glasses', 'Customized glasses with lenses tailored to individual vision correction needs.', 'Prescription_Glasses.jpg', '2024-06-17 16:45:23', '2024-06-24 16:46:32');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_ID` int(11) NOT NULL,
  `frame_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `feedback_ID` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`feedback_ID`, `first_name`, `last_name`, `email`, `phone_number`, `message`, `create_date`, `update_date`) VALUES
(12, 'mohamed', 'tarek', 'mohamedtarek234234@gmail.com', '01141074777', 'hi i am mohamed tarek', '2024-07-20 03:06:44', '2024-07-20 03:06:44');

-- --------------------------------------------------------

--
-- Table structure for table `frameImages`
--

CREATE TABLE `frameImages` (
  `frameImage_ID` int(11) NOT NULL,
  `frame_ID` int(11) NOT NULL,
  `main_image` tinyint(1) NOT NULL DEFAULT 0,
  `image_url` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `frameImages`
--

INSERT INTO `frameImages` (`frameImage_ID`, `frame_ID`, `main_image`, `image_url`, `create_date`, `update_date`) VALUES
(330, 141, 1, 'nBaN4J22PzbmWgf0bt949lyJRH1OYGDPgtNV6XTnatWg8BFXIKmNDtrDJHxRsLiWmCQaj4oPp0leVdL2JtfKjBy8beaCdBuzvcUH.jpg', '2024-07-15 04:50:13', '2024-07-15 04:50:13'),
(331, 141, 0, 'HWc7puKcf24h6gtxHPKDAdE2yLsy4PsoFaJqzHEpWepUDbfKAVlaCWbJiDU46ctod0VFR4F4K2CDVnXLhiO8omBg5I914XAOcZOr.jpg', '2024-07-15 04:50:13', '2024-07-15 04:50:13'),
(332, 141, 0, 'W9uG2coRVd63B2wvDd5c51zcdSMQhlKlHk4AXWok59T7opTzAZflQYcYIaC1XCUswaLnHQIwe1TdkeDj1rCdjwEGbh3fhsxdM5gw.jpg', '2024-07-15 04:50:13', '2024-07-15 04:50:13'),
(333, 141, 0, 'wBn3WjL73yxjrtekkn3lYEB2UTgmp5iJhx8g5wnoXlAPagGVhFKLSHP8muZRG9whQhr9ymyiFj4JaRdUFe0kRprCofJ4zqpcFd58.jpg', '2024-07-15 04:50:13', '2024-07-15 04:50:13'),
(382, 154, 1, 'BoOox9g549rsXRGBwt6HMjn5nkjoEkgDrMu1DcscVabSUi0WkbIX0muwcfyNEA4BYupxt8WN8MVJje2mdbmA6hUibCijPqGhVUo3.jpg', '2024-07-20 03:21:17', '2024-07-20 03:21:17'),
(383, 154, 0, 'EezVFa8MMis75sOtjIblAIcZEzEhHcDsFR1fyXtwkJP5nzHtxAimED4tHBtW3xIo9I85uNiUsjzfgw36skDbtkJaKTtesvxw58x4.jpg', '2024-07-20 03:21:17', '2024-07-20 03:21:17'),
(384, 154, 0, 'UepgLxK24Kvsm3Of3MnFuFF1iwpCTsgLlBDy5Ez87Pnqv75vMIEGyvTuZU7Ph1j9IiUApkQW3DxAA4q1yNSP3bqyb1NkoGxR3Wjr.jpg', '2024-07-20 03:21:17', '2024-07-20 03:21:17'),
(385, 154, 0, '9tWs4wRiLHc54qwltp1YZ4jWgZn2OjLNChO6PzQy7jI3OsLEnWWoeKEE2VnPyUs8k2qoSn82oFjvO0OF44QfoiztIr76DSmwyR5n.jpg', '2024-07-20 03:21:17', '2024-07-20 03:21:17');

-- --------------------------------------------------------

--
-- Table structure for table `frameMaterialOptions`
--

CREATE TABLE `frameMaterialOptions` (
  `frameMaterialOption_ID` int(11) NOT NULL,
  `frame_material` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `frameMaterialOptions`
--

INSERT INTO `frameMaterialOptions` (`frameMaterialOption_ID`, `frame_material`, `create_date`, `update_date`) VALUES
(1, 'Metal', '2024-07-14 17:35:28', '2024-07-14 17:35:28'),
(2, 'Plastic/Acetate', '2024-07-14 17:35:28', '2024-07-14 17:35:28'),
(3, 'Titanium', '2024-07-14 17:35:28', '2024-07-14 17:35:28'),
(4, 'TR-90', '2024-07-14 17:35:28', '2024-07-14 17:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `frameNosePadsOptions`
--

CREATE TABLE `frameNosePadsOptions` (
  `frameNosePadsOption_ID` int(11) NOT NULL,
  `frame_nose_pads` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `frameNosePadsOptions`
--

INSERT INTO `frameNosePadsOptions` (`frameNosePadsOption_ID`, `frame_nose_pads`, `create_date`, `update_date`) VALUES
(1, 'Adjustable Nose Pads', '2024-07-14 17:34:13', '2024-07-14 17:34:13'),
(2, 'Saddle Bridge', '2024-07-14 17:34:13', '2024-07-14 17:34:13');

-- --------------------------------------------------------

--
-- Table structure for table `frameOptions`
--

CREATE TABLE `frameOptions` (
  `frameOption_ID` int(11) NOT NULL,
  `frame_ID` int(11) NOT NULL,
  `main_option` tinyint(1) NOT NULL DEFAULT 0,
  `color` varchar(7) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `frame_width` varchar(3) NOT NULL,
  `bridge_width` varchar(3) NOT NULL,
  `temple_length` varchar(3) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `frameOptions`
--

INSERT INTO `frameOptions` (`frameOption_ID`, `frame_ID`, `main_option`, `color`, `quantity`, `frame_width`, `bridge_width`, `temple_length`, `create_date`, `update_date`) VALUES
(336, 141, 1, '#000000', 1, '150', '20', '140', '2024-07-15 04:50:13', '2024-07-19 00:48:03'),
(337, 141, 0, '#e5a50a', 2, '140', '16', '136', '2024-07-15 04:50:13', '2024-07-20 03:14:26'),
(355, 154, 1, '#ff0000', 7, '150', '20', '130', '2024-07-20 03:21:17', '2024-07-20 03:53:34'),
(356, 154, 0, '#ff0000', 5, '140', '20', '140', '2024-07-20 03:21:17', '2024-07-20 02:21:43');

-- --------------------------------------------------------

--
-- Table structure for table `frames`
--

CREATE TABLE `frames` (
  `frame_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `category_ID` int(11) NOT NULL,
  `model` varchar(30) NOT NULL,
  `price` double NOT NULL,
  `gender` varchar(6) NOT NULL,
  `description` text NOT NULL,
  `frameMaterialOption_ID` int(11) NOT NULL,
  `frameStyleOption_ID` int(11) NOT NULL,
  `frameShapeOption_ID` int(11) NOT NULL,
  `frameNosePadsOption_ID` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `frames`
--

INSERT INTO `frames` (`frame_ID`, `user_ID`, `category_ID`, `model`, `price`, `gender`, `description`, `frameMaterialOption_ID`, `frameStyleOption_ID`, `frameShapeOption_ID`, `frameNosePadsOption_ID`, `create_date`, `update_date`) VALUES
(141, 1, 1, 'model_1', 1500, 'male', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vel repellat sapiente, a, quod vitae explicabo doloribus voluptatum asperiores, aliquam voluptatem provident aliquid rerum in. Perspiciatis nulla ipsa perferendis eos repellat?', 1, 1, 1, 1, '2024-07-15 04:50:13', '2024-07-18 13:33:27'),
(154, 1, 1, 'model_5', 12200, 'unisex', 'mscka kasckk oacsoc kosaco  sdlcpds', 1, 2, 2, 2, '2024-07-20 03:21:17', '2024-07-20 03:21:43');

-- --------------------------------------------------------

--
-- Table structure for table `framesEvaluation`
--

CREATE TABLE `framesEvaluation` (
  `frameEvaluation_ID` int(11) NOT NULL,
  `frame_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `evaluation` tinyint(4) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `framesEvaluation`
--

INSERT INTO `framesEvaluation` (`frameEvaluation_ID`, `frame_ID`, `user_ID`, `evaluation`, `create_date`, `update_date`) VALUES
(7, 141, 54, 2, '2024-07-20 03:12:35', '2024-07-20 03:12:38');

-- --------------------------------------------------------

--
-- Table structure for table `frameShapeOptions`
--

CREATE TABLE `frameShapeOptions` (
  `frameShapeOption_ID` int(11) NOT NULL,
  `frame_shape` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `frameShapeOptions`
--

INSERT INTO `frameShapeOptions` (`frameShapeOption_ID`, `frame_shape`, `create_date`, `update_date`) VALUES
(1, 'Round', '2024-07-14 17:37:09', '2024-07-14 17:37:09'),
(2, 'Rectangular', '2024-07-14 17:37:09', '2024-07-14 17:37:09'),
(3, 'Aviator', '2024-07-14 17:37:09', '2024-07-14 17:37:09'),
(4, 'Cat-Eye', '2024-07-14 17:37:09', '2024-07-14 17:37:09'),
(5, 'Oval', '2024-07-14 17:37:09', '2024-07-14 17:37:09');

-- --------------------------------------------------------

--
-- Table structure for table `frameStyleOptions`
--

CREATE TABLE `frameStyleOptions` (
  `frameStyleOption_ID` int(11) NOT NULL,
  `frame_style` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `frameStyleOptions`
--

INSERT INTO `frameStyleOptions` (`frameStyleOption_ID`, `frame_style`, `create_date`, `update_date`) VALUES
(1, 'Full-Rim', '2024-07-14 17:43:07', '2024-07-14 17:43:07'),
(2, 'Half-Rim', '2024-07-14 17:43:07', '2024-07-14 17:43:07'),
(3, 'Rimless', '2024-07-14 17:43:07', '2024-07-14 17:43:07');

-- --------------------------------------------------------

--
-- Table structure for table `orderItems`
--

CREATE TABLE `orderItems` (
  `orderItem_ID` int(11) NOT NULL,
  `order_ID` int(11) NOT NULL,
  `frame_model` varchar(30) NOT NULL,
  `frame_price` double NOT NULL,
  `frame_gender` varchar(6) NOT NULL,
  `frame_description` text NOT NULL,
  `frame_color` varchar(7) NOT NULL,
  `frame_quantity` int(11) NOT NULL,
  `frame_material` varchar(50) NOT NULL,
  `frame_style` varchar(50) NOT NULL,
  `frame_shape` varchar(50) NOT NULL,
  `frame_nose_pads` varchar(50) NOT NULL,
  `frame_width` varchar(3) NOT NULL,
  `frame_bridge_width` varchar(3) NOT NULL,
  `frame_temple_length` varchar(3) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orderItems`
--

INSERT INTO `orderItems` (`orderItem_ID`, `order_ID`, `frame_model`, `frame_price`, `frame_gender`, `frame_description`, `frame_color`, `frame_quantity`, `frame_material`, `frame_style`, `frame_shape`, `frame_nose_pads`, `frame_width`, `frame_bridge_width`, `frame_temple_length`, `create_date`, `update_date`) VALUES
(45, 38, 'model_1', 1500, 'male', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vel repellat sapiente, a, quod vitae explicabo doloribus voluptatum asperiores, aliquam voluptatem provident aliquid rerum in. Perspiciatis nulla ipsa perferendis eos repellat?', '#e5a50a', 1, 'Metal', 'Full-Rim', 'Round', 'Adjustable Nose Pads', '140', '16', '136', '2024-07-20 03:14:26', '2024-07-20 03:14:26');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `order_status` tinyint(1) NOT NULL DEFAULT 1,
  `payment_status` tinyint(1) NOT NULL DEFAULT 0,
  `order_phase` tinyint(1) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_ID`, `user_ID`, `order_status`, `payment_status`, `order_phase`, `create_date`, `update_date`) VALUES
(38, 54, 2, 1, 3, '2024-07-20 03:14:26', '2024-07-20 03:22:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `birth_date` date NOT NULL,
  `user_role` varchar(5) NOT NULL DEFAULT 'buyer',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `verification_code` varchar(4) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `first_name`, `last_name`, `email`, `password`, `gender`, `birth_date`, `user_role`, `status`, `verification_code`, `create_date`, `update_date`) VALUES
(1, 'admin', 'tarek', 'admin@gmail.com', '$2y$10$S6uWjmIT44fCtI5BGiPloeE44PIcJCBU3NXzJSajJz505fHWQ1s42', 'male', '2004-11-08', 'admin', 1, NULL, '2024-07-03 18:33:03', '2024-07-19 03:33:06'),
(54, 'mohamed', 'tarek', 'mohamedtarek234234@gmail.com', '$2y$10$NDqVJY56CeWBhGfFh.olH.OGU4K3Cv8pR4C3/POXAyCEqxxJGXmOG', 'male', '2004-11-08', 'buyer', 1, '6093', '2024-07-20 03:09:47', '2024-07-20 03:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `wishlistItems`
--

CREATE TABLE `wishlistItems` (
  `wishlistItem_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `frame_ID` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authentications`
--
ALTER TABLE `authentications`
  ADD PRIMARY KEY (`authentication_ID`),
  ADD KEY `FK_authentication_user` (`user_ID`);

--
-- Indexes for table `buyers`
--
ALTER TABLE `buyers`
  ADD PRIMARY KEY (`buyer_ID`),
  ADD KEY `FK_buyer_user` (`user_ID`);

--
-- Indexes for table `cartItems`
--
ALTER TABLE `cartItems`
  ADD PRIMARY KEY (`cartItem_ID`),
  ADD KEY `FK_cart_user` (`user_ID`),
  ADD KEY `FK_cart_frame` (`frame_ID`),
  ADD KEY `FK_cart_frameOption` (`frameOption_ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_ID`),
  ADD UNIQUE KEY `uq_category_name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `FK_comment_user` (`user_ID`),
  ADD KEY `FK_comment_frame` (`frame_ID`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`feedback_ID`);

--
-- Indexes for table `frameImages`
--
ALTER TABLE `frameImages`
  ADD PRIMARY KEY (`frameImage_ID`),
  ADD KEY `FK_frameImage_frame` (`frame_ID`);

--
-- Indexes for table `frameMaterialOptions`
--
ALTER TABLE `frameMaterialOptions`
  ADD PRIMARY KEY (`frameMaterialOption_ID`);

--
-- Indexes for table `frameNosePadsOptions`
--
ALTER TABLE `frameNosePadsOptions`
  ADD PRIMARY KEY (`frameNosePadsOption_ID`);

--
-- Indexes for table `frameOptions`
--
ALTER TABLE `frameOptions`
  ADD PRIMARY KEY (`frameOption_ID`),
  ADD KEY `FK_frameOption_frame` (`frame_ID`);

--
-- Indexes for table `frames`
--
ALTER TABLE `frames`
  ADD PRIMARY KEY (`frame_ID`),
  ADD KEY `FK_category_frame` (`category_ID`),
  ADD KEY `FK_user_frame` (`user_ID`),
  ADD KEY `FK_frameNosePadsOption_frame` (`frameNosePadsOption_ID`),
  ADD KEY `FK_frameShapeOption_frame` (`frameShapeOption_ID`),
  ADD KEY `FK_frameStyleOption_frame` (`frameStyleOption_ID`),
  ADD KEY `FK_frameMaterialOption_frame` (`frameMaterialOption_ID`);

--
-- Indexes for table `framesEvaluation`
--
ALTER TABLE `framesEvaluation`
  ADD PRIMARY KEY (`frameEvaluation_ID`),
  ADD KEY `FK_frameEvaluation_user` (`user_ID`),
  ADD KEY `FK_frameEvaluation_frame` (`frame_ID`);

--
-- Indexes for table `frameShapeOptions`
--
ALTER TABLE `frameShapeOptions`
  ADD PRIMARY KEY (`frameShapeOption_ID`);

--
-- Indexes for table `frameStyleOptions`
--
ALTER TABLE `frameStyleOptions`
  ADD PRIMARY KEY (`frameStyleOption_ID`);

--
-- Indexes for table `orderItems`
--
ALTER TABLE `orderItems`
  ADD PRIMARY KEY (`orderItem_ID`),
  ADD KEY `FK_orderItem_order` (`order_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_ID`),
  ADD KEY `FK_order_user` (`user_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `uq_email` (`email`);

--
-- Indexes for table `wishlistItems`
--
ALTER TABLE `wishlistItems`
  ADD PRIMARY KEY (`wishlistItem_ID`),
  ADD KEY `fk_wishList_user` (`user_ID`),
  ADD KEY `fk_wishList_frame` (`frame_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authentications`
--
ALTER TABLE `authentications`
  MODIFY `authentication_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `buyers`
--
ALTER TABLE `buyers`
  MODIFY `buyer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `cartItems`
--
ALTER TABLE `cartItems`
  MODIFY `cartItem_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `feedback_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `frameImages`
--
ALTER TABLE `frameImages`
  MODIFY `frameImage_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- AUTO_INCREMENT for table `frameMaterialOptions`
--
ALTER TABLE `frameMaterialOptions`
  MODIFY `frameMaterialOption_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `frameNosePadsOptions`
--
ALTER TABLE `frameNosePadsOptions`
  MODIFY `frameNosePadsOption_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `frameOptions`
--
ALTER TABLE `frameOptions`
  MODIFY `frameOption_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=357;

--
-- AUTO_INCREMENT for table `frames`
--
ALTER TABLE `frames`
  MODIFY `frame_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `framesEvaluation`
--
ALTER TABLE `framesEvaluation`
  MODIFY `frameEvaluation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `frameShapeOptions`
--
ALTER TABLE `frameShapeOptions`
  MODIFY `frameShapeOption_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `frameStyleOptions`
--
ALTER TABLE `frameStyleOptions`
  MODIFY `frameStyleOption_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orderItems`
--
ALTER TABLE `orderItems`
  MODIFY `orderItem_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `wishlistItems`
--
ALTER TABLE `wishlistItems`
  MODIFY `wishlistItem_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authentications`
--
ALTER TABLE `authentications`
  ADD CONSTRAINT `FK_authentication_user` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `buyers`
--
ALTER TABLE `buyers`
  ADD CONSTRAINT `FK_buyer_user` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cartItems`
--
ALTER TABLE `cartItems`
  ADD CONSTRAINT `FK_cart_frame` FOREIGN KEY (`frame_ID`) REFERENCES `frames` (`frame_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cart_frameOption` FOREIGN KEY (`frameOption_ID`) REFERENCES `frameOptions` (`frameOption_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cart_user` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_comment_frame` FOREIGN KEY (`frame_ID`) REFERENCES `frames` (`frame_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_comment_user` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `frameImages`
--
ALTER TABLE `frameImages`
  ADD CONSTRAINT `FK_frameImage_frame` FOREIGN KEY (`frame_ID`) REFERENCES `frames` (`frame_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `frameOptions`
--
ALTER TABLE `frameOptions`
  ADD CONSTRAINT `FK_frameOption_frame` FOREIGN KEY (`frame_ID`) REFERENCES `frames` (`frame_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `frames`
--
ALTER TABLE `frames`
  ADD CONSTRAINT `FK_category_frame` FOREIGN KEY (`category_ID`) REFERENCES `categories` (`category_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_frameMaterialOption_frame` FOREIGN KEY (`frameMaterialOption_ID`) REFERENCES `frameMaterialOptions` (`frameMaterialOption_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_frameNosePadsOption_frame` FOREIGN KEY (`frameNosePadsOption_ID`) REFERENCES `frameNosePadsOptions` (`frameNosePadsOption_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_frameShapeOption_frame` FOREIGN KEY (`frameShapeOption_ID`) REFERENCES `frameShapeOptions` (`frameShapeOption_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_frameStyleOption_frame` FOREIGN KEY (`frameStyleOption_ID`) REFERENCES `frameStyleOptions` (`frameStyleOption_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user_frame` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `framesEvaluation`
--
ALTER TABLE `framesEvaluation`
  ADD CONSTRAINT `FK_frameEvaluation_frame` FOREIGN KEY (`frame_ID`) REFERENCES `frames` (`frame_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_frameEvaluation_user` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderItems`
--
ALTER TABLE `orderItems`
  ADD CONSTRAINT `FK_orderItem_order` FOREIGN KEY (`order_ID`) REFERENCES `orders` (`order_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_order_user` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlistItems`
--
ALTER TABLE `wishlistItems`
  ADD CONSTRAINT `fk_wishList_frame` FOREIGN KEY (`frame_ID`) REFERENCES `frames` (`frame_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wishList_user` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
