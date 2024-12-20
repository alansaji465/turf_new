-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 04:47 AM
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
-- Database: `turf_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `amenity_id` int(11) NOT NULL,
  `amenity_name` varchar(255) NOT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`amenity_id`, `amenity_name`, `is_default`) VALUES
(1, 'Parking', 1),
(2, 'Changing Rooms', 1),
(3, 'First Aid', 1),
(4, 'Drinking Water', 1),
(5, 'Restrooms', 1);

-- --------------------------------------------------------

--
-- Table structure for table `booking_list`
--

CREATE TABLE `booking_list` (
  `id` int(30) NOT NULL,
  `ref_code` varchar(100) NOT NULL,
  `client_id` int(30) NOT NULL,
  `turf_id` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0 = Pending,\r\n1 = Confirmed,\r\n2 = Done,\r\n3 = Cancelled',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_list`
--

INSERT INTO `booking_list` (`id`, `ref_code`, `client_id`, `turf_id`, `date_from`, `date_to`, `status`, `date_created`, `date_updated`) VALUES
(1, '202203-00001', 1, 7, '2022-03-24', '2022-03-24', 3, '2022-03-23 13:22:06', '2024-12-09 10:54:38'),
(2, '202203-00002', 1, 7, '2022-03-24', '2022-03-25', 1, '2022-03-23 13:30:40', '2024-12-09 10:54:38'),
(3, '202203-00003', 2, 7, '2022-03-24', '2022-03-25', 1, '2022-03-23 15:40:58', '2024-12-09 10:54:38'),
(4, '202203-00004', 2, 7, '2022-03-28', '2022-03-28', 3, '2022-03-23 15:41:17', '2024-12-09 10:54:38'),
(5, '202412-00001', 3, 7, '2024-12-04', '2024-12-05', 3, '2024-12-04 17:43:36', '2024-12-12 13:14:59'),
(6, '202412-00002', 37, 7, '2024-12-16', '2024-12-08', 3, '2024-12-07 00:36:24', '2024-12-12 13:14:46'),
(7, '202412-00003', 3, 7, '2024-12-09', '2024-12-10', 0, '2024-12-08 15:12:06', '2024-12-09 10:54:38'),
(9, '', 1, 10, '2024-12-10', '2024-12-12', 0, '2024-12-09 10:47:08', NULL),
(10, '202412-00004', 37, 1, '2024-12-18', '2024-12-19', 0, '2024-12-12 13:11:32', '2024-12-16 08:55:19'),
(11, '202412-00005', 3, 9, '2024-12-17', '2024-12-18', 1, '2024-12-12 15:02:22', '2024-12-15 17:20:13'),
(12, '202412-00006', 3, 3, '2024-12-16', '2024-12-17', 0, '2024-12-14 14:07:43', NULL),
(13, '202412-00007', 3, 2, '2024-12-19', '2024-12-20', 0, '2024-12-14 14:08:24', '2024-12-14 18:20:59'),
(14, '202412-00008', 37, 4, '2024-12-16', '2024-12-17', 0, '2024-12-14 17:57:34', '2024-12-14 17:58:40'),
(15, '202412-00009', 37, 6, '2024-12-15', '2024-12-16', 0, '2024-12-14 17:59:19', NULL),
(16, '202412-00010', 37, 5, '2024-12-15', '2024-12-16', 0, '2024-12-14 17:59:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `description`, `delete_flag`, `status`, `date_created`, `date_updated`) VALUES
(1, 'Basket Ball', 'Basket Ball Facility', 0, 1, '2022-03-23 10:34:53', NULL),
(2, 'Badminton', 'Badminton Court', 0, 1, '2022-03-23 10:35:12', NULL),
(3, 'Tennis Court', 'Tennis Court', 0, 1, '2022-03-23 10:35:32', NULL),
(4, 'Football', 'Football Field', 0, 1, '2022-03-23 10:35:46', NULL),
(5, 'Volleyball', 'Volleyball Court', 0, 1, '2022-03-23 10:36:08', NULL),
(6, 'Baseball', 'Baseball Field', 0, 1, '2022-03-23 10:36:42', NULL),
(7, 'Sample 101', 'This is a sample Facility Category Only', 0, 1, '2022-03-23 15:26:12', NULL),
(8, 'Sample 103', 'Test', 1, 0, '2022-03-23 15:26:42', '2022-03-23 15:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `client_list`
--

CREATE TABLE `client_list` (
  `id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text DEFAULT NULL,
  `gender` text DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_added` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_list`
--

INSERT INTO `client_list` (`id`, `firstname`, `middlename`, `lastname`, `gender`, `contact`, `address`, `email`, `password`, `image_path`, `status`, `delete_flag`, `date_created`, `date_added`) VALUES
(3, 'amal', '', 'saji', 'Male', '6282330119', 'Ned', 'amal@gmail.com', '16b5480e7b6e68607fe48815d16b5d6d', NULL, 1, 0, '2024-12-04 17:42:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `facility_list`
--

CREATE TABLE `facility_list` (
  `id` int(30) NOT NULL,
  `facility_code` varchar(100) NOT NULL,
  `category_id` int(30) NOT NULL,
  `image_path` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `name` text NOT NULL,
  `description` text NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facility_list`
--

INSERT INTO `facility_list` (`id`, `facility_code`, `category_id`, `image_path`, `status`, `delete_flag`, `date_created`, `date_updated`, `name`, `description`, `price`) VALUES
(1, '202203-00001', 1, 'uploads/facility/1.png?v=1648020784', 1, 0, '2022-03-23 11:07:02', '2022-03-23 15:33:04', 'Indoor Basketball Court', '<p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sapien lorem, finibus sit amet tempus et, pharetra vel quam. Vivamus ultrices elementum turpis, in auctor nisi gravida sit amet. Curabitur rutrum sem vel sollicitudin maximus. Nam ut nisi venenatis felis condimentum luctus quis a purus. Donec accumsan lacinia dapibus. Maecenas sagittis tempor mauris, sit amet molestie lacus tempus ac. Morbi eleifend, libero sit amet facilisis consequat, lectus magna scelerisque massa, sit amet iaculis nibh leo nec leo. Curabitur pellentesque convallis lectus nec euismod. Integer maximus sem a ligula mollis, nec facilisis felis molestie. Proin et imperdiet lacus, sit amet sollicitudin libero. Aenean pellentesque augue ac metus consequat, at ultricies diam lacinia. In hac habitasse platea dictumst. Nunc diam sem, placerat sed placerat at, aliquet id nunc. Phasellus efficitur lorem non dui congue, at mattis odio facilisis.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">Aliquam elementum scelerisque elementum. Sed et nisl arcu. Phasellus sollicitudin dui at tellus faucibus faucibus. Vestibulum quam ipsum, fermentum ut dolor eget, lobortis bibendum dolor. Aliquam suscipit metus nec ligula imperdiet porttitor. Vivamus in tincidunt lorem. Nulla cursus nulla massa, nec eleifend turpis auctor sed.</p>', 500.00),
(2, '202203-00002', 1, 'uploads/facility/2.png?v=1648020799', 1, 0, '2022-03-23 11:44:34', '2022-03-23 15:33:19', 'Outdoor Basketball', '<p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">Integer rutrum tristique odio vitae mollis. Nullam dapibus porta bibendum. Aliquam et nisi vel velit fringilla dignissim sed sed purus. Aliquam aliquet lacus vitae porttitor sollicitudin. Curabitur a maximus ipsum, nec consequat ex. Sed dapibus, ante ut congue congue, tortor purus pharetra felis, non porttitor purus enim nec mi. Nullam sagittis elit sed dui cursus malesuada. In ullamcorper congue lorem vel bibendum. Phasellus suscipit velit ac fermentum lacinia. Fusce varius condimentum urna vitae posuere. In rhoncus ex eget erat aliquet rutrum. Proin quis arcu vulputate, pharetra enim quis, maximus est. Nulla venenatis fermentum massa, a scelerisque ex tincidunt vel.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">In ac dignissim urna, nec dapibus neque. Duis massa lectus, rutrum et efficitur in, posuere vel mauris. In vel nulla eu nisl porta scelerisque. Donec quis augue metus. Duis quis mauris ut mi eleifend mattis. Ut pulvinar nisl quis rutrum porttitor. Aliquam in mauris in dolor ultrices viverra id blandit velit. Proin vitae augue et neque efficitur ullamcorper eget vel nunc. Pellentesque placerat urna eu magna volutpat malesuada. Quisque imperdiet sem eros, eu convallis tellus fringilla vitae. Aliquam elementum, nibh ut facilisis faucibus, tortor erat consequat sapien, id condimentum libero tortor nec erat.</p>', 350.00),
(3, '202203-00003', 4, 'uploads/facility/3.png?v=1648020817', 1, 0, '2022-03-23 11:45:24', '2022-03-23 15:33:37', 'Football Field 101', '<p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">Integer ut congue eros. Nullam non rutrum leo. Vestibulum sollicitudin ac erat sed porta. Donec id neque a libero lacinia ullamcorper vitae quis lorem. In bibendum sodales nunc at viverra. Proin vel ultricies felis, id posuere augue. Donec euismod purus ullamcorper, facilisis nisi non, fringilla arcu. Vivamus enim sem, suscipit sit amet turpis sed, interdum lobortis magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pharetra sapien quis dui auctor suscipit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">Nullam in convallis quam. Nulla facilisi. In erat ipsum, convallis sed diam vitae, commodo maximus dui. Vestibulum gravida elementum euismod. Maecenas et viverra enim. Quisque tempus eleifend convallis. Nunc sit amet sem nisi.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">Quisque tempus nunc felis, ac viverra leo facilisis at. In hac habitasse platea dictumst. Etiam dapibus tortor ligula, sit amet tempus tellus elementum at. Praesent pharetra justo ut est volutpat tempus. Ut tincidunt, neque sed egestas ullamcorper, tortor odio suscipit mi, ac dapibus ligula dolor eu lectus. Vestibulum placerat vulputate elit id fringilla. Mauris diam sapien, commodo et turpis consectetur, porta sagittis turpis. Etiam gravida ullamcorper lacus, eget pharetra arcu consectetur eu. Aliquam at laoreet orci. Sed vel posuere leo. Integer ut imperdiet ipsum. Proin tincidunt mollis orci, ac porttitor nulla tempus a. Nullam ut ipsum odio.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">Nam condimentum pulvinar turpis, sit amet pharetra purus tincidunt sit amet. Quisque imperdiet dignissim luctus. Nam id odio sit amet odio venenatis tincidunt. Vivamus vel porttitor nunc. Vestibulum vel rutrum nulla. Donec interdum lectus vitae nulla consectetur luctus. Integer eu hendrerit odio, non porta velit. Vestibulum dapibus mauris arcu, eget imperdiet purus facilisis quis. Duis sit amet erat et metus finibus blandit. Duis scelerisque sit amet velit sed ultrices. Nunc facilisis, dolor non fringilla congue, massa odio facilisis justo, vel convallis sem nunc non dolor. Suspendisse ac libero sodales, ullamcorper diam a, consectetur augue. Integer ultrices turpis quis enim blandit bibendum. Donec congue porttitor ligula. Duis quis placerat urna, ac feugiat augue. Vestibulum justo risus, dignissim et massa sagittis, mollis interdum metus.</p>', 5980.98),
(4, '202203-00004', 2, 'uploads/facility/4.png?v=1648020754', 1, 0, '2022-03-23 15:28:01', '2022-03-23 15:32:34', 'Single Court for Badminton', '<p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">Aliquam eu libero pharetra, lobortis quam eu, efficitur arcu. Suspendisse sed metus varius, consectetur tortor quis, pretium ipsum. Fusce a augue eget ipsum cursus varius. Maecenas ac libero quis sem aliquam fringilla. Phasellus semper rutrum libero sed dapibus. Maecenas euismod ullamcorper massa, sit amet sollicitudin sem elementum non. Curabitur quis dapibus sem, vitae posuere enim. Integer non iaculis nisi. Donec tristique tincidunt nisi dapibus vehicula. Fusce sit amet vulputate ante. Sed porttitor eros augue, vel dictum nulla iaculis sed. Aliquam finibus at elit sit amet feugiat. Curabitur pretium id nibh dignissim accumsan.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">Aliquam a finibus eros. Etiam ac diam sapien. Integer quis hendrerit nibh, sed volutpat metus. Quisque dapibus finibus fermentum. Mauris facilisis, nibh ac placerat euismod, metus felis efficitur tortor, sed gravida quam nisi id elit. Phasellus vehicula ex ligula. Quisque blandit eleifend orci, at ultricies ligula pellentesque in. Nullam fermentum magna justo, id scelerisque ligula aliquam maximus. Nam varius nulla ut libero semper rutrum. Pellentesque tellus arcu, scelerisque non aliquet quis, aliquam sit amet felis. Ut commodo odio vitae libero mollis, malesuada congue nisi feugiat. Nunc varius, felis eu vestibulum lobortis, quam nisi consectetur elit, nec gravida turpis libero vitae leo. Nulla quam ex, mollis in nisi sit amet, egestas volutpat arcu. Mauris porttitor at nisl ac dictum. Nunc at orci nec est placerat tempor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>', 850.00),
(5, '202203-00005', 6, NULL, 1, 1, '2022-03-23 15:33:48', '2022-03-23 15:33:55', 'test', '<p>test</p>', 123.00);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Turf Booking'),
(6, 'short_name', 'Turfico'),
(11, 'logo', 'uploads/turf_logo.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/system-cover.png?v=1648002561');

-- --------------------------------------------------------

--
-- Table structure for table `turfs`
--

CREATE TABLE `turfs` (
  `turf_id` int(11) NOT NULL,
  `turf_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(150) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('Available','Unavailable') NOT NULL,
  `image_2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `turfs`
--

INSERT INTO `turfs` (`turf_id`, `turf_name`, `description`, `location`, `image`, `price`, `status`, `image_2`) VALUES
(1, 'Sparta Arena', 'Sparta Arena hosts a lot of semi-professional games. It also has cricket and beach volleyball facilities in the complex.', 'Oruvathilkotta, Thiruvananthapuram', 'assets\\images\\turf-images\\sparta-arena-2.jpg', 1000.00, 'Available', 'assets\\images\\turf-images\\sparta-arena-1.jpeg'),
(2, 'Sporthood Turfpark', 'Sporthood Turfpark can simultaneously host 7-a-side and 5-a-side games. It is close to the biggest shopping mall in Kerala and has great access from the city’s arterial roads.', 'Edappally, Kochi', 'assets\\images\\turf-images\\sporthood-turfpark-2.jpg', 1000.00, 'Available', 'assets\\images\\turf-images\\sporthood-turfpark-1.jpeg'),
(3, 'Gamma Football', 'Gamma Football has a FIFA-approved 3G artificial turf that’s designed to soften impact on the joints and decrease the likelihood of injury. They have a women\'s football programme called Gamma Girls.', 'Chilavannoor, Ernakulam', 'assets\\images\\turf-images\\gamma-football-2.jpg', 1000.00, 'Available', 'assets\\images\\turf-images\\gamma-football-1.jpeg'),
(4, 'Parkway', 'Located in the heart of Kochi, Parkway is a multi-sport centre and a popular gathering place for sports enthusiasts in the city.', 'Kalamassery, Kochi', 'assets\\images\\turf-images\\parkway-2.jpg', 1000.00, 'Available', 'assets\\images\\turf-images\\parkway-1.jpeg'),
(5, 'MTM Sports', 'Located at the heart of Ponnani, a place of historical importance, MTM Sports Village is Malabar’s first multi-sport arena. It was designed to be a community centre and has a wide range of sports.', 'Ponnani, Malappuram', 'assets\\images\\turf-images\\MTM-sports-2.jpg', 1000.00, 'Available', 'assets\\images\\turf-images\\MTM-sports-1.jpeg'),
(6, 'Lake Zone', 'Lake Zone is a very good facility in Kolathara. The 5-a-side football turf is by the river. The place is well-known for water sports and boat rides.', 'Kolathara, Kozhikode', 'assets\\images\\turf-images\\Lake-Zone-2.jpg', 1000.00, 'Available', 'assets\\images\\turf-images\\Lake-Zone-1.jpeg'),
(7, 'Just Futsal', 'Just Futsal is a stunning turf overlooking Thrissur City. It is equipped with a state-of-the-art FIFA-standard synthetic turf and excellent lighting.', 'Shobha City Mall, Thrissur', 'assets\\images\\turf-images\\Just-Futsal-2.jpg', 1500.00, 'Available', 'assets\\images\\turf-images\\Just-Futsal-1.jpeg'),
(8, 'Goal Castle', 'Vazhakkad and its neighbouring areas have produced many state and national players.Good for 5-a-side matches.', 'Vazhakkad, Kozhikode', 'assets\\images\\turf-images\\Goal-Castle-2.jpg', 1000.00, 'Available', 'assets\\images\\turf-images\\Goal-Castle-1.jpg'),
(9, 'Sporthood Espirito', 'Sporthood Espirito was the first turf in Kakkanad area. It is easily accessible from Infopark, an IT park complex in Kochi.', 'Kakkanad, Kochi', 'assets\\images\\turf-images\\Sporthood-Espirito-2.jpg', 800.00, 'Available', 'assets\\images\\turf-images\\Sporthood-Espirito-1.jpeg'),
(10, 'Cochin Sports Arena', 'Cochin Sports Arena is the biggest 7-a-side ground in the locality and easily accessible from main areas like Kakkanad, Palarivattom and Edapally', 'Edappally, Kochi', 'assets\\images\\turf-images\\Cochin-Sports-Arena-2.jpg', 1000.00, 'Available', 'assets\\images\\turf-images\\Cochin-Sports-Arena-1.jpeg'),
(11, 'Calicut Arena', 'Calicut Arena is one of the best and biggest turfs in the city of Calicut. The arena has two independent courts; one for 7-a-side and one for 5-a-side.', 'Moozhikkal, Kozhikode', 'assets\\images\\turf-images\\Calicut-Arena-2.jpg', 1000.00, 'Available', 'assets\\images\\turf-images\\Calicut-Arena-1.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `turf_amenities`
--

CREATE TABLE `turf_amenities` (
  `id` int(11) NOT NULL,
  `turf_id` int(11) NOT NULL,
  `amenity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/1624240500_avatar.png', NULL, 1, '2021-01-20 14:02:37', '2021-06-21 09:55:07'),
(10, 'Claire', 'Blake', 'cblake', '542d2760db6928e65bd10de7c16bb82c', 'uploads/avatar-10.png?v=1648021481', NULL, 2, '2022-03-23 15:44:41', '2022-03-23 15:44:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`amenity_id`);

--
-- Indexes for table `booking_list`
--
ALTER TABLE `booking_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `fk_booking_turf` (`turf_id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_list`
--
ALTER TABLE `client_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- Indexes for table `facility_list`
--
ALTER TABLE `facility_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `turfs`
--
ALTER TABLE `turfs`
  ADD PRIMARY KEY (`turf_id`);

--
-- Indexes for table `turf_amenities`
--
ALTER TABLE `turf_amenities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `turf_id` (`turf_id`),
  ADD KEY `amenity_id` (`amenity_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `amenity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `booking_list`
--
ALTER TABLE `booking_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `client_list`
--
ALTER TABLE `client_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `facility_list`
--
ALTER TABLE `facility_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `turfs`
--
ALTER TABLE `turfs`
  MODIFY `turf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `turf_amenities`
--
ALTER TABLE `turf_amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_list`
--
ALTER TABLE `booking_list`
  ADD CONSTRAINT `fk_booking_turf` FOREIGN KEY (`turf_id`) REFERENCES `turfs` (`turf_id`) ON DELETE CASCADE;

--
-- Constraints for table `facility_list`
--
ALTER TABLE `facility_list`
  ADD CONSTRAINT `facility_list_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `turf_amenities`
--
ALTER TABLE `turf_amenities`
  ADD CONSTRAINT `turf_amenities_ibfk_1` FOREIGN KEY (`turf_id`) REFERENCES `turfs` (`turf_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `turf_amenities_ibfk_2` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`amenity_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
