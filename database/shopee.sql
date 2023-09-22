-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2020 at 11:01 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `item_id` int(11) NOT NULL,
  `item_brand` varchar(200) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` double(10,2) NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `item_register` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`item_id`, `item_brand`, `item_name`, `item_price`, `item_image`, `item_register`) VALUES
(1, 'Plants', 'Florida Elise', 75.00, './assets/products/product-1.jpg', '2022-07-22 11:47:57'), -- NOW()
(2, 'Plants', 'Ribeye', 25.00, './assets/products/product-2.jpg', '2022-07-22 11:47:57'),
(3, 'Plants', 'Variegated Fern', 150.00, './assets/products/product-3.jpg', '2022-07-22 11:47:57'),
(4, 'Plants', 'Marble Peace Lily', 150.00, './assets/products/product-4.jpg', '2022-07-22 11:47:57'),
(5, 'Plants', 'Cactus', 150.00, './assets/products/product-5.jpg', '2022-07-22 11:47:57'),
(6, 'Plants', 'Mayana', 15.00, './assets/products/product-6.jpg', '2022-07-22 11:47:57'),
(7, 'Plants', 'Cookies & Cream', 150.00, './assets/products/product-7.jpg', '2022-07-22 11:47:57'),
(8, 'Plants', 'Jade Sanse', 130.00, './assets/products/product-8.jpg', '2022-07-22 11:47:57'),
(9, 'Plants', 'Jade Pothos', 25.00, './assets/products/product-9.jpg', '2022-07-22 11:47:57'),
(10, 'Plants', 'Begonia', 80.00, './assets/products/product-10.jpg', '2022-07-22 11:47:57'),
(11, 'Plants', 'Thai Melo', 150.00, './assets/products/product-11.jpg', '2022-07-22 11:47:57'),
(12, 'Plants', 'Watermelon', 170.00, './assets/products/product-12.jpg', '2022-07-22 11:47:57'),
(13, 'Pots', 'Matte White Pot', 20.00, './assets/products/product-13.jpg', '2022-07-22 11:47:57'),
(14, 'Pots', 'Glossy White Pot', 20.00, './assets/products/product-14.jpg', '2022-07-22 11:47:57'),
(15, 'Humic', 'Humic Plus', 45.00, './assets/products/product-15.jpg', '2022-07-22 11:47:57'),
(16, 'Humic', 'Pumice 1/4 (corn size)', 10.00, './assets/products/product-16.jpg', '2022-07-22 11:47:57'),
(17, 'Humic', 'Cocopeat 1/4', 8.00, './assets/products/product-17.jpg', '2022-07-22 11:47:57'),
(18, 'Humic', 'Rice Hull 1/4', 7.00, './assets/products/product-18.jpg', '2022-07-22 11:47:57');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `register_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `register_date`) VALUES
(1, 'Urban', 'Gardener', '2022-07-22 11:47:57'),
(2, 'Deseree', 'Custodio', '2022-07-22 11:47:57');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
