-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 07:33 AM
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
-- Database: `shop_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(10) NOT NULL,
  `member_username` varchar(30) NOT NULL,
  `member_password` varchar(30) NOT NULL,
  `member_name` varchar(100) NOT NULL,
  `member_email` varchar(100) NOT NULL,
  `member_address` text NOT NULL,
  `member_tel` varchar(10) NOT NULL,
  `member_img` text NOT NULL,
  `member_date` datetime NOT NULL,
  `member_level` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `member_username`, `member_password`, `member_name`, `member_email`, `member_address`, `member_tel`, `member_img`, `member_date`, `member_level`) VALUES
(10, 'tan', '1234', '1234', '614230032@gmail.com', '31/1', '098xxxxxxx', 'default.png', '2024-05-15 01:15:30', 'user'),
(12, 'admin', '1234', 'test', '614230032@gmail.com', '31', '098xxxxxxx', 'default.png', '2024-05-15 01:24:38', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `order_id` int(10) NOT NULL,
  `order_amount` int(10) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_status` enum('อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน','อยู่ระหว่างการตรวจหลักฐาน','อยู่ระหว่างจัดส่งสินค้า','ลูกค้าได้รับสินค้าแล้ว') NOT NULL DEFAULT 'อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน',
  `order_img` text NOT NULL,
  `product_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`order_id`, `order_amount`, `order_date`, `order_status`, `order_img`, `product_id`, `member_id`) VALUES
(27, 1, '2024-05-07 01:26:11', 'อยู่ระหว่างจัดส่งสินค้า', 'ยังไม่ได้แนปหลักฐานการโอนเงิน', 9, 1),
(28, 1, '2024-05-07 01:38:45', 'อยู่ระหว่างจัดส่งสินค้า', '299882013_450262010471895_5819278240566546847_n.jpg', 9, 2),
(30, 1, '2024-05-15 13:43:25', 'อยู่ระหว่างจัดส่งสินค้า', 'ยังไม่ได้แนปหลักฐานการโอนเงิน', 15, 10);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(5) NOT NULL,
  `payment_img` text NOT NULL,
  `payment_bank_name` varchar(100) NOT NULL,
  `payment_number` varchar(20) DEFAULT NULL,
  `payment_account_name` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `payment_img`, `payment_bank_name`, `payment_number`, `payment_account_name`) VALUES
(2, 'SCB.jpg', 'ธ.ไทยพาณิชย์', '', ''),
(3, 'KTB.jpg', 'ธ.กรุงไทย', '', ''),
(4, 'KBANK.jpg', 'ธ.กสิกรไทย', '', ''),
(5, 'BBL.jpg', 'ธ.กรุงเทพ', '', ''),
(6, 'TMB.jpg', 'ธ.ทหารไทย', '', ''),
(7, 'PROMPTPAY.jpg', 'พร้อมเพย์', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(10) NOT NULL,
  `product_code` varchar(10) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_detail` text NOT NULL,
  `product_img1` text NOT NULL,
  `product_img2` text DEFAULT NULL,
  `product_img3` text DEFAULT NULL,
  `product_img4` text DEFAULT NULL,
  `product_price` int(9) NOT NULL,
  `product_stock` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_code`, `product_name`, `product_detail`, `product_img1`, `product_img2`, `product_img3`, `product_img4`, `product_price`, `product_stock`) VALUES
(14, 't1', 'ตัวต่อ buliding blocks', 'ชุดก่อสร้างคือการแบ่งประเภทชิ้นส่วนที่ได้มาตรฐาน ทำให้สามารถสร้างโมเดลต่างๆ ได้หลากหลาย', '1.jpg', '', '', '', 169, 10),
(15, 't2', 'เปียโน พร้อมไมโคโฟน', 'กุญแจชาร์จได้32ปุ่มสำหรับเด็ก, ของเล่นเพื่อการเรียนรู้ดนตรีคีย์บอร์ดสำหรับเด็ก Bigfun เล่นเปียโนและไมโครโฟน', '2.jpg', '', '', '', 199, 9),
(16, 't3', 'รถบังคับไฟฟ้า', 'รถควบคุมระยะไกล รถบังคับวิทยุพร้อมรีโมท รถไต่หิน รถบังคับ ​รถบักกี้ ล้อใหญ่ ​สุดแรง ไกล รถควบคุมระยะไกลไฟฟ้า', '3.jpg', '', '', '', 299, 10),
(17, 't4', 'รถบังคับแรมโบ', 'รถควบคุมระยะไกล รถบังคับวิทยุพร้อมรีโมท  รถบังคับ ​ ​สุดแรง ไกล รถควบคุมระยะไกลไฟฟ้า', '4.jpg', '', '', '', 169, 10),
(18, 's1', 'เสื้อกีฬา XL', 'ชุดกีฬา sport เสื้อพร้อมกางเกง\r\nเนื้อผ้าโพลีเอสเตอร์\r\nสวมใส่สบาย\r\nซับเหงื่อได้ดี\r\nซักง่ายสีไม่ตก\r\nใส่ได้ทั้งชายและหญิง\r\nกางเกงเป็นแบบขาสั้น เป็นเอวยางยืด มีเชือกให้รูดพร้อม\r\nสีกางเกง เป็นสีพื้นตามเสื้อนะคะ ยกเว้นเสื้อขาว กางเกงจะสีดำจ้า', 's1.jpg', '', '', '', 129, 5),
(19, 's2', 'เสื้อกีฬา XL', 'ชุดกีฬา sport เสื้อพร้อมกางเกง\r\nเนื้อผ้าโพลีเอสเตอร์\r\nสวมใส่สบาย\r\nซับเหงื่อได้ดี\r\nซักง่ายสีไม่ตก\r\nใส่ได้ทั้งชายและหญิง\r\nกางเกงเป็นแบบขาสั้น เป็นเอวยางยืด มีเชือกให้รูดพร้อม\r\nสีกางเกง เป็นสีพื้นตามเสื้อนะคะ ยกเว้นเสื้อขาว กางเกงจะสีดำจ้า', 's2.jpg', '', '', '', 129, 5),
(20, 's3', 'เสื้อกีฬา XL', 'ชุดกีฬา sport เสื้อพร้อมกางเกง\r\nเนื้อผ้าโพลีเอสเตอร์\r\nสวมใส่สบาย\r\nซับเหงื่อได้ดี\r\nซักง่ายสีไม่ตก\r\nใส่ได้ทั้งชายและหญิง\r\nกางเกงเป็นแบบขาสั้น เป็นเอวยางยืด มีเชือกให้รูดพร้อม\r\nสีกางเกง เป็นสีพื้นตามเสื้อนะคะ ยกเว้นเสื้อขาว กางเกงจะสีดำจ้า', 's3.jpg', '', '', '', 129, 5),
(21, 's4', 'เสื้อกีฬา XL', 'ชุดกีฬา sport เสื้อพร้อมกางเกง\r\nเนื้อผ้าโพลีเอสเตอร์\r\nสวมใส่สบาย\r\nซับเหงื่อได้ดี\r\nซักง่ายสีไม่ตก\r\nใส่ได้ทั้งชายและหญิง\r\nกางเกงเป็นแบบขาสั้น เป็นเอวยางยืด มีเชือกให้รูดพร้อม\r\nสีกางเกง เป็นสีพื้นตามเสื้อนะคะ ยกเว้นเสื้อขาว กางเกงจะสีดำจ้า', 's4.jpg', '', '', '', 129, 5);

-- --------------------------------------------------------

--
-- Table structure for table `shop_information`
--

CREATE TABLE `shop_information` (
  `shop_information_id` int(5) NOT NULL,
  `shop_information_name` varchar(100) NOT NULL,
  `shop_information_email` varchar(100) NOT NULL,
  `shop_information_address` text NOT NULL,
  `shop_information_tel` varchar(10) NOT NULL,
  `shop_information_title` varchar(100) NOT NULL,
  `shop_information_logo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `shop_information`
--

INSERT INTO `shop_information` (`shop_information_id`, `shop_information_name`, `shop_information_email`, `shop_information_address`, `shop_information_tel`, `shop_information_title`, `shop_information_logo`) VALUES
(1, 'TP ร้านค้าออนไลน์', '614230032@webmail,npru.ac.th', '31/1 หมู่1 ต.ทุ่งลูกนก อ.กำแพงแสน จ.นครปฐม\r\n', '0968043834', 'TP ร้านค้าออนไลน์', '299882013_450262010471895_5819278240566546847_n.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `shop_information`
--
ALTER TABLE `shop_information`
  ADD PRIMARY KEY (`shop_information_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `shop_information`
--
ALTER TABLE `shop_information`
  MODIFY `shop_information_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
