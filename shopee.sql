-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2023 at 08:39 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopee`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive_product`
--

CREATE TABLE `archive_product` (
  `item_id` int(11) NOT NULL,
  `item_brand` varchar(200) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` double(10,2) NOT NULL,
  `small_price` double(10,2) NOT NULL,
  `medium_price` double(10,2) NOT NULL,
  `large_price` double(10,2) NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `small_image` varchar(255) NOT NULL,
  `medium_image` varchar(255) NOT NULL,
  `large_image` varchar(255) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `small_quantity` int(11) NOT NULL,
  `medium_quantity` int(11) NOT NULL,
  `large_quantity` int(11) NOT NULL,
  `item_reservation` varchar(200) NOT NULL,
  `item_register` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive_product`
--

INSERT INTO `archive_product` (`item_id`, `item_brand`, `item_name`, `item_price`, `small_price`, `medium_price`, `large_price`, `item_image`, `small_image`, `medium_image`, `large_image`, `item_quantity`, `small_quantity`, `medium_quantity`, `large_quantity`, `item_reservation`, `item_register`) VALUES
(64, 'Plants', 'Image Test', 0.00, 12.00, 13.00, 14.00, './assets/products/product-16.jpg', './assets/products/product-17.jpg', './assets/products/product-18.jpg', './assets/products/product-1.jpg', 0, 15, 16, 17, '0', '2023-06-13 13:38:48');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_brand` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_price` varchar(100) NOT NULL,
  `item_size` varchar(100) NOT NULL,
  `pot` varchar(100) NOT NULL,
  `item_image` varchar(100) NOT NULL,
  `item_quantity` varchar(100) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `item_id`, `item_brand`, `item_name`, `item_price`, `item_size`, `pot`, `item_image`, `item_quantity`) VALUES
(60, 22, 17, 'Humic', 'Cocopeat 1/4', '16.00', 'large', 'No Pot', './assets/products/product-17.jpg', '12'),
(62, 34, 5, 'Plants', 'Cactus', '175.00', 'medium', 'Glossy White Pot', './assets/products/product-5.jpg', '2');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `checkout_id` int(11) NOT NULL,
  `order_number` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_brand` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_price` varchar(100) NOT NULL,
  `item_size` varchar(100) NOT NULL,
  `pot` varchar(100) NOT NULL,
  `item_image` varchar(100) NOT NULL,
  `item_quantity` varchar(100) NOT NULL,
  `mode_of_payment` varchar(100) NOT NULL,
  `date_delivery` varchar(200) NOT NULL,
  `date_delivery_day` varchar(11) NOT NULL,
  `item_status` varchar(100) NOT NULL DEFAULT 'Processing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`checkout_id`, `order_number`, `user_id`, `customer_name`, `item_id`, `item_brand`, `item_name`, `item_price`, `item_size`, `pot`, `item_image`, `item_quantity`, `mode_of_payment`, `date_delivery`, `date_delivery_day`, `item_status`) VALUES
(86, 'Order: 000015', 22, 'Riz Mark Corpuz', 15, 'Humic', 'Humic Plus', '25.00', 'Small', 'No Pot', './assets/products/product-15.jpg', '2', 'Bank Transfer', 'Nov', '09', 'Processing'),
(87, 'Order: 000016', 22, 'Riz Mark Corpuz', 1, 'Plants', 'Florida Elise', '75.00', 'Small', 'No Pot', './assets/products/product-1.jpg', '1', 'Cash On Delivery', 'Apr', '28', 'Processing'),
(88, 'Order: 000017', 32, '', 2, 'Plants', 'Ribeye', '25.00', 'Small', 'No Pot', './assets/products/product-2.jpg', '10', 'Cash On Delivery', 'Apr 29-May 06', '', 'Processing'),
(89, 'Order: 000018', 22, 'Riz Mark Corpuz', 9, 'Plants', 'Jade Pothos', '40.00', 'Medium', 'No Pot', './assets/products/product-9.jpg', '1', 'Bank Transfer', 'Jun', '05', 'Processing'),
(90, 'Order: 000019', 22, 'Riz Mark Corpuz', 5, 'Plants', 'Cactus', '175.00', 'Medium', 'No Pot', './assets/products/product-5.jpg', '1', 'Bank Transfer', 'Jun', '07', 'Processing'),
(91, 'Order: 000020', 22, 'Riz Mark Corpuz', 12, 'Plants', 'Watermelon', '170.00', 'small', 'No Pot', './assets/products/product-12.jpg', '1', 'Bank Transfer', 'Jun', '15', 'Processing'),
(92, 'Order: 000020', 22, 'Riz Mark Corpuz', 5, 'Plants', 'Cactus', '150.00', 'medium', 'No Pot', './assets/products/product-5.jpg', '1', 'Bank Transfer', 'Jun', '15', 'Processing'),
(93, 'Order: 000020', 22, 'Riz Mark Corpuz', 10, 'Plants', 'Begonia', '130.00', 'large', 'Glossy White Pot', './assets/products/product-10.jpg', '12', 'Bank Transfer', 'Jun', '15', 'Processing'),
(94, 'Order: 000021', 22, 'Riz Mark Corpuz', 12, 'Plants', 'Watermelon', '3480.00', 'large', 'Glossy White Pot', './assets/products/product-12.jpg', '12', 'Cash On Delivery', 'Jun', '15', 'Processing'),
(95, 'Order: 000022', 22, 'Riz Mark Corpuz', 10, 'Plants', 'Begonia', '2280.00', 'large', 'Glossy White Pot', './assets/products/product-10.jpg', '12', 'Bank Transfer', 'Jun', '15', 'Processing'),
(96, 'Order: 000023', 22, 'Riz Mark Corpuz', 8, 'Plants', 'Jade Sanse', '2880.00', 'large', 'Glossy White Pot', './assets/products/product-8.jpg', '12', 'Bank Transfer', 'Jun', '15', 'Delivering'),
(97, 'Order: 000023', 22, 'Riz Mark Corpuz', 11, 'Plants', 'Thai Melo', '1200.00', 'large', 'No Pot', './assets/products/product-11.jpg', '6', 'Bank Transfer', 'Jun', '15', 'Delivering'),
(98, 'Order: 000023', 22, 'Riz Mark Corpuz', 9, 'Plants', 'Jade Pothos', '585.00', 'large', 'No Pot', './assets/products/product-9.jpg', '9', 'Bank Transfer', 'Jun', '15', 'Delivering'),
(99, 'Order: 000023', 22, 'Riz Mark Corpuz', 4, 'Plants', 'Marble Peace Lily', '1400.00', 'large', 'No Pot', './assets/products/product-4.jpg', '7', 'Bank Transfer', 'Jun', '15', 'Delivering'),
(103, 'Order: 000024', 22, '', 54, 'Plants', 'Testing', '12.00', 'Small', 'No Pot', './assets/products/product-18.jpg', '1', 'Cash On Delivery', 'Jun 15-Jun 22', '', 'Processing'),
(104, 'Order: 000025', 22, 'Riz Mark Corpuz', 2, 'Plants', 'Ribeye', '65.00', 'large', 'Glossy White Pot', './assets/products/product-2.jpg', '14', 'Cash On Delivery', 'Jun', '17', 'Processing'),
(105, 'Order: 000025', 22, 'Riz Mark Corpuz', 14, 'Pots', 'Glossy White Pot', '60.00', 'large', 'No Pot', './assets/products/product-14.jpg', '1', 'Cash On Delivery', 'Jun', '17', 'Processing'),
(106, 'Order: 000025', 22, 'Riz Mark Corpuz', 2, 'Plants', 'Ribeye', '25.00', 'small', 'Glossy White Pot', './assets/products/product-2.jpg', '21', 'Cash On Delivery', 'Jun', '17', 'Processing'),
(107, 'Order: 000025', 22, 'Riz Mark Corpuz', 11, 'Plants', 'Thai Melo', '3120.00', 'large', 'Glossy White Pot', './assets/products/product-11.jpg', '12', 'Cash On Delivery', 'Jun', '17', 'Processing'),
(108, 'Order: 000026', 22, 'Riz Mark Corpuz', 14, 'Pots', 'Glossy White Pot', '720.00', 'large', 'No Pot', './assets/products/product-14.jpg', '12', 'Bank Transfer', 'Jun', '19', 'Processing'),
(109, 'Order: 000027', 22, 'Riz Mark Corpuz', 14, 'Pots', 'Glossy White Pot', '720.00', 'large', 'No Pot', './assets/products/product-14.jpg', '12', 'Bank Transfer', 'Jun', '19', 'Processing'),
(110, 'Order: 000028', 34, 'Urban Tester', 2, 'Plants', 'Ribeye', '25.00', 'small', 'No Pot', './assets/products/product-2.jpg', '1', 'GCash', 'Jul', '21', 'Processing');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_date`
--

CREATE TABLE `delivery_date` (
  `id` int(11) NOT NULL,
  `delivery_start` varchar(100) NOT NULL,
  `delivery_end` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_date`
--

INSERT INTO `delivery_date` (`id`, `delivery_start`, `delivery_end`) VALUES
(1, '+2 days', '+3 days');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `text`, `date`, `url`, `status`) VALUES
(1, 'You have a review on a product', '2023-04-25 15:11:32', 'reviews.php', 1),
(2, 'You have a review on a product', '2023-04-25 15:11:44', 'reviews.php', 1),
(3, 'You have a reservation order to confirm', '2023-04-25 16:42:33', 'reservation.php', 1),
(4, 'You have an order to confirm', '2023-04-25 16:47:43', 'orders.php', 1),
(5, 'You have an order to confirm', '2023-06-02 21:31:40', 'orders.php', 1),
(6, 'You have an order to confirm', '2023-06-04 18:50:02', 'orders.php', 1),
(7, 'You have an order to confirm', '2023-06-12 14:45:04', 'orders.php', 0),
(8, 'You have an order to confirm', '2023-06-12 14:47:18', 'orders.php', 0),
(9, 'You have an order to confirm', '2023-06-12 14:49:36', 'orders.php', 0),
(10, 'You have an order to confirm', '2023-06-12 14:55:39', 'orders.php', 0),
(11, 'You have a reservation order to confirm', '2023-06-12 16:51:55', 'reservation.php', 0),
(12, 'You have a reservation order to confirm', '2023-06-13 10:22:23', 'reservation.php', 0),
(13, 'You have a review on a product', '2023-06-14 11:26:18', 'reviews.php', 0),
(14, 'You have a review on a product', '2023-06-14 16:13:25', 'reviews.php', 0),
(15, 'You have a review on a product', '2023-06-14 16:16:37', 'reviews.php', 0),
(16, 'You have a review on a product', '2023-06-14 16:19:49', 'reviews.php', 0),
(17, 'You have a review on a product', '2023-06-14 16:22:03', 'reviews.php', 0),
(18, 'You have a review on a product', '2023-06-14 16:24:18', 'reviews.php', 0),
(19, 'You have a review on a product', '2023-06-14 16:24:23', 'reviews.php', 0),
(20, 'You have an order to confirm', '2023-06-15 17:57:01', 'orders.php', 0),
(21, 'You have an order to confirm', '2023-06-17 17:56:31', 'orders.php', 0),
(22, 'You have an order to confirm', '2023-06-17 17:58:08', 'orders.php', 0),
(23, 'You have a review on a product', '2023-06-18 21:06:59', 'reviews.php', 0),
(24, 'You have a review on a product', '2023-06-18 21:25:43', 'reviews.php', 0),
(25, 'You have a review on a product', '2023-06-18 21:50:12', 'reviews.php', 0),
(26, 'You have a review on a product', '2023-06-18 22:24:30', 'reviews.php', 0),
(27, 'You have a review on a product', '2023-06-18 22:24:30', 'reviews.php', 0),
(28, 'You have a review on a product', '2023-06-18 22:24:30', 'reviews.php', 0),
(29, 'You have a review on a product', '2023-06-18 22:24:30', 'reviews.php', 0),
(30, 'You have a review on a product', '2023-06-18 22:24:31', 'reviews.php', 0),
(31, 'You have a review on a product', '2023-06-18 22:24:31', 'reviews.php', 0),
(32, 'You have a review on a product', '2023-06-18 22:24:31', 'reviews.php', 0),
(33, 'You have a review on a product', '2023-06-18 22:24:31', 'reviews.php', 0),
(34, 'You have a review on a product', '2023-06-18 22:25:40', 'reviews.php', 0),
(35, 'You have a review on a product', '2023-06-18 22:25:40', 'reviews.php', 0),
(36, 'You have a review on a product', '2023-06-18 22:25:40', 'reviews.php', 0),
(37, 'You have a review on a product', '2023-06-18 22:25:40', 'reviews.php', 0),
(38, 'You have a review on a product', '2023-06-18 22:25:40', 'reviews.php', 0),
(39, 'You have a review on a product', '2023-06-18 22:25:40', 'reviews.php', 0),
(40, 'You have a review on a product', '2023-06-18 22:25:40', 'reviews.php', 0),
(41, 'You have a review on a product', '2023-06-18 22:25:40', 'reviews.php', 0),
(42, 'You have a review on a product', '2023-06-18 22:27:47', 'reviews.php', 0),
(43, 'You have a review on a product', '2023-06-18 22:27:47', 'reviews.php', 0),
(44, 'You have a review on a product', '2023-06-18 22:27:47', 'reviews.php', 0),
(45, 'You have a review on a product', '2023-06-18 22:27:47', 'reviews.php', 0),
(46, 'You have a review on a product', '2023-06-18 22:27:47', 'reviews.php', 0),
(47, 'You have a review on a product', '2023-06-18 22:27:47', 'reviews.php', 0),
(48, 'You have a review on a product', '2023-06-18 22:27:47', 'reviews.php', 0),
(49, 'You have a review on a product', '2023-06-18 22:27:47', 'reviews.php', 0),
(50, 'You have a review on a product', '2023-06-18 22:28:19', 'reviews.php', 0),
(51, 'You have a review on a product', '2023-06-18 22:28:19', 'reviews.php', 0),
(52, 'You have a review on a product', '2023-06-18 22:28:19', 'reviews.php', 0),
(53, 'You have a review on a product', '2023-06-18 22:28:19', 'reviews.php', 0),
(54, 'You have a review on a product', '2023-06-18 22:28:19', 'reviews.php', 0),
(55, 'You have a review on a product', '2023-06-18 22:28:19', 'reviews.php', 0),
(56, 'You have a review on a product', '2023-06-18 22:28:19', 'reviews.php', 0),
(57, 'You have a review on a product', '2023-06-18 22:28:19', 'reviews.php', 0),
(58, 'You have a review on a product', '2023-06-18 22:28:43', 'reviews.php', 0),
(59, 'You have a review on a product', '2023-06-18 22:28:43', 'reviews.php', 0),
(60, 'You have a review on a product', '2023-06-18 22:28:43', 'reviews.php', 0),
(61, 'You have a review on a product', '2023-06-18 22:28:43', 'reviews.php', 0),
(62, 'You have a review on a product', '2023-06-18 22:28:43', 'reviews.php', 0),
(63, 'You have a review on a product', '2023-06-18 22:28:44', 'reviews.php', 0),
(64, 'You have a review on a product', '2023-06-18 22:28:44', 'reviews.php', 0),
(65, 'You have a review on a product', '2023-06-18 22:28:44', 'reviews.php', 0),
(66, 'You have a review on a product', '2023-06-18 22:39:48', 'reviews.php', 0),
(67, 'You have a review on a product', '2023-06-18 22:39:48', 'reviews.php', 0),
(68, 'You have a review on a product', '2023-06-18 22:39:48', 'reviews.php', 0),
(69, 'You have a review on a product', '2023-06-18 22:39:48', 'reviews.php', 0),
(70, 'You have a review on a product', '2023-06-18 22:39:48', 'reviews.php', 0),
(71, 'You have a review on a product', '2023-06-18 22:39:48', 'reviews.php', 0),
(72, 'You have a review on a product', '2023-06-18 22:39:48', 'reviews.php', 0),
(73, 'You have a review on a product', '2023-06-18 22:39:48', 'reviews.php', 0),
(74, 'You have a review on a product', '2023-06-18 22:40:28', 'reviews.php', 0),
(75, 'You have a review on a product', '2023-06-18 22:40:28', 'reviews.php', 0),
(76, 'You have a review on a product', '2023-06-18 22:40:28', 'reviews.php', 0),
(77, 'You have a review on a product', '2023-06-18 22:40:28', 'reviews.php', 0),
(78, 'You have a review on a product', '2023-06-18 22:40:28', 'reviews.php', 0),
(79, 'You have a review on a product', '2023-06-18 22:40:28', 'reviews.php', 0),
(80, 'You have a review on a product', '2023-06-18 22:40:29', 'reviews.php', 0),
(81, 'You have a review on a product', '2023-06-18 22:40:29', 'reviews.php', 0),
(82, 'You have a review on a product', '2023-06-18 22:44:36', 'reviews.php', 0),
(83, 'You have a review on a product', '2023-06-18 22:44:36', 'reviews.php', 0),
(84, 'You have a review on a product', '2023-06-18 22:44:37', 'reviews.php', 0),
(85, 'You have a review on a product', '2023-06-18 22:44:37', 'reviews.php', 0),
(86, 'You have a review on a product', '2023-06-18 22:44:37', 'reviews.php', 0),
(87, 'You have a review on a product', '2023-06-18 22:44:37', 'reviews.php', 0),
(88, 'You have a review on a product', '2023-06-18 22:44:37', 'reviews.php', 0),
(89, 'You have a review on a product', '2023-06-18 22:44:37', 'reviews.php', 0),
(90, 'You have a review on a product', '2023-06-18 22:45:49', 'reviews.php', 0),
(91, 'You have a review on a product', '2023-06-18 22:45:49', 'reviews.php', 0),
(92, 'You have a review on a product', '2023-06-18 22:45:49', 'reviews.php', 0),
(93, 'You have a review on a product', '2023-06-18 22:45:49', 'reviews.php', 0),
(94, 'You have a review on a product', '2023-06-18 22:45:49', 'reviews.php', 0),
(95, 'You have a review on a product', '2023-06-18 22:45:49', 'reviews.php', 0),
(96, 'You have a review on a product', '2023-06-18 22:45:49', 'reviews.php', 0),
(97, 'You have a review on a product', '2023-06-18 22:45:50', 'reviews.php', 0),
(98, 'You have a review on a product', '2023-06-18 22:46:38', 'reviews.php', 0),
(99, 'You have a review on a product', '2023-06-18 22:46:38', 'reviews.php', 0),
(100, 'You have a review on a product', '2023-06-18 22:46:38', 'reviews.php', 0),
(101, 'You have a review on a product', '2023-06-18 22:46:38', 'reviews.php', 0),
(102, 'You have a review on a product', '2023-06-18 22:46:38', 'reviews.php', 0),
(103, 'You have a review on a product', '2023-06-18 22:46:39', 'reviews.php', 0),
(104, 'You have a review on a product', '2023-06-18 22:46:39', 'reviews.php', 0),
(105, 'You have a review on a product', '2023-06-18 22:46:39', 'reviews.php', 0),
(106, 'You have a review on a product', '2023-06-18 22:51:30', 'reviews.php', 0),
(107, 'You have a review on a product', '2023-06-18 22:51:30', 'reviews.php', 0),
(108, 'You have a review on a product', '2023-06-18 22:51:30', 'reviews.php', 0),
(109, 'You have a review on a product', '2023-06-18 22:51:30', 'reviews.php', 0),
(110, 'You have a review on a product', '2023-06-18 22:51:30', 'reviews.php', 0),
(111, 'You have a review on a product', '2023-06-18 22:51:30', 'reviews.php', 0),
(112, 'You have a review on a product', '2023-06-18 22:51:31', 'reviews.php', 0),
(113, 'You have a review on a product', '2023-06-18 22:51:31', 'reviews.php', 0),
(114, 'You have a review on a product', '2023-06-19 11:13:45', 'reviews.php', 0),
(115, 'You have a review on a product', '2023-06-19 11:20:25', 'reviews.php', 0),
(116, 'You have a review on a product', '2023-06-19 11:32:31', 'reviews.php', 0),
(117, 'You have a review on a product', '2023-06-19 11:44:38', 'reviews.php', 0),
(118, 'You have a review on a product', '2023-06-19 12:00:19', 'reviews.php', 0),
(119, 'You have a review on a product', '2023-06-19 23:10:00', 'reviews.php', 0),
(120, 'You have a review on a product', '2023-06-19 23:10:10', 'reviews.php', 0),
(121, 'You have a review on a product', '2023-06-19 23:10:16', 'reviews.php', 0),
(122, 'You have a review on a product', '2023-06-19 23:10:24', 'reviews.php', 0),
(123, 'You have a review on a product', '2023-06-19 23:10:34', 'reviews.php', 0),
(124, 'You have a review on a product', '2023-06-19 23:28:15', 'reviews.php', 0),
(125, 'You have a review on a product', '2023-06-24 13:29:51', 'reviews.php', 0),
(126, 'You have a review on a product', '2023-06-24 13:30:33', 'reviews.php', 0),
(127, 'You have a review on a product', '2023-06-24 13:34:31', 'reviews.php', 0),
(128, 'You have a review on a product', '2023-06-24 13:35:23', 'reviews.php', 0),
(129, 'You have a review on a product', '2023-06-24 13:42:54', 'reviews.php', 0),
(130, 'You have a review on a product', '2023-06-24 13:45:43', 'reviews.php', 0),
(131, 'You have a review on a product', '2023-06-24 13:55:26', 'reviews.php', 0),
(132, 'You have a review on a product', '2023-06-24 13:55:57', 'reviews.php', 0),
(133, 'You have a review on a product', '2023-06-24 16:58:13', 'reviews.php', 0),
(134, 'You have a review on a product', '2023-06-24 17:21:48', 'reviews.php', 0),
(135, 'You have a review on a product', '2023-06-24 17:53:12', 'reviews.php', 0),
(136, 'You have a review on a product', '2023-06-24 17:54:01', 'reviews.php', 0),
(137, 'You have a review on a product', '2023-06-24 19:05:18', 'reviews.php', 0),
(138, 'You have a review on a product', '2023-06-24 22:24:17', 'reviews.php', 0),
(139, 'You have a review on a product', '2023-06-25 17:25:30', 'reviews.php', 0),
(140, 'You have a review on a product', '2023-06-25 17:27:04', 'reviews.php', 0),
(141, 'You have a review on a product', '2023-06-25 17:28:35', 'reviews.php', 0),
(142, 'You have a review on a product', '2023-06-25 17:29:18', 'reviews.php', 0),
(143, 'You have a review on a product', '2023-06-25 17:36:50', 'reviews.php', 0),
(144, 'You have a review on a product', '2023-06-25 20:05:27', 'reviews.php', 0),
(145, 'You have a review on a product', '2023-06-25 20:06:00', 'reviews.php', 0),
(146, 'You have a review on a product', '2023-06-25 20:38:15', 'reviews.php', 0),
(147, 'You have a review on a product', '2023-06-25 20:39:05', 'reviews.php', 0),
(148, 'You have a review on a product', '2023-06-25 20:40:46', 'reviews.php', 0),
(149, 'You have a review on a product', '2023-06-25 20:42:48', 'reviews.php', 0),
(150, 'You have a review on a product', '2023-06-25 20:44:57', 'reviews.php', 0),
(151, 'You have a review on a product', '2023-06-25 20:48:02', 'reviews.php', 0),
(152, 'You have a review on a product', '2023-06-25 21:07:11', 'reviews.php', 0),
(153, 'You have a review on a product', '2023-06-26 17:30:11', 'reviews.php', 0),
(154, 'You have a review on a product', '2023-06-26 18:08:18', 'reviews.php', 0),
(155, 'You have a review on a product', '2023-06-26 18:18:32', 'reviews.php', 0),
(156, 'You have a review on a product', '2023-06-26 18:19:15', 'reviews.php', 0),
(157, 'You have a review on a product', '2023-06-26 18:19:37', 'reviews.php', 0),
(158, 'You have a review on a product', '2023-06-26 19:49:13', 'reviews.php', 0),
(159, 'You have a review on a product', '2023-06-27 17:42:35', 'reviews.php', 0),
(160, 'You have a review on a product', '2023-06-27 17:49:00', 'reviews.php', 0),
(161, 'You have a review on a product', '2023-06-27 17:49:32', 'reviews.php', 0),
(162, 'You have a review on a product', '2023-06-27 18:11:48', 'reviews.php', 0),
(163, 'You have a review on a product', '2023-06-27 18:12:07', 'reviews.php', 0),
(164, 'You have a review on a product', '2023-06-27 18:16:24', 'reviews.php', 0),
(165, 'You have a review on a product', '2023-06-30 22:57:25', 'reviews.php', 0),
(166, 'You have a review on a product', '2023-07-16 14:41:13', 'reviews.php', 0),
(167, 'You have a review on a product', '2023-07-16 20:55:36', 'reviews.php', 0),
(168, 'You have a review on a product', '2023-07-16 20:56:05', 'reviews.php', 0),
(169, 'You have a review on a product', '2023-07-16 20:59:43', 'reviews.php', 0),
(170, 'You have a review on a product', '2023-07-16 21:00:39', 'reviews.php', 0),
(171, 'You have a review on a product', '2023-07-16 21:01:51', 'reviews.php', 0),
(172, 'You have a review on a product', '2023-07-16 21:02:57', 'reviews.php', 0),
(173, 'You have a review on a product', '2023-07-16 21:15:08', 'reviews.php', 0),
(174, 'You have a review on a product', '2023-07-16 21:17:55', 'reviews.php', 0),
(175, 'You have a review on a product', '2023-07-16 21:19:23', 'reviews.php', 0),
(176, 'You have a review on a product', '2023-07-16 21:19:50', 'reviews.php', 0),
(177, 'You have a review on a product', '2023-07-16 21:23:14', 'reviews.php', 0),
(178, 'You have a review on a product', '2023-07-16 21:30:15', 'reviews.php', 0),
(179, 'You have a review on a product', '2023-07-16 21:33:09', 'reviews.php', 0),
(180, 'You have a review on a product', '2023-07-16 21:41:04', 'reviews.php', 0),
(181, 'You have a review on a product', '2023-07-16 21:41:16', 'reviews.php', 0),
(182, 'You have a review on a product', '2023-07-16 21:42:29', 'reviews.php', 0),
(183, 'You have a review on a product', '2023-07-16 21:47:15', 'reviews.php', 0),
(184, 'You have a review on a product', '2023-07-16 21:47:59', 'reviews.php', 0),
(185, 'You have a review on a product', '2023-07-16 21:49:37', 'reviews.php', 0),
(186, 'You have a review on a product', '2023-07-16 21:50:42', 'reviews.php', 0),
(187, 'You have a review on a product', '2023-07-16 21:52:53', 'reviews.php', 0),
(188, 'You have a review on a product', '2023-07-16 21:54:26', 'reviews.php', 0),
(189, 'You have a review on a product', '2023-07-16 22:00:22', 'reviews.php', 0),
(190, 'You have a review on a product', '2023-07-16 22:01:21', 'reviews.php', 0),
(191, 'You have a review on a product', '2023-07-16 22:02:45', 'reviews.php', 0),
(192, 'You have a review on a product', '2023-07-16 22:03:23', 'reviews.php', 0),
(193, 'You have a review on a product', '2023-07-16 22:03:43', 'reviews.php', 0),
(194, 'You have a review on a product', '2023-07-16 22:04:20', 'reviews.php', 0),
(195, 'You have a review on a product', '2023-07-16 22:04:51', 'reviews.php', 0),
(196, 'You have a review on a product', '2023-07-16 22:05:10', 'reviews.php', 0),
(197, 'You have a review on a product', '2023-07-16 22:05:24', 'reviews.php', 0),
(198, 'You have a review on a product', '2023-07-16 22:07:41', 'reviews.php', 0),
(199, 'You have a review on a product', '2023-07-16 22:07:53', 'reviews.php', 0),
(200, 'You have a review on a product', '2023-07-16 22:09:47', 'reviews.php', 0),
(201, 'You have a review on a product', '2023-07-16 22:14:03', 'reviews.php', 0),
(202, 'You have a review on a product', '2023-07-16 22:15:09', 'reviews.php', 0),
(203, 'You have a review on a product', '2023-07-16 22:17:53', 'reviews.php', 0),
(204, 'You have a review on a product', '2023-07-16 22:19:32', 'reviews.php', 0),
(205, 'You have a review on a product', '2023-07-16 22:19:40', 'reviews.php', 0),
(206, 'You have a review on a product', '2023-07-16 22:21:47', 'reviews.php', 0),
(207, 'You have a review on a product', '2023-07-16 22:22:42', 'reviews.php', 0),
(208, 'You have a review on a product', '2023-07-16 22:22:53', 'reviews.php', 0),
(209, 'You have a review on a product', '2023-07-16 22:27:39', 'reviews.php', 0),
(210, 'You have a review on a product', '2023-07-16 22:28:21', 'reviews.php', 0),
(211, 'You have a review on a product', '2023-07-16 22:28:40', 'reviews.php', 0),
(212, 'You have a review on a product', '2023-07-16 22:33:37', 'reviews.php', 0),
(213, 'You have a review on a product', '2023-07-16 22:36:01', 'reviews.php', 0),
(214, 'You have a review on a product', '2023-07-16 22:36:12', 'reviews.php', 0),
(215, 'You have a review on a product', '2023-07-16 22:36:17', 'reviews.php', 0),
(216, 'You have a review on a product', '2023-07-16 22:42:43', 'reviews.php', 0),
(217, 'You have a review on a product', '2023-07-16 22:43:11', 'reviews.php', 0),
(218, 'You have a review on a product', '2023-07-16 22:43:45', 'reviews.php', 0),
(219, 'You have a review on a product', '2023-07-16 22:44:29', 'reviews.php', 0),
(220, 'You have a review on a product', '2023-07-16 23:01:58', 'reviews.php', 0),
(221, 'You have a review on a product', '2023-07-16 23:03:08', 'reviews.php', 0),
(222, 'You have a review on a product', '2023-07-16 23:03:19', 'reviews.php', 0),
(223, 'You have a review on a product', '2023-07-16 23:10:51', 'reviews.php', 0),
(224, 'You have a review on a product', '2023-07-16 23:11:03', 'reviews.php', 0),
(225, 'You have a review on a product', '2023-07-16 23:12:36', 'reviews.php', 0),
(226, 'You have a review on a product', '2023-07-16 23:12:52', 'reviews.php', 0),
(227, 'You have a review on a product', '2023-07-16 23:13:53', 'reviews.php', 0),
(228, 'You have a review on a product', '2023-07-16 23:14:06', 'reviews.php', 0),
(229, 'You have a review on a product', '2023-07-16 23:31:24', 'reviews.php', 0),
(230, 'You have a review on a product', '2023-07-16 23:31:35', 'reviews.php', 0),
(231, 'You have a review on a product', '2023-07-16 23:32:10', 'reviews.php', 0),
(232, 'You have a review on a product', '2023-07-16 23:32:43', 'reviews.php', 0),
(233, 'You have a review on a product', '2023-07-16 23:32:52', 'reviews.php', 0),
(234, 'You have a review on a product', '2023-07-16 23:33:29', 'reviews.php', 0),
(235, 'You have a review on a product', '2023-07-16 23:33:59', 'reviews.php', 0),
(236, 'You have a review on a product', '2023-07-16 23:34:53', 'reviews.php', 0),
(237, 'You have a review on a product', '2023-07-16 23:39:38', 'reviews.php', 0),
(238, 'You have a review on a product', '2023-07-16 23:41:24', 'reviews.php', 0),
(239, 'You have a review on a product', '2023-07-16 23:41:45', 'reviews.php', 0),
(240, 'You have a review on a product', '2023-07-16 23:43:35', 'reviews.php', 0),
(241, 'You have a review on a product', '2023-07-16 23:43:46', 'reviews.php', 0),
(242, 'You have a review on a product', '2023-07-16 23:44:17', 'reviews.php', 0),
(243, 'You have a review on a product', '2023-07-16 23:44:25', 'reviews.php', 0),
(244, 'You have a review on a product', '2023-07-16 23:44:45', 'reviews.php', 0),
(245, 'You have a review on a product', '2023-07-16 23:45:02', 'reviews.php', 0),
(246, 'You have a review on a product', '2023-07-16 23:45:09', 'reviews.php', 0),
(247, 'You have a review on a product', '2023-07-16 23:49:23', 'reviews.php', 0),
(248, 'You have a review on a product', '2023-07-16 23:52:41', 'reviews.php', 0),
(249, 'You have a review on a product', '2023-07-16 23:53:56', 'reviews.php', 0),
(250, 'You have a review on a product', '2023-07-16 23:54:11', 'reviews.php', 0),
(251, 'You have a review on a product', '2023-07-16 23:54:34', 'reviews.php', 0),
(252, 'You have a review on a product', '2023-07-16 23:55:28', 'reviews.php', 0),
(253, 'You have a review on a product', '2023-07-16 23:55:34', 'reviews.php', 0),
(254, 'You have a review on a product', '2023-07-16 23:55:36', 'reviews.php', 0),
(255, 'You have a review on a product', '2023-07-16 23:56:17', 'reviews.php', 0),
(256, 'You have a review on a product', '2023-07-16 23:56:49', 'reviews.php', 0),
(257, 'You have a review on a product', '2023-07-16 23:57:38', 'reviews.php', 0),
(258, 'You have an order to confirm', '2023-07-19 20:55:47', 'orders.php', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `item_id` int(11) NOT NULL,
  `item_brand` varchar(200) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` double(10,2) NOT NULL,
  `small_price` double(10,2) NOT NULL,
  `medium_price` double(10,2) NOT NULL,
  `large_price` double(10,2) NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `small_image` varchar(255) NOT NULL,
  `medium_image` varchar(255) NOT NULL,
  `large_image` varchar(255) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `small_quantity` int(11) NOT NULL,
  `medium_quantity` int(11) NOT NULL,
  `large_quantity` int(11) NOT NULL,
  `item_reservation` varchar(200) NOT NULL,
  `item_register` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`item_id`, `item_brand`, `item_name`, `item_price`, `small_price`, `medium_price`, `large_price`, `item_image`, `small_image`, `medium_image`, `large_image`, `item_quantity`, `small_quantity`, `medium_quantity`, `large_quantity`, `item_reservation`, `item_register`) VALUES
(1, 'Plants', 'Florida Elise', 75.00, 75.00, 100.00, 125.00, './assets/products/product-1.jpg', './assets/products/product-1.jpg', './assets/products/product-1.jpg', './assets/products/product-1.jpg', 21, 8, 11, 12, 'Reservation', '2022-07-22 11:47:57'),
(2, 'Plants', 'Ribeye', 25.00, 25.00, 40.00, 65.00, './assets/products/product-2.jpg', './assets/products/product-2.jpg', './assets/products/product-2.jpg', './assets/products/product-2.jpg', 21, 20, 19, 14, 'Reservation', '2022-07-22 11:47:57'),
(3, 'Plants', 'Variegated Fern', 150.00, 150.00, 175.00, 200.00, './assets/products/product-3.jpg', './assets/products/product-3.jpg', './assets/products/product-3.jpg', './assets/products/product-3.jpg', 9, 0, 12, 12, 'Reservation', '2022-07-22 11:47:57'),
(4, 'Plants', 'Marble Peace Lily', 150.00, 150.00, 175.00, 200.00, './assets/products/product-4.jpg', './assets/products/product-4.jpg', './assets/products/product-4.jpg', './assets/products/product-4.jpg', 18, 12, 12, 12, 'Reservation', '2022-07-22 11:47:57'),
(5, 'Plants', 'Cactus', 150.00, 150.00, 175.00, 200.00, './assets/products/product-5.jpg', './assets/products/product-5.jpg', './assets/products/product-5.jpg', './assets/products/product-5.jpg', 14, 12, 11, 12, '0', '2022-07-22 11:47:57'),
(6, 'Plants', 'Mayana', 15.00, 15.00, 25.00, 40.00, './assets/products/product-6.jpg', './assets/products/product-6.jpg', './assets/products/product-6.jpg', './assets/products/product-6.jpg', 19, 12, 12, 12, '0', '2022-07-22 11:47:57'),
(7, 'Plants', 'Cookies & Cream', 150.00, 150.00, 175.00, 200.00, './assets/products/product-7.jpg', './assets/products/product-7.jpg', './assets/products/product-7.jpg', './assets/products/product-7.jpg', 15, 12, 12, 12, '0', '2022-07-22 11:47:57'),
(8, 'Plants', 'Jade Sanse', 130.00, 130.00, 155.00, 180.00, './assets/products/product-8.jpg', './assets/products/product-8.jpg', './assets/products/product-8.jpg', './assets/products/product-8.jpg', 8, 12, 11, 12, '0', '2022-07-22 11:47:57'),
(9, 'Plants', 'Jade Pothos', 25.00, 25.00, 40.00, 65.00, './assets/products/product-9.jpg', './assets/products/product-9.jpg', './assets/products/product-9.jpg', './assets/products/product-9.jpg', 21, 12, 12, 14, '0', '2022-07-22 11:47:57'),
(10, 'Plants', 'Begonia', 80.00, 80.00, 105.00, 130.00, './assets/products/product-10.jpg', './assets/products/product-10.jpg', './assets/products/product-10.jpg', './assets/products/product-10.jpg', 18, 12, 12, 12, '0', '2022-07-22 11:47:57'),
(11, 'Plants', 'Thai Melo', 150.00, 150.00, 175.00, 200.00, './assets/products/product-11.jpg', './assets/products/product-11.jpg', './assets/products/product-11.jpg', './assets/products/product-11.jpg', 11, 12, 12, 12, '0', '2022-07-22 11:47:57'),
(12, 'Plants', 'Watermelon', 170.00, 170.00, 205.00, 230.00, './assets/products/product-12.jpg', './assets/products/product-12.jpg', './assets/products/product-12.jpg', './assets/products/product-12.jpg', 10, 10, 6, 12, '0', '2022-07-22 11:47:57'),
(13, 'Pots', 'Matte White Pot', 20.00, 20.00, 45.00, 60.00, './assets/products/product-13.jpg', './assets/products/product-13.jpg', './assets/products/product-13.jpg', './assets/products/product-13.jpg', 19, 12, 12, 12, '0', '2022-07-22 11:47:57'),
(14, 'Pots', 'Glossy White Pot', 20.00, 20.00, 45.00, 60.00, './assets/products/product-14.jpg', './assets/products/product-14.jpg', './assets/products/product-14.jpg', './assets/products/product-14.jpg', 0, 0, 0, 0, 'Reservation', '2022-07-22 11:47:57'),
(15, 'Humic', 'Humic Plus', 25.00, 25.00, 35.00, 45.00, './assets/products/product-15.jpg', './assets/products/product-15.jpg', './assets/products/product-15.jpg', './assets/products/product-15.jpg', 2, 10, 12, 12, '0', '2022-07-22 11:47:57'),
(16, 'Humic', 'Pumice 1/4 (corn size)', 10.00, 10.00, 15.00, 20.00, './assets/products/product-16.jpg', './assets/products/product-16.jpg', './assets/products/product-16.jpg', './assets/products/product-16.jpg', 15, 12, 12, 12, '0', '2022-07-22 11:47:57'),
(17, 'Humic', 'Cocopeat 1/4', 8.00, 8.00, 12.00, 16.00, './assets/products/product-17.jpg', './assets/products/product-17.jpg', './assets/products/product-17.jpg', './assets/products/product-17.jpg', 8, 12, 12, 12, '0', '2022-07-22 11:47:57'),
(18, 'Humic', 'Rice Hull 1/4', 7.00, 7.00, 11.00, 14.00, './assets/products/product-18.jpg', './assets/products/product-18.jpg', './assets/products/product-18.jpg', './assets/products/product-18.jpg', 14, 0, 0, 0, '0', '2022-07-22 11:47:57'),
(54, 'Plants', 'Testing', 0.00, 12.00, 13.00, 14.00, './assets/products/product-18.jpg', './assets/products/product-18.jpg', './assets/products/product-18.jpg', './assets/products/product-18.jpg', 10, 0, 0, 0, 'Reservation', '2022-09-07 11:55:42');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_brand` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_price` varchar(100) NOT NULL,
  `item_size` varchar(100) NOT NULL,
  `pot` varchar(100) NOT NULL,
  `item_image` varchar(100) NOT NULL,
  `item_quantity` varchar(100) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `user_id`, `item_id`, `item_brand`, `item_name`, `item_price`, `item_size`, `pot`, `item_image`, `item_quantity`) VALUES
(15, 22, 4, 'Plants', 'Marble Peace Lily', '200.00', 'large', 'Matte White Pot', './assets/products/product-4.jpg', '1'),
(22, 34, 4, 'Plants', 'Marble Peace Lily', '1', 'Small', 'No Pot', './assets/products/product-4.jpg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `reserve_orders`
--

CREATE TABLE `reserve_orders` (
  `reserve_id` int(11) NOT NULL,
  `reserve_number` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_brand` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_price` varchar(100) NOT NULL,
  `item_size` varchar(100) NOT NULL,
  `pot` varchar(100) NOT NULL,
  `item_image` varchar(100) NOT NULL,
  `item_quantity` varchar(100) NOT NULL,
  `mode_of_payment` varchar(100) NOT NULL,
  `item_status` varchar(100) NOT NULL DEFAULT 'Processing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reserve_orders`
--

INSERT INTO `reserve_orders` (`reserve_id`, `reserve_number`, `user_id`, `customer_name`, `item_id`, `item_brand`, `item_name`, `item_price`, `item_size`, `pot`, `item_image`, `item_quantity`, `mode_of_payment`, `item_status`) VALUES
(9, 'Order: 000002', 22, 'Riz Mark Corpuz', 54, 'Plants', 'Testing', '13.00', 'Medium', 'No Pot', './assets/products/product-18.jpg', '10', 'Bank Transfer', 'Processing'),
(10, 'Order: 000003', 22, 'Riz Mark Corpuz', 2, 'Plants', 'Ribeye', '40.00', 'Medium', 'No Pot', './assets/products/product-2.jpg', '15', 'Bank Transfer', 'Processing'),
(11, 'Order: 000003', 22, 'Riz Mark Corpuz', 54, 'Plants', 'Testing', '13.00', 'Medium', 'No Pot', './assets/products/product-18.jpg', '10', 'Bank Transfer', 'Processing'),
(13, 'Order: 000004', 22, 'Riz Mark Corpuz', 1, 'Plants', 'Florida Elise', '2220.00', 'Large', 'Glossy White Pot', './assets/products/product-1.jpg', '12', 'Bank Transfer', 'Processing'),
(14, 'Order: 000005', 22, 'Riz Mark Corpuz', 14, 'Pots', 'Glossy White Pot', '60.00', 'Small', 'No Pot', './assets/products/product-14.jpg', '8', 'Bank Transfer', 'Processing');

-- --------------------------------------------------------

--
-- Table structure for table `review_table`
--

CREATE TABLE `review_table` (
  `review_id` int(11) NOT NULL,
  `parent_id` int(40) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_rating` varchar(11) NOT NULL,
  `user_review` varchar(255) NOT NULL,
  `datetime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review_table`
--

INSERT INTO `review_table` (`review_id`, `parent_id`, `item_id`, `item_name`, `user_name`, `first_name`, `last_name`, `user_image`, `user_rating`, `user_review`, `datetime`) VALUES
(4, 0, 5, 'Cactus', 'susanoo19', 'Riz Mark', 'Corpuz', '', '1', 'adada', '1662737114'),
(5, 0, 18, 'Rice Hull 1/4', 'susanoo19', 'Riz Mark', 'Corpuz', '', '4', 'Good Quality Plant', '1667707549'),
(6, 0, 3, 'Variegated Fern', 'susanoo19', 'Riz Mark', 'Corpuz', '', '3', 'Hello', '1682406692'),
(7, 0, 10, 'Begonia', 'susanoo19', 'Riz Mark', 'Corpuz', '', '5', 'Greeat', '1682406704'),
(8, 0, 9, 'Jade Pothos', 'susanoo19', 'Riz Mark', 'Corpuz', '', '5', 'Good Plant', '1686713178'),
(9, 0, 5, 'Cactus', 'susanoo19', 'Riz Mark', 'Corpuz', '', '4', 'Testing', '1686730405'),
(11, 0, 5, 'Cactus', 'susanoo19', 'Riz Mark', 'Corpuz', '', '4', 'time test', '1686730789'),
(12, 0, 5, 'Cactus', 'susanoo19', 'Riz Mark', 'Corpuz', '', '2', 'time test v2', '1686730923'),
(14, 0, 8, 'Jade Sanse', 'susanoo19', 'Riz Mark', 'Corpuz', '', '1', 'star test', '1686731063'),
(16, 0, 1, 'Florida Elise', 'susanoo19', 'Riz Mark', 'Corpuz', '', '5', 'tesying', '1687094743'),
(17, 0, 5, 'Cactus', 'susanoo19', 'Riz Mark', 'Corpuz', '', '4', 'query test', '1687096212'),
(103, 0, 7, 'Cookies & Cream', 'susanoo19', 'Riz Mark', 'Corpuz', '', '1', 'im dumb', '1687099890'),
(106, 0, 7, 'Cookies & Cream', 'susanoo19', 'Riz Mark', 'Corpuz', '', '4', 'test again v2', '1687144425'),
(107, 0, 10, 'Begonia', 'susanoo19', 'Riz Mark', 'Corpuz', '', '4', 'testing begonia', '1687144825'),
(108, 0, 7, 'Cookies & Cream', 'testt', 'd', 'test', '', '5', 'user testing', '1687145551'),
(110, 0, 1, 'Florida Elise', 'testt', 'd', 'test', '', '4', 'review testing', '1687147219'),
(111, 0, 7, 'Cookies & Cream', 'testt', 'd', 'test', '', '4', 'star test', '1687187400'),
(113, 0, 18, 'Rice Hull 1/4', 'testt', 'd', 'test', '', '5', 'star test', '1687187416'),
(115, 0, 10, 'Begonia', 'testt', 'd', 'test', '', '4', 'star test', '1687187434'),
(116, 0, 7, 'Cookies & Cream', 'testt', 'd', 'test', '', '5', 'testing again for sure', '1687188495'),
(118, 0, 1, 'Florida Elise', 'testt', 'd', 'test', '', '4', 'florida elise', '1687600392'),
(119, 0, 8, 'Jade Sanse', 'testt', 'd', 'test', '', '1', 'Jade Sanse', '1687600441'),
(120, 0, 1, 'Florida Elise', 'testt', 'd', 'test', '', '1', 'elise florida', '1687604718'),
(124, 12, 5, 'Cactus ', 'urbangardenercavite', 'Urban', 'Gardener', './assets/LOGO.png', '0', 'time test reply v2', '1687774998'),
(126, 122, 18, 'Rice Hull 1/4 ', 'urbangardenercavite', 'Urban', 'Gardener', './assets/LOGO.png', '0', 'rice hull reply', '1687789145'),
(127, 8, 9, 'Jade Pothos ', 'urbangardenercavite', 'Urban', 'Gardener', './assets/LOGO.png', '0', 'Thanks for the reviews', '1687790440'),
(133, 0, 10, 'Begonia', 'testt', 'Urban', 'Tester', './assets/products/kyujin.jpg', '5', 'test review again', '1689512577'),
(182, 0, 9, 'Jade Pothos', 'testt', 'Urban', 'Tester', './assets/products/kyujin.jpg', '5', 'a', '1689519799'),
(183, 0, 8, 'Jade Sanse', 'testt', 'Urban', 'Tester', './assets/products/kyujin.jpg', '4', 'asda', '1689520251'),
(198, 0, 5, 'Cactus', 'testt', 'Urban', 'Tester', './assets/products/kyujin.jpg', '5', 'Good product', '1689522084'),
(210, 0, 5, 'Cactus', 'testt', 'Urban', 'Tester', './assets/products/kyujin.jpg', '5', 'Good Quality', '1689523058');

-- --------------------------------------------------------

--
-- Table structure for table `review_urban`
--

CREATE TABLE `review_urban` (
  `review_id` int(11) NOT NULL,
  `parent_id` int(40) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_rating` varchar(11) NOT NULL,
  `user_review` varchar(255) NOT NULL,
  `datetime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review_urban`
--

INSERT INTO `review_urban` (`review_id`, `parent_id`, `user_name`, `first_name`, `last_name`, `user_image`, `user_rating`, `user_review`, `datetime`) VALUES
(1, 0, 'susanoo19', 'Riz Mark', 'Corpuz', './assets/products/product-1.jpg', '5', 'a', '1687584923'),
(8, 0, 'testt', 'd', 'test', '', '5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor i', '1687616657'),
(25, 0, 'testt', 'd', 'test', '', '4', 'delete test', '1687774777'),
(26, 25, 'urbangardenercavite', 'Urban', 'Gardener', './assets/LOGO.png', '0', 'dasda', '1687774999'),
(27, 1, 'urbangardenercavite', 'Urban', 'Gardener', './assets/LOGO.png', '0', 'reply test again', '1687790212'),
(31, 0, 'testt', 'Urban', 'Tester', './assets/products/kyujin.jpg', '5', 'delete review', '1688137045');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `contact_number` varchar(100) NOT NULL,
  `billing_address` varchar(300) NOT NULL,
  `mode_of_payment` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`user_id`, `first_name`, `last_name`, `contact_number`, `billing_address`, `mode_of_payment`, `username`, `email`, `password`, `user_type`) VALUES
(1, 'Urban', 'Gardener', '09264949544', '413 Padre Pio St. Caridad, Cavite City', 'Bank Trasnfer', 'urbangardener', 'urbangardener@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 1),
(2, 'Florida', 'Elise', '09123456789', '413 Padre Pio St. Caridad, Cavite City', 'Cash On Delivery', 'floridaelise', 'floridaelise@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 1),
(22, 'Riz Mark', 'Corpuz', '09971001588', 'M. Santos St. Sta. Cruz Cavite City', 'Bank Transfer', 'susanoo19', 'susanoo.kagura3@gmail.com', '71d04088946ee65bfbf4c7c0f3bb4e5b', 1),
(40, 'test', 'test', '09971001588', 'test', '', 'Watermelon', 'testing@gmail.com', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `checkout_id` int(11) NOT NULL,
  `order_number` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_brand` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_price` varchar(100) NOT NULL,
  `item_size` varchar(100) NOT NULL,
  `pot` varchar(100) NOT NULL,
  `item_image` varchar(100) NOT NULL,
  `item_quantity` varchar(100) NOT NULL,
  `mode_of_payment` varchar(100) NOT NULL,
  `date_delivery` varchar(200) NOT NULL,
  `date_delivery_day` varchar(100) NOT NULL,
  `item_status` varchar(100) NOT NULL DEFAULT 'Processing',
  `cancel_reason` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`checkout_id`, `order_number`, `user_id`, `customer_name`, `item_id`, `item_brand`, `item_name`, `item_price`, `item_size`, `pot`, `item_image`, `item_quantity`, `mode_of_payment`, `date_delivery`, `date_delivery_day`, `item_status`, `cancel_reason`, `date`) VALUES
(25, 'Order: 000010', 22, 'Riz Mark Corpuz', 16, 'Humic', 'Pumice 1/4 (corn size)', '10.00', 'Small', 'No Pot', './assets/products/product-16.jpg', '1', 'Bank Transfer', 'Aug', '06', 'Completed', '', NULL),
(28, 'Order: 000004', 22, 'Riz Mark Corpuz', 15, 'Humic', 'Humic Plus', '25.00', 'Small', 'No Pot', './assets/products/product-15.jpg', '1', 'Cash On Delivery', 'Aug', '28', 'Completed', '', '2023-06-04 21:20:05'),
(29, 'Order: 000003', 22, 'Riz Mark Corpuz', 7, 'Plants', 'Cookies & Cream', '150.00', 'Small', 'No Pot', './assets/products/product-7.jpg', '1', 'Bank Transfer', 'Oct', '19', 'Cancelled', '', '2023-06-17 11:21:20'),
(31, 'Order: 000005', 22, 'Riz Mark Corpuz', 3, 'Plants', 'Variegated Fern', '150.00', 'Small', '', './assets/products/product-3.jpg', '1', 'Cash On Delivery', 'Aug', '30', 'Cancelled', '', '2023-06-17 11:50:36'),
(32, 'Order: 000006', 22, 'Riz Mark Corpuz', 2, 'Plants', 'Ribeye', '25.00', 'Small', '', './assets/products/product-2.jpg', '1', 'Bank Transfer', 'Aug', '29', 'Cancelled', '', '2023-06-17 11:53:37'),
(33, 'Order: 000008', 22, 'Riz Mark Corpuz', 2, 'Plants', 'Ribeye', '25.00', 'Small', '', './assets/products/product-2.jpg', '1', 'Bank Transfer', 'Aug', '27', 'Cancelled', '', '2023-06-17 12:00:23'),
(34, 'Order: 000008', 22, 'Riz Mark Corpuz', 1, 'Plants', 'Florida Elise', '75.00', 'Small', '', './assets/products/product-1.jpg', '1', 'Bank Transfer', 'Aug', '27', 'Cancelled', '', '2023-06-17 12:00:23'),
(36, 'Order: 000009', 22, 'Riz Mark Corpuz', 2, 'Plants', 'Ribeye', '25.00', 'Small', '', './assets/products/product-2.jpg', '4', 'Cash On Delivery', 'Dec', '24', 'Cancelled', 'Testing 1 2 3', '2023-06-17 12:20:59'),
(37, 'Order: 000009', 22, 'Riz Mark Corpuz', 1, 'Plants', 'Florida Elise', '75.00', 'Small', '', './assets/products/product-1.jpg', '3', 'Cash On Delivery', 'Dec', '24', 'Cancelled', 'Testing 1 2 3', '2023-06-17 12:20:59'),
(39, 'Order: 000012', 22, 'Riz Mark Corpuz', 2, 'Plants', 'Ribeye', '25.00', 'Small', '', './assets/products/product-2.jpg', '10', 'Bank Transfer', 'Aug', '30', 'Cancelled', 'Not Responsive Seller', '2023-06-17 12:26:34'),
(40, 'Order: 000012', 22, 'Riz Mark Corpuz', 1, 'Plants', 'Florida Elise', '75.00', 'Small', '', './assets/products/product-1.jpg', '1', 'Bank Transfer', 'Aug', '30', 'Cancelled', 'Not Responsive Seller', '2023-06-17 12:26:34'),
(42, 'Order: 000014', 22, 'Riz Mark Corpuz', 2, 'Plants', 'Ribeye', '65.00', 'Large', '', './assets/products/product-2.jpg', '3', 'Cash On Delivery', 'Sep', '12', 'Cancelled', 'Seller is not responsive to my inquiries', '2023-06-17 15:06:07'),
(43, 'Order: 000013', 22, 'Riz Mark Corpuz', 8, 'Plants', 'Jade Sanse', '155.00', 'Medium', '', './assets/products/product-8.jpg', '1', 'Bank Transfer', 'Sep', '12', 'Cancelled', 'wrong size', '2023-06-17 15:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `contact_number` varchar(100) NOT NULL,
  `billing_address` varchar(300) NOT NULL,
  `zipcode` varchar(100) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `contact_number`, `billing_address`, `zipcode`, `user_image`, `username`, `email`, `email_verified`, `password`, `user_type`, `date`) VALUES
(1, 'Urban', 'Gardener', '09264949544', '413 Padre Pio St. Caridad, Cavite City', 'Bank Trasnfer', './assets/products/LOGO.png', 'urbangardener', 'urbangardener@gmail.com', NULL, '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 32, NULL),
(2, 'c', 'test', '09971001588', 'c', 'Cash On Delivery', '', 'test3', 'test3@gmail.com', NULL, '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 1, NULL),
(22, 'Riz Mark', 'Corpuz', '09971001588', 'M. Santos St. Sta. Cruz Cavite City', '4102', '', 'susanoo19', 'susanoo.kagura3@gmail.com', 'susanoo.kagura3@gmail.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 1, NULL),
(29, 'a', 'test', 'test', 'a', 'Cash On Delivery', '', 'test1', 'test1@gmail.com', NULL, '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 1, NULL),
(31, 'Florida Elise', 'Supplier', '09971001588', 'M. Santos St. Sta. Cruz Cavite City', 'Cash On Delivery', '', 'floridaelise', 'floridaelise@gmail.com', NULL, '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 32, NULL),
(32, 'Riz Mark', 'Corpuz', '09971001588', 'M. Santos St. Sta. Cruz Cavite City', 'Cash On Delivery', '', 'rzmrkcrpz', 'rizmark.corpuz@gmail.com', NULL, '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 1, NULL),
(34, 'Urban', 'Tester', '09971001588', 'Cavite City', '4100', './assets/products/kyujin.jpg', 'testt', 'testt@gmail.com', 'testt@gmail.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 1, '2022-08-29 14:10:39'),
(38, 'b', 'test', '09971001588', 'b', 'Cash On Delivery', '', 'test2', 'test@gmail.com', NULL, '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 1, '2022-08-29 16:28:40'),
(45, 'Admin', 'Testing', '09971001588', 'test', '', '', 'admintesting', 'admintesting@gmail.com', NULL, '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 32, NULL),
(46, 'Riz Mark', 'Corpuz', '09971001588', 'M. Santos St. Sta. Cruz Cavite City', '', '', 'susanoob19', 'susanoo.kagura4@gmail.com', NULL, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 1, '2023-06-04 16:41:02'),
(47, 'First Name', 'Last Name', '09971001588', 'M. Santos St. Sta. Cruz Cavite City', '4101', '', 'username', 'email@gmail.com', NULL, '008c70392e3abfbd0fa47bbc2ed96aa99bd49e159727fcba0f2e6abeb3a9d601', 1, '2023-06-08 13:35:36'),
(62, 'New', 'Admin', '09971001588', 'New Admin', '', './assets/products/kyujin.jpg', 'urbangardenercavite', 'urbangardernercavite@gmail.com', NULL, '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 32, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE `verify` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `expires` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verify`
--

INSERT INTO `verify` (`id`, `code`, `expires`, `email`) VALUES
(1, 78775, 1661792234, 'test@gmail.com'),
(2, 76403, 1661792340, 'test@gmail.com'),
(3, 92030, 1661792376, 'test@gmail.com'),
(4, 77723, 1661792424, 'test@gmail.com'),
(5, 71493, 1661792439, 'test@gmail.com'),
(6, 88362, 1661792460, 'test@gmail.com'),
(7, 84924, 1661792572, 'test@gmail.com'),
(8, 49500, 1661792593, 'test@gmail.com'),
(9, 72434, 1661792594, 'test@gmail.com'),
(10, 41020, 1661792680, 'test@gmail.com'),
(11, 19969, 1661792686, 'test@gmail.com'),
(12, 51450, 1661793005, 'test@gmail.com'),
(13, 49167, 1661793031, 'test@gmail.com'),
(14, 35945, 1661793071, 'test@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `weekly_sales`
--

CREATE TABLE `weekly_sales` (
  `id` int(11) NOT NULL,
  `week` varchar(255) NOT NULL,
  `product_sold` varchar(255) NOT NULL,
  `product_profit` varchar(100) NOT NULL,
  `transaction_cancelled` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weekly_sales`
--

INSERT INTO `weekly_sales` (`id`, `week`, `product_sold`, `product_profit`, `transaction_cancelled`) VALUES
(1, 'Sep Week 1', '19', '760', '1'),
(2, 'Sep Week 2', '1', '150', '1'),
(3, 'Sep Week 3', '3', '36', '0'),
(4, 'Sep Week 4', '2', '345', '0'),
(5, 'Jan Week 1', '', '10', '1'),
(6, 'Jun Week 1', '1', '25', '0');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_brand` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_price` varchar(100) NOT NULL,
  `item_size` varchar(100) NOT NULL,
  `item_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archive_product`
--
ALTER TABLE `archive_product`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`checkout_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `delivery_date`
--
ALTER TABLE `delivery_date`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `reserve_orders`
--
ALTER TABLE `reserve_orders`
  ADD PRIMARY KEY (`reserve_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `review_table`
--
ALTER TABLE `review_table`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `review_urban`
--
ALTER TABLE `review_urban`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`checkout_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `verify`
--
ALTER TABLE `verify`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `expires` (`expires`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `weekly_sales`
--
ALTER TABLE `weekly_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`cart_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archive_product`
--
ALTER TABLE `archive_product`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `checkout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `delivery_date`
--
ALTER TABLE `delivery_date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reserve_orders`
--
ALTER TABLE `reserve_orders`
  MODIFY `reserve_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `review_table`
--
ALTER TABLE `review_table`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `review_urban`
--
ALTER TABLE `review_urban`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `checkout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `verify`
--
ALTER TABLE `verify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `weekly_sales`
--
ALTER TABLE `weekly_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
