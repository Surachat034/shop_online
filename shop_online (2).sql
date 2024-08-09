-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2024 at 06:04 AM
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
-- Table structure for table `basket`
--

CREATE TABLE `basket` (
  `basket_id` int(10) NOT NULL,
  `basket_amount` int(6) NOT NULL,
  `basket_status` varchar(10) NOT NULL DEFAULT 'P0',
  `order_ordernumber` varchar(10) DEFAULT NULL,
  `product_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `basket`
--

INSERT INTO `basket` (`basket_id`, `basket_amount`, `basket_status`, `order_ordernumber`, `product_id`, `category_id`, `member_id`) VALUES
(127, 1, 'P1', '477442969', 19, 10, 1),
(128, 1, 'P1', '477442969', 16, 10, 1),
(132, 1, 'P1', '363124253', 18, 10, 11),
(133, 1, 'P1', '759970189', 16, 10, 11),
(134, 1, 'P1', '759970189', 17, 10, 11),
(135, 1, 'P1', '194060584', 18, 10, 11),
(136, 1, 'P1', '194060584', 25, 12, 11),
(137, 2, 'P1', '355011444', 17, 10, 12),
(138, 1, 'P1', '355011444', 25, 12, 12);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(10) NOT NULL,
  `category_num` int(6) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_num`, `category_name`) VALUES
(10, 1, 'ของเล่น'),
(11, 2, 'ชุดกีฬา'),
(12, 3, 'กางเกง');

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
(11, 'admin', '1234', 'test', 'ttaann034@gmail.com', 'ds', 'xxx', 'default.png', '2024-08-06 23:01:26', 'admin'),
(12, 'test', '1234', 'test', 'ttaann034@gmail.com', 'tes', 'xxx', 'default.png', '2024-08-06 23:01:53', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `order_id` int(10) NOT NULL,
  `order_ordernumber` varchar(10) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_price` int(9) NOT NULL,
  `order_status` enum('อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน','อยู่ระหว่างการตรวจหลักฐาน','อยู่ระหว่างจัดส่งสินค้า','ส่งสินค้าสำเร็จ') NOT NULL DEFAULT 'อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน',
  `order_img` text NOT NULL,
  `member_id` int(10) NOT NULL,
  `transport_id` int(10) NOT NULL,
  `tracking_number` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`order_id`, `order_ordernumber`, `order_date`, `order_price`, `order_status`, `order_img`, `member_id`, `transport_id`, `tracking_number`) VALUES
(55, '759970189', '2024-08-07 13:53:05', 248, 'ส่งสินค้าสำเร็จ', 'ยังไม่ได้ส่งหลักฐานการโอนเงิน', 11, 1, '139907544'),
(56, '194060584', '2024-08-07 14:15:10', 238, 'ส่งสินค้าสำเร็จ', '1.png', 11, 1, '21312312312312312'),
(57, '355011444', '2024-08-09 10:55:48', 337, 'อยู่ระหว่างรอการส่งหลักฐานการโอนเงิน', 'ยังไม่ได้ส่งหลักฐานการโอนเงิน', 12, 1, NULL);

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
(2, 'SCB.jpg', 'ธ.ไทยพาณิชย์', '123', '123'),
(3, 'KTB.jpg', 'ธ.กรุงไทย', 'xx', 'xx'),
(4, 'KBANK.jpg', 'ธ.กสิกรไทย', 'xx', 'xx'),
(5, 'BBL.jpg', 'ธ.กรุงเทพ', 'xx', 'xx'),
(6, 'TMB.jpg', 'ธ.ทหารไทย', 'xx', 'xx'),
(7, 'PROMPTPAY.jpg', 'พร้อมเพย์', 'xx', 'xx');

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
  `product_stock` int(6) NOT NULL,
  `category_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_code`, `product_name`, `product_detail`, `product_img1`, `product_img2`, `product_img3`, `product_img4`, `product_price`, `product_stock`, `category_id`) VALUES
(16, 'T01', 'บล๊อกตัวต่อ', 'กล่องบล็อคตัวต่อ สีสันสวยงาม บรรจุชิ้นส่วนตัวต่อในกล่องพลาสติกอย่างดี ให้เด็กๆ ได้เสริมทักษะทางด้านความคิดสร้างสรรค์ สามารถวางบล็อกตัวต่อตามแบบ หรือตามจินตนาการได้ และยังช่วยฝึกประสาทสัมผัสของมือ', '1.jpg', '', '', '', 99, 98, 10),
(17, 'T02', 'เปียโนของเล่นเด็ก', 'อิเลคโทรนิค คีย์บอร์ด 32คีย์ \r\n- มีไมค์ และ ช่องต่อเสียงร้อง 24 Demo Song 2 Tones 2 Tempo ผลิตจากวัสดุเกรดA ปลอดภัยไม่เป็นอันตราย\r\n- 32 คีย์ จะมี 24 ตัวอย่างเพลง  2 โทน  2 จังหวะ  เพิ่ม-ลดเสียง  ไมโครโฟน    \r\n-ใช้ถ่าน AA จำนวน 4 ก้อน (ไม่รวมอยู่ในชุด)', '2.jpg', '', '', '', 149, 97, 10),
(18, 'T03', 'stuntcar', 'รถบังคับแรงๆ รถบังคับวิทยุ รถควบคุมระยะไกลโปร รถบังคับรีโมท รถบังคับเเรงๆ ล้อใหญ่ สุดแรง รีโมทออฟโรด เด็กและผู้ใหญ่ของเล่น ของเล่นเด็ก ของขวัญวันเกิด', '3.jpg', '', '', '', 199, 98, 10),
(19, 'T04', 'รถบังคับวิทยุ', 'รถบังคับวิทยุ แลมโบกินี่ R/C 1:18 มีเสียง มีไฟ ดีไซน์โฉบเฉี่ยว ของเล่นเสริมสร้างพัฒนาการ', '4.jpg', '', '', '', 149, 99, 10),
(20, 'S01', 'ชุดกีฬา XL', ' เสื้อ + กางเกง (ทั้งเซต) ชุดกีฬา XL\r\n ผ้าไมโคร ผ้านิ่ม ใส่สบาย ไม่ร้อน \r\n ใส่ได้ทั้งผู้หญิงและชาย\r\n XL    รอบอก 42 / กางเกง 28-40', 's1.jpg', '', '', '', 99, 20, 11),
(21, 'S02', 'ชุดกีฬา XL', 'เสื้อ + กางเกง (ทั้งเซต) ชุดกีฬา XL\r\nผ้าไมโคร ผ้านิ่ม ใส่สบาย ไม่ร้อน\r\nใส่ได้ทั้งผู้หญิงและชาย\r\nXL รอบอก 42 / กางเกง 28-40', 's2.jpg', '', '', '', 99, 20, 11),
(23, 'S03', 'ชุดกีฬา XL', 'เสื้อ + กางเกง (ทั้งเซต) ชุดกีฬา XL\r\nผ้าไมโคร ผ้านิ่ม ใส่สบาย ไม่ร้อน\r\nใส่ได้ทั้งผู้หญิงและชาย\r\nXL รอบอก 42 / กางเกง 28-40', 's3.jpg', '', '', '', 99, 20, 11),
(24, 'S04', 'ชุดกีฬา XL', 'เสื้อ + กางเกง (ทั้งเซต) ชุดกีฬา XL\r\nผ้าไมโคร ผ้านิ่ม ใส่สบาย ไม่ร้อน\r\nใส่ได้ทั้งผู้หญิงและชาย\r\nXL รอบอก 42 / กางเกง 28-40', 's4.jpg', '', '', '', 99, 20, 11),
(25, 'P01', 'กางเกงบ๊อกเซอร์', 'กางเกง boxer เอว 24-27 นิ้ว \r\nเอวยืดเยอะ ใส่สบาย\r\nขาสั้น', 'p1.jpg', '', '', '', 39, 18, 12);

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
(1, 'TP ร้านค้าออนไลน์', 'ttaann034@gmail.com', '31/1 ต.ทุ่งลูกนก อ.กำแพงแสน จ.นครปฐม 73140', '098484xxxx', 'TP ร้านค้าออนไลน์', 'default.png');

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `transport_id` int(10) NOT NULL,
  `transport_name` varchar(100) NOT NULL,
  `transport_price` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`transport_id`, `transport_name`, `transport_price`) VALUES
(1, 'Kerry', '50'),
(2, 'ThaiPost', '40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`basket_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

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
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`transport_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `basket`
--
ALTER TABLE `basket`
  MODIFY `basket_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `shop_information`
--
ALTER TABLE `shop_information`
  MODIFY `shop_information_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `transport_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
