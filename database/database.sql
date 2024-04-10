-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2021 at 08:43 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `projecthub`
--

-- --------------------------------------------------------

--
-- Table structure for table `allbuys`
--

CREATE TABLE `allbuys` (
  `id` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `network` varchar(255) NOT NULL,
  `walletdebit` varchar(255) NOT NULL DEFAULT 'main wallet',
  `amount` varchar(255) NOT NULL,
  `amountDeduct` varchar(255) NOT NULL,
  `bfrAmnt` varchar(255) NOT NULL,
  `AftAmnt` varchar(255) NOT NULL,
  `phoneno` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `timed` varchar(255) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `dataid` varchar(255) NOT NULL,
  `sms` varchar(255) NOT NULL,
  `recip` varchar(255) NOT NULL,
  `dnd` varchar(255) NOT NULL,
  `electrictoken` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allbuys`
--

INSERT INTO `allbuys` (`id`, `userid`, `network`, `walletdebit`, `amount`, `amountDeduct`, `bfrAmnt`, `AftAmnt`, `phoneno`, `status`, `timed`, `msg`, `product`, `category`, `dataid`, `sms`, `recip`, `dnd`, `electrictoken`) VALUES
(1, 1, 'MTN', 'main wallet', '50', '48.5', '430.00', '381.5', '08155577122', '0', 'Mon 12 April, 2021; 11:37 pm', 'Order successful', '', 'airtime', '651575081348', '', '', '', ''),
(2, 1, 'MTN', 'main wallet', '50', '48.5', '430.00', '381.5', '08155577122', '0', 'Mon 12 April, 2021; 11:43 pm', 'Order successful', '', 'airtime', '651575081348', '', '', '', ''),
(3, 1, 'MTN', 'main wallet', '50', '48.5', '430.00', '381.5', '08155577122', '0', 'Mon 12 April, 2021; 11:44 pm', 'Order successful', '', 'airtime', '651575081348', '', '', '', ''),
(4, 1, 'MTN', 'earnings wallet', '10', '9.7', '381.50', '371.8', '08155577122', '0', 'Mon 12 April, 2021; 11:47 pm', 'Order successful', '', 'airtime', '651575081348', '', '', '', ''),
(5, 1, '', 'main wallet', '', '877.5', '4430.00', '3552.5', '08155577122', '0', 'Tue 13 April, 2021; 01:32 am', 'Order successful', 'MTN 2.0GB/30days SME', 'data', '640773487386713', '', '', '', ''),
(8, 1, 'Project', 'main wallet', '', '5500', '13430.00', '7930', '', '1', 'Sun 25 April, 2021; 07:58 pm', '', 'Purchase of project topic material', 'project', '48854506826240', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(255) NOT NULL,
  `dertmentName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `dertmentName`) VALUES
(1, 'Accounting & Finance'),
(2, 'Adult Education'),
(3, 'Agric. Science Edu'),
(4, 'Agricultural Economics'),
(5, 'Agricultural Engineering'),
(6, 'Agricultural Extension'),
(7, 'Agriculture & Forestry\r\n'),
(8, 'Animal Science\r\n'),
(9, 'Applied Sciences\r\n'),
(10, 'Architecture\r\n'),
(11, 'Art & Design'),
(12, 'Banking and Finance\r\n'),
(13, 'Biochemistry\r\n'),
(14, 'Biological Sciences\r\n'),
(15, 'Botany\r\n'),
(16, 'Business admin\r\n'),
(17, 'Business Management\r\n'),
(18, 'Chemical Engineering\r\n'),
(19, 'Chemistry\r\n'),
(20, 'Civil Engineering\r\n'),
(21, 'Comm & Linguistics\r\n'),
(22, 'Computer Engineering\r\n'),
(23, 'Computer Science\r\n'),
(24, 'Cooperative Studies\r\n'),
(25, 'Criminology\r\n'),
(26, 'Crop Science\r\n'),
(27, 'Economics\r\n'),
(28, 'Education\r\n'),
(29, 'Education Foundation\r\n'),
(30, 'Elect/Electronics Engineering\r\n'),
(31, 'Engineering\r\n'),
(32, 'English\r\n'),
(33, 'English Lang & Literature\r\n'),
(34, 'Environment\r\n'),
(35, 'Estate Management\r\n'),
(36, 'French\r\n'),
(37, 'Geology\r\n'),
(38, 'History\r\n'),
(39, 'Home & Rural Economics\r\n'),
(40, 'Human Resource Mgt\r\n'),
(41, 'Industrial Chemistry\r\n'),
(42, 'International Relations\r\n'),
(43, 'Law\r\n'),
(44, 'Library and Info Science\r\n'),
(45, 'M.sc Accountancy\r\n'),
(46, 'M.sc Management\r\n'),
(47, 'Management\r\n'),
(48, 'Marketing'),
(49, 'Mass Communication\r\n'),
(50, 'Maths and Statistics\r\n'),
(51, 'Mechanical Engineering\r\n'),
(52, 'Natural\r\n'),
(53, 'Office Technology\r\n'),
(54, 'Political Science\r\n'),
(55, 'Public Administration\r\n'),
(56, 'Purchase and Supply\r\n'),
(57, 'Sciences\r\n'),
(58, 'Secretarial Administration\r\n'),
(59, 'Secretarial Studies\r\n'),
(60, 'Sociology\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `project_id` int(255) NOT NULL,
  `timed` varchar(255) NOT NULL,
  `expires_on` datetime NOT NULL,
  `download_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`id`, `userid`, `project_id`, `timed`, `expires_on`, `download_url`) VALUES
(1, 1, 7, 'Sun 25 April, 2021; 07:58 pm', '2021-04-25 22:58:33', 'vawasa0epazesenu2igegozu9'),
(2, 1, 6, 'Sun 25 April, 2021; 07:58 pm', '2021-05-25 22:58:45', 'cu0aga0uxo6ududu6uwukanum');

-- --------------------------------------------------------

--
-- Table structure for table `market`
--

CREATE TABLE `market` (
  `projectID` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `abstract` longtext NOT NULL,
  `proj_doc` varchar(255) NOT NULL,
  `no_of_pages` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `chapterno` varchar(255) NOT NULL,
  `degree_awarded` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL DEFAULT '0.00' COMMENT 'price set by admin',
  `percentage` int(255) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `downloads` varchar(255) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `market`
--

INSERT INTO `market` (`projectID`, `userid`, `project_name`, `abstract`, `proj_doc`, `no_of_pages`, `department`, `chapterno`, `degree_awarded`, `price`, `percentage`, `status`, `downloads`, `date`) VALUES
(1, 1, 'DESIGN and CONSTRUCTION OF HOME DISPENSER', 'Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract ', 'hnd complain.docx', '43', '51', '12', 'hnd', '3000', 0, '1', '15', 'Sat 10 April, 2021; 11:39 pm'),
(2, 1, 'DESIGN and CONSTRUCTION OF GEN WASHER', 'Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract ', 'hnd complain.docx', '43', '51', '12', 'msc', '1450', 0, '0', '2', 'Sat 10 April, 2021; 11:40 pm'),
(3, 1, 'DESIGN and CONSTRUCTION OF GSM BASED CONTROLLER', 'Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract ', 'hnd complain.docx', '43', '51', '12', 'hnd', '2500', 0, '2', '0', 'Sat 10 April, 2021; 11:40 pm'),
(4, 1, 'DESIGN and CONSTRUCTION OF WASHING DISH', 'Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract ', 'hnd complain.docx', '43', '51', '12', 'msc', '3500', 0, '0', '0', 'Sat 10 April, 2021; 11:41 pm'),
(5, 1, 'DESIGN and IMPLEMENTATION OF SCHOOL BASED ATTENDANCE SYSTEM', 'Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract ', 'hnd complain.docx', '43', '51', '12', 'hnd', '1850', 0, '0', '0', 'Sat 10 April, 2021; 11:42 pm'),
(6, 1, 'DESIGN and CONSTRUCTION OF AUTOMATED AIR CONDITIONER', 'Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract ', 'hnd complain.docx', '43', '37', '12', 'hnd', '4250', 0, '1', '52', 'Sat 10 April, 2021; 11:42 pm'),
(7, 1, 'DESIGN AND IMPLEMENTATION OF STUDENT COURSE FORM', 'Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract Well, it just an abstract ', 'hnd complain.docx', '43', '51', '12', 'others', '1250', 0, '0', '0', 'Sat 10 April, 2021; 11:42 pm');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `userid` varchar(250) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `bfrAmnt` decimal(11,2) NOT NULL,
  `aftAmnt` decimal(11,2) NOT NULL,
  `timed` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `memo` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `method` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `userid`, `amount`, `bfrAmnt`, `aftAmnt`, `timed`, `status`, `memo`, `reference`, `method`) VALUES
(1, '1', '5000.00', '0.35', '5000.35', 'Sun 11 April, 2021; 09:06 am', 1, '{\"txref\":\"MNFY|47|20210411082958|000181\",\"apprBy\":\"Monnify System\"}', 'MNFY|47|20210411082958|000181', 'Monnify System'),
(2, '1', '54500.00', '5000.35', '59500.35', 'Sun 11 April, 2021; 09:14 am', 1, '{\"txref\":\"MNFY|47|20210411091438|000186\",\"apprBy\":\"Monnify System\"}', 'MNFY|47|20210411091438|000186', 'Monnify System');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `dataName` longtext NOT NULL,
  `prodID` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `dataName`, `prodID`, `category`, `price`) VALUES
(1, '9Mobile 15.0GB/30days', '9mobile15000', 'Data Bundle', '5000.00'),
(7, '9Mobile 1.5GB/30days', '9mobile1500', 'Data Bundle', '950.00'),
(2, 'MTN 1.0GB/30days SME', 'mtn1000sme', 'Data Bundle', '450.00'),
(3, 'MTN 2.0GB/30days SME', 'mtn2000sme', 'Data Bundle', '900.00'),
(4, 'Airtel 4.5GB/30days', 'airtel4500', 'Data Bundle', '1900.00'),
(8, 'MTN 1GB/1day Direct', 'mtn1gb24hrsdirect', 'Data Bundle', '332.50'),
(9, 'MTN 2GB/1day Direct', 'mtn2gb24hrsdirect', 'Data Bundle', '475.00'),
(10, '9Mobile 500MB/30days', '9mobile500', 'Data Bundle', '475.00'),
(5, 'MTN 5.0GB/30days SME', 'mtn5000sme', 'Data Bundle', '2250.00'),
(6, 'Airtel 1.5GB/30days', 'airtel1500', 'Data Bundle', '950.00'),
(11, 'Smile 100GB Anytime (365 days) NGN 70,000', 'smile100gb365', 'Broadband data', '70000.00'),
(12, 'Smile 30GB BumpaValue (60 days) NGN 15,000', 'smile30gb60', 'Broadband data', '15000.00'),
(13, 'Smile Unlimited Premium (30 days) NGN 19,800', 'smileunlimitedpremium', 'Broadband data', '15000.00'),
(14, 'GOTv Lite NGN 400', 'gotvlite', 'Cable TV', '400'),
(15, 'GOTv Plus NGN 1900', 'gotvplus', 'Cable TV', '1900.00'),
(16, 'DSTV Premium', 'dstvpremium', 'Cable TV', '15800.00'),
(17, 'DSTV Compact Plus', 'dstvcompactplus', 'Cable TV', '10650.00'),
(18, 'DSTV Compact', 'dstvcompact', 'Cable TV', '6800.00'),
(19, 'DSTV Family', 'dstvfamily', 'Cable TV', '4000.00'),
(20, 'Star Times Super', 'startimessuper', 'Cable TV', '3800.00'),
(21, 'Star Times Smart', 'startimessmart', 'Cable TV', '1900.00'),
(22, 'Star Times Basic', 'startimesbasic', 'Cable TV', '1300.00'),
(23, 'Star Times Nova', 'startimesnova', 'Cable TV', '900.00'),
(24, 'GLO 6.25GB/750MB Night 30Days', 'gloid05', 'Data Bundle', '2500.00'),
(25, 'GLO 8.25GB/750MB Night 30Days', 'gloid06', 'Data Bundle', '3000.00'),
(26, 'GLO 11.25GB/750MB Night 30Days', 'gloid07', 'Data Bundle', '4000.00'),
(27, 'GLO 15.5GB/1GB Night 30Days', 'gloid08', 'Data Bundle', '5000.00'),
(28, 'GLO 24GB/1GB Night 30Days', 'gloid09', 'Data Bundle', '8000.00'),
(29, 'Smile 60GB BumpaValue (90 days) NGN 30,000', 'smile60gb90', 'Broadband data', '30000.00'),
(30, 'GLO 40GB/2GB Night 30Days', 'gloid10', 'Data Bundle', '10000.00'),
(31, 'Port Harcourt Postpaid', 'phedcpostpd', 'Electricity Bills', '0'),
(32, 'Port Harcourt Prepaid', 'phedcprepd', 'Electricity Bills', '0'),
(33, 'Eko Postpaid', 'ekopostpd', 'Electricity Bills', '0'),
(34, 'Eko Prepaid', 'ekoprepd', 'Electricity Bill', '0'),
(35, 'Ikeja Postpaid', 'ikejapostpd', 'Electricity Bills', '0');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'monnify', '{\"apiKey\": \"ewfvt5y5\", \"secKey\": \"e3yyvdfejej\", \"contractCode\": \"34567890123\", \"charge\": \"50\"}'),
(2, 'flutterSettings', '{\"pubkey\":\"FLWPUBK-c6f985f69d8c1283534a006c2484a790-X\",\"seckey\":\"FLWSECK-ee7ec28ae5951f8525f41e3d43bf90f8-X\"}'),
(3, 'airtimeSettings', '{\"min_air\":10,\"max_air\":5000, \"percent\": 3, \"dataPercent\":2.5}'),
(4, 'apiLink', '{\"call\":\"https://vtutopupbox.com/b2bhub/api/\",\"user\":\"07030237966001\",\"pass\":\"12345\"}');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `main_bal` decimal(20,2) DEFAULT 0.00,
  `earn_bal` decimal(20,2) NOT NULL DEFAULT 0.00,
  `providusID` varchar(255) NOT NULL,
  `providus_reference` varchar(255) NOT NULL,
  `accesskey` varchar(255) NOT NULL DEFAULT '0000',
  `bankInfo` longtext NOT NULL,
  `isverified` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `mobile`, `password`, `main_bal`, `earn_bal`, `providusID`, `providus_reference`, `accesskey`, `bankInfo`, `isverified`) VALUES
(1, 'Oluwatayo ', 'oluwatayoadeyemi@yahoo.com', '09033024846', '$2y$10$yB5i9Cu/eIn4ebc3gHHHxOFKrtSJVu4Sw3CPeP1oSXsM9Br5/4VJq', '7930.00', '3552.50', '895489548954', '', '1234', '{\"accName\":\"OGUNDOWOLE, RAHEEM OPEYEMI\",\"accNo\":\"0124336462\",\"bankCode\":\"058\"}', '1');

-- --------------------------------------------------------

--
-- Table structure for table `verification`
--

CREATE TABLE `verification` (
  `id` int(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` int(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `verification`
--

INSERT INTO `verification` (`id`, `userid`, `code`, `status`) VALUES
(1, '1', 'e0a3ewusozumi7o1agituki2a', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allbuys`
--
ALTER TABLE `allbuys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `market`
--
ALTER TABLE `market`
  ADD PRIMARY KEY (`projectID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verification`
--
ALTER TABLE `verification`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allbuys`
--
ALTER TABLE `allbuys`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `market`
--
ALTER TABLE `market`
  MODIFY `projectID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `verification`
--
ALTER TABLE `verification`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
