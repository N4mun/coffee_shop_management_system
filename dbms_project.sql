-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2024 at 11:11 AM
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
-- Database: `dbms_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cate_mate`
--

CREATE TABLE `cate_mate` (
  `catemate_id` int(4) NOT NULL COMMENT 'รหัสประเภทวัตถุดิบ',
  `type_mate` varchar(100) NOT NULL COMMENT 'ชื่อประเภทวัตถุดิบ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cate_prod`
--

CREATE TABLE `cate_prod` (
  `cateprod_id` int(4) NOT NULL COMMENT 'รหัสประเภทสินค้า',
  `cateprod_name` varchar(100) NOT NULL COMMENT 'ชื่อประเภทสินค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `user_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้ระบบ',
  `username` varchar(20) NOT NULL COMMENT 'ชื่อเข้าสู่ระบบ ',
  `password` varchar(20) NOT NULL COMMENT 'รหัสผ่าน',
  `f_name` varchar(100) NOT NULL COMMENT 'ชื่อ ',
  `l_name` varchar(100) NOT NULL COMMENT 'นามสกุล ',
  `sex` varchar(10) NOT NULL COMMENT 'เพศ ',
  `tel` varchar(10) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `position` varchar(20) NOT NULL COMMENT 'ตำแหน่ง',
  `date` datetime NOT NULL COMMENT 'วัน/เวลา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(8) NOT NULL COMMENT 'รหัสยอดขาย',
  `income_date` date NOT NULL COMMENT 'วันที่ ',
  `income_time` time NOT NULL COMMENT 'เวลา',
  `income_amount` varchar(5) NOT NULL COMMENT 'จำนวน ',
  `income_price` varchar(20) NOT NULL COMMENT 'ราคา ',
  `comment` varchar(20) NOT NULL COMMENT 'หมายเหตุ',
  `user_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้ระบบ ',
  `prod_id` int(8) NOT NULL COMMENT 'รหัสสินค้า '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE `ingredient` (
  `ing_id` int(8) NOT NULL COMMENT 'รหัสส่วนผสม ',
  `ing_balance` varchar(30) NOT NULL COMMENT 'ปริมาณ',
  `mate_id` int(8) NOT NULL COMMENT 'รหัสวัตถุดิบ',
  `prod_id` int(8) NOT NULL COMMENT 'รหัสสินค้า '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `mate_id` int(8) NOT NULL COMMENT 'รหัสวัตถุดิบ',
  `mate_name` varchar(150) NOT NULL COMMENT 'ชื่อวัตถุดิบ',
  `balance` varchar(30) NOT NULL COMMENT 'ปริมาณสุทธิ',
  `unit_id` int(4) NOT NULL COMMENT 'รหัสหน่วยนับ',
  `catemate_id` int(4) NOT NULL COMMENT 'รหัสประเภทวัตถุดิบ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mate_unit`
--

CREATE TABLE `mate_unit` (
  `unit_id` int(4) NOT NULL COMMENT 'รหัสหน่วยนับวัตถุดิบ',
  `unit_name` varchar(100) NOT NULL COMMENT 'ชื่อหน่วยนับวัตถุดิบ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prod_id` int(8) NOT NULL COMMENT 'รหัสสินค้า',
  `prod_name` varchar(100) NOT NULL COMMENT 'ชื่อสินค้า',
  `prod_detail` varchar(10) NOT NULL COMMENT 'ชนิดสินค้า',
  `prod_price` varchar(30) NOT NULL COMMENT 'ราคา',
  `cateprod_id` int(4) NOT NULL COMMENT 'รหัสประเภทสินค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `sto_id` int(8) NOT NULL COMMENT 'รหัสสต๊อก',
  `sto_date` date NOT NULL COMMENT 'วันที่ ',
  `mate_id` int(8) NOT NULL COMMENT 'รหัสวัตถุดิบ',
  `sto_size` varchar(10) NOT NULL COMMENT 'ขนาด ',
  `sto_amount` varchar(20) NOT NULL COMMENT 'จำนวน',
  `sto_balance` varchar(20) NOT NULL COMMENT 'ปริมาณสุทธิ',
  `sto_price` varchar(20) NOT NULL COMMENT 'ราคา ',
  `user_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้ระบบ '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cate_mate`
--
ALTER TABLE `cate_mate`
  ADD PRIMARY KEY (`catemate_id`);

--
-- Indexes for table `cate_prod`
--
ALTER TABLE `cate_prod`
  ADD PRIMARY KEY (`cateprod_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`ing_id`),
  ADD KEY `mate_id` (`mate_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`mate_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `catemate_id` (`catemate_id`);

--
-- Indexes for table `mate_unit`
--
ALTER TABLE `mate_unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `cateprod_id` (`cateprod_id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`sto_id`),
  ADD KEY `mate_id` (`mate_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cate_mate`
--
ALTER TABLE `cate_mate`
  MODIFY `catemate_id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทวัตถุดิบ';

--
-- AUTO_INCREMENT for table `cate_prod`
--
ALTER TABLE `cate_prod`
  MODIFY `cateprod_id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทสินค้า';

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ใช้ระบบ';

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'รหัสยอดขาย';

--
-- AUTO_INCREMENT for table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `ing_id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'รหัสส่วนผสม ';

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `mate_id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'รหัสวัตถุดิบ';

--
-- AUTO_INCREMENT for table `mate_unit`
--
ALTER TABLE `mate_unit`
  MODIFY `unit_id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'รหัสหน่วยนับวัตถุดิบ';

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'รหัสสินค้า';

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `sto_id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'รหัสสต๊อก';

--
-- Constraints for dumped tables
--

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `employee` (`user_id`),
  ADD CONSTRAINT `income_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `product` (`prod_id`);

--
-- Constraints for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `ingredient_ibfk_1` FOREIGN KEY (`mate_id`) REFERENCES `material` (`mate_id`),
  ADD CONSTRAINT `ingredient_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `product` (`prod_id`);

--
-- Constraints for table `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `material_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `mate_unit` (`unit_id`),
  ADD CONSTRAINT `material_ibfk_2` FOREIGN KEY (`catemate_id`) REFERENCES `cate_mate` (`catemate_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`cateprod_id`) REFERENCES `cate_prod` (`cateprod_id`);

--
-- Constraints for table `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `store_ibfk_1` FOREIGN KEY (`mate_id`) REFERENCES `material` (`mate_id`),
  ADD CONSTRAINT `store_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `employee` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
