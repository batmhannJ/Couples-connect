-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 02, 2025 at 04:36 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `couplesconnect_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ext_appointment_info`
--

CREATE TABLE `ext_appointment_info` (
  `recid` int(11) NOT NULL,
  `appointment_info_id` varchar(100) NOT NULL,
  `clinic_date` date NOT NULL,
  `week_day` varchar(100) NOT NULL,
  `time_from` varchar(100) NOT NULL,
  `time_to` varchar(100) NOT NULL,
  `date_added` date NOT NULL,
  `slots_avail` varchar(20) NOT NULL,
  `venue` varchar(100) NOT NULL,
  `venue_id` varchar(100) NOT NULL,
  `counseloremail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ext_appointment_info`
--

INSERT INTO `ext_appointment_info` (`recid`, `appointment_info_id`, `clinic_date`, `week_day`, `time_from`, `time_to`, `date_added`, `slots_avail`, `venue`, `venue_id`, `counseloremail`) VALUES
(273, 'APP-00010', '2024-07-02', '', '10:30AM', '11:00PM', '2024-07-02', '200', '', 'V-00004', 'cnr@gmail.com'),
(274, 'APP-00010', '2024-07-15', '', '3:00AM', '4:30AM', '2024-07-02', '10', '', 'V-00005', 'cnr2@gmail.com'),
(275, 'APP-00010', '2024-10-15', '', '6:00AM', '10:00AM', '2024-07-02', '5', '', 'V-00005', 'cnr2@gmail.com'),
(276, 'APP-00010', '2024-07-23', '', '7:00PM', '10:30PM', '2024-07-02', '30', '', 'V-00008', 'cnr2@gmail.com'),
(277, 'APP-00010', '2024-07-03', '', '3:00AM', '4:00AM', '2024-07-02', '15', '', 'V-00003', 'cnr2@gmail.com'),
(278, 'APP-00010', '2024-07-03', '', '9:30AM', '7:30PM', '2024-07-03', '', '', 'V-00010', 'cnr@gmail.com'),
(279, 'APP-00011', '2024-07-30', '', '10:00AM', '2:00PM', '2024-07-03', '', '', 'V-00004', 'cnr@gmail.com'),
(280, 'APP-00011', '2024-07-17', '', '8:30AM', '2:00PM', '2024-07-03', '', '', 'V-00001', 'cnr@gmail.com'),
(281, 'APP-00011', '2024-07-23', '', '11:00AM', '11:30PM', '2024-07-03', '3', '', 'V-00005', 'cnr2@gmail.com'),
(282, 'APP-00011', '2024-07-14', '', '7:30AM', '1:30PM', '2024-07-03', '4', '', 'V-00003', 'cnr2@gmail.com'),
(287, 'APP-00012', '2024-07-03', '', '9:00AM', '1:00PM', '2024-07-03', '', '', 'V-00001', 'cnr@gmail.com'),
(288, 'APP-00013', '2024-07-03', '', '9:00AM', '10:00AM', '2024-07-03', '', '', 'V-00001', 'cnr@gmail.com'),
(289, 'APP-00013', '2024-07-03', '', '2:30AM', '6:30AM', '2024-07-20', '2', '', 'V-00003', 'cnr2@gmail.com'),
(291, 'APP-00014', '2025-02-12', '', '9:30AM', '1:30PM', '2025-02-17', '', '', 'V-00001', '23@gmail.com'),
(292, 'APP-00014', '2025-02-27', '', '9:30AM', '1:30PM', '2025-02-17', '', '', 'V-00011', '23@gmail.com'),
(293, 'APP-00014', '2025-02-27', '', '12:00PM', '2:00PM', '2025-02-26', '10', '', 'V-00005', 'cnr2@gmail.com'),
(294, 'APP-00014', '2025-02-28', '', '12:00PM', '3:00PM', '2025-02-26', '', '', 'V-00005', 'cnr2@gmail.com'),
(295, 'APP-00014', '2025-02-28', '', '11:00AM', '12:00PM', '2025-02-26', '10', '', 'V-00005', 'cnr2@gmail.com'),
(296, 'APP-00014', '2025-03-31', '', '12:00PM', '4:00PM', '2025-03-25', '10', '', 'V-00002', 'cnr@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `ext_couples_accountinfo`
--

CREATE TABLE `ext_couples_accountinfo` (
  `recid` int(11) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `partnerno` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `sex` varchar(100) NOT NULL,
  `bday` date NOT NULL,
  `country` varchar(100) NOT NULL,
  `municipality` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `cellphone_number` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `cert_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ext_couples_accountinfo`
--

INSERT INTO `ext_couples_accountinfo` (`recid`, `userid`, `partnerno`, `first_name`, `middle_name`, `last_name`, `sex`, `bday`, `country`, `municipality`, `occupation`, `cellphone_number`, `status`, `cert_status`) VALUES
(1, 'USR-00056', '1', 'John', 'Mark', 'Bartholomew', 'Male', '0000-00-00', 'Philippines', 'NCR', '', '091788671423', '', ''),
(2, 'USR-00002', '2', 'Mikaela', '', 'Cruz', 'Female', '0000-00-00', 'Philippines', 'NCR', '', '091762937123', '', ''),
(3, 'USR-00003', '1', 'Michael', '', 'Joenel', 'Male', '0000-00-00', 'Afghanistan', 'BARMM', 'Accountant', '091765979890', '', ''),
(5, 'USR-00003', '2', 'Jane', '', 'Dela Cruz', 'Female', '0000-00-00', 'Philippines', 'Manila', 'Medical Doctor', '09178881212', '', ''),
(6, 'USR-00005', '1', '', '', '', '', '1970-01-01', '', '', '', '', '', ''),
(7, 'USR-00005', '2', '', '', '', '', '1970-01-01', '', '', '', '', '', ''),
(8, 'USR-00006', '1', '', '', '', 'F', '1970-01-01', '', '', '', '', '', ''),
(9, 'USR-00006', '2', '', '', '', '', '1970-01-01', '', '', '', '', '', ''),
(10, 'USR-00007', '1', 'MARK1', 'DEL1', 'LE1', 'M', '2024-03-01', 'Isabella1', 'MACAO1', 'PULMBER1', '09187312783(1)', '', ''),
(11, 'USR-00007', '2', 'KRIS2', 'MELA2', 'DEF2', 'F', '2024-03-02', 'Isabella2', 'MARCHo2', 'HOUEWIFE2', '019212389123(2)', '', ''),
(12, 'USR-00008', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(13, 'USR-00008', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(16, 'USR-00009', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(17, 'USR-00009', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(18, 'USR-00010', '1', 'john', 'mark', 'cruz', 'M', '2024-03-12', 'Philippines', 'Joenell', 'student', '09187231', '', ''),
(19, 'USR-00010', '2', 'johane', 'ruz', 'dwela', 'O', '2024-03-12', 'Philippines', 'manila', 'student', '0918312', '', ''),
(20, 'USR-00011', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(21, 'USR-00011', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(22, 'USR-00012', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(23, 'USR-00012', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(24, 'USR-00013', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(25, 'USR-00013', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(26, 'USR-00014', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(27, 'USR-00014', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(28, 'USR-00015', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(29, 'USR-00015', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(30, 'USR-00016', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(31, 'USR-00016', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(32, 'USR-00017', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(33, 'USR-00017', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(34, 'USR-00021', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(35, 'USR-00021', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(36, 'USR-00022', '1', 'Joenel Buencibello', 'Jonathan', 'Kuminga', 'M', '2024-04-17', 'Philippines', 'Marikit', 'CLVE Teacher', '091782341', '', ''),
(37, 'USR-00022', '2', 'Maryann Joyce', 'Capella', 'Marian', 'M', '2024-04-10', 'Philippines', 'Justaxposation', 'CLVE Instructor', '019231213', '', ''),
(38, 'USR-00023', '1', 'JOENELL', 'Buencibello', 'Mark', 'M', '2024-04-24', 'Philippines', 'Municipial', 'Nurse', '09123132', '', ''),
(39, 'USR-00023', '2', 'Markannen', 'John', 'Inc', 'F', '2024-04-02', 'Philippines', 'JESKRITI', '123', '0912121', '', ''),
(40, 'USR-00024', '1', 'BRB Boi', 'Bro', 'Lee', 'F', '2024-04-16', 'Philippines', 'Municipial', 'Student', '091238', '', ''),
(41, 'USR-00024', '2', 'Johnny Sins', 'Karube', 'Liam', 'M', '2024-04-01', 'Juniwakeo', 'City hall', 'Nurse', '091231232', '', ''),
(42, 'USR-00025', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(43, 'USR-00025', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(44, 'USR-00026', '1', 'BROTHA', 'KUNI', 'LEE', 'M', '2024-04-18', 'Ph', 'brothanigga', 'Nurse', '09178213', '', ''),
(45, 'USR-00026', '2', 'LEE GWAN HEE', 'leuriet', 'r', 'M', '2024-04-18', 'Philippines', 'Choca', 'studetn', '09178', '', ''),
(46, 'USR-00027', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(47, 'USR-00027', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(48, 'USR-00028', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(49, 'USR-00028', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(50, 'USR-00029', '1', 'water', 'the', 'book', 'M', '2024-04-15', 'Philippines', 'Tacloban', 'Singer', '0917897', '', ''),
(51, 'USR-00029', '2', 'NIKGA', 'RUH', 'LEE', 'M', '2024-04-23', 'Philippines', 'Baclaran', 'BRUH', '09187231', '', ''),
(52, 'USR-00030', '1', 'Marikit', 'Maria', 'Lee', 'M', '2024-04-10', 'Philippines', 'Baclaran', 'Nurse', '091238132', '', ''),
(53, 'USR-00030', '2', 'John', 'Johny', 'Walker', 'O', '2024-04-10', 'Philippines', 'Joust', 'Teacher ', '09573912312', '', ''),
(54, 'USR-00031', '1', 'Mark', 'John', 'Go', 'M', '2024-04-10', 'Philippines', 'Manil', 'Nurse', '019231233+1', '', ''),
(55, 'USR-00031', '2', 'John', '123', 'Last', 'M', '2024-04-22', 'Ph', '123', 'Studetn', '092131', '', ''),
(58, 'USR-00032', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(59, 'USR-00032', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(60, 'USR-00033', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(61, 'USR-00033', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(62, 'USR-00034', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(63, 'USR-00034', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(64, 'USR-00035', '1', 'JOENELL', 'MARKOO', 'LASRTQWE', 'M', '2006-04-01', 'Philippines', 'Joenel', 'Studetn', '09123', '', ''),
(65, 'USR-00035', '2', 'JOENEL', 'BUENCIBELLO', 'KAIGAN', 'M', '2006-04-05', 'Philippines', 'Markap', 'Registered wee haa', '0190231', '', ''),
(66, 'USR-00036', '1', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(67, 'USR-00036', '2', '', '', '', 'M', '1970-01-01', '', '', '', '', '', ''),
(68, 'USR-00037', '1', 'Lennard', '', 'Lee', 'M', '2006-05-11', 'Philippines', '', 'student', '091238123', '', ''),
(69, 'USR-00037', '2', 'John', 'Hg', 'Yu', 'M', '2024-05-08', 'Philippines', '', 'student', '091238123', '', ''),
(70, 'USR-00038', '1', 'Vivien', 'Christ Luettgen', 'Beer', 'O', '2024-05-01', 'Mozambique', 'Lodi', 'Labore sequi dolores similique unde alias iusto aperiam ullam.', '481', '', ''),
(71, 'USR-00038', '2', 'Lon', 'Delia Gutmann', 'Lueilwitz', 'F', '2024-05-15', 'Puerto Rico', 'Ann Arbor', 'Cumque soluta a ratione suscipit cumque consequuntur.', '406', '', ''),
(72, 'USR-00039', '1', 'WALTER', 'W', 'WHITE', 'M', '2024-05-02', 'Philippines', 'Tondo', 'CItizen', '091231312', '', ''),
(73, 'USR-00039', '2', 'JOENEL', 'YU', 'BUENCIBELLO', 'M', '2024-05-01', 'Philippines', 'Marikit', 'Marchers', '092131789', '', ''),
(74, 'USR-00040', '1', 'Lonzo', 'Ebba Kling', 'Effertz', 'M', '2024-05-01', 'Philippines', 'Eastvale', 'Voluptas perferendis eveniet necessitatibus excepturi nam autem debitis consequatur repudiandae.', '099', '', ''),
(75, 'USR-00040', '2', 'Derrick', 'Chloe Thompson', 'Gulgowski', 'M', '2024-05-01', 'Philippines', 'Revere', 'Soluta non expedita ab error minima repellendus harum aspernatur.', '09687', '', ''),
(76, 'USR-00041', '1', 'Imani', 'Brendon Dach', 'Fay', 'F', '2024-05-08', 'Luxembourg', 'Oakland Park', 'Odio quos voluptatibus corporis ratione tempora consectetur vitae.', '5', '', ''),
(77, 'USR-00041', '2', 'Alverta', 'Haley Hudson', 'Kuphal-Spencer', 'F', '2024-05-08', 'Togo', 'Anaheim', 'Aspernatur quo expedita dolores facere voluptas architecto reprehenderit.', '599', '', ''),
(78, 'USR-00042', '1', 'Ernest', 'Collin Wilderman', 'Hilll', 'O', '1970-01-01', 'Bolivia', 'Bristol', 'Consequatur repellat assumenda odio modi.', '148', '', ''),
(79, 'USR-00042', '2', 'Nigel', 'Earline Dach', 'Klein', 'O', '1970-01-01', 'Nigeria', 'Washington', 'Odit tempora aspernatur illo amet minima.', '639', '', ''),
(80, 'USR-00043', '1', 'Eleanora', 'Charity Pfannerstill', 'Turcotte', 'O', '1970-01-01', 'Ireland', 'Fontana', 'Maiores veniam voluptate.', '363', '', ''),
(81, 'USR-00043', '2', 'Isaiah', 'Jammie MacGyver', 'Schultz', 'F', '1970-01-01', 'Burundi', 'North Little Rock', 'Cumque quod minus quis suscipit ipsa nobis nulla deserunt.', '407', '', ''),
(82, 'USR-00044', '1', 'America', 'Lew Grady', 'Stokes', 'O', '2024-05-28', 'Liberia', 'Shawnee', 'Molestias tempore vero labore vel maiores.', '232', '', ''),
(83, 'USR-00044', '2', 'Lyda', 'Daren Kshlerin', 'Boehm', 'F', '2024-05-28', 'Switzerland', 'Lancaster', 'Molestiae eos provident nostrum totam magni autem.', '236', '', ''),
(84, 'USR-00045', '1', 'Rozella', 'Tre Davis', 'Reilly', 'O', '2024-05-21', 'Lesotho', 'Kearny', 'Atque ducimus harum.', '401', '', ''),
(85, 'USR-00045', '2', 'Cathy', 'Veda Schuppe', 'Stroman', 'O', '2024-05-29', 'Panama', 'Kearny', 'Cumque sint eos eveniet quos illo ipsam tempora temporibus.', '43', '', ''),
(86, 'USR-00046', '1', 'Conner', 'Johnathan Jast', 'Sawayn', 'F', '1970-01-01', 'Laos', 'Irvine', 'Ipsam libero debitis eum.', '583', '', ''),
(87, 'USR-00046', '2', 'Kaitlin', 'David Cassin', 'Rath', 'O', '1970-01-01', 'Saint Lucia', 'Joplin', 'Officiis qui suscipit.', '309', '', ''),
(88, 'USR-00047', '1', 'Margret', 'Rodrick Collier', 'Lubowitz', 'F', '2024-06-12', 'Niger', 'Newark', 'Nesciunt odit quod animi temporibus iure corrupti.', '63', '', ''),
(89, 'USR-00047', '2', 'Olga', 'Edward Paucek', 'Muller', 'O', '2024-06-11', 'Egypt', 'Port St. Lucie', 'Perferendis atque qui tenetur nemo eos maiores quidem placeat aspernatur.', '529', '', ''),
(90, 'USR-00048', '1', 'Rhianna', 'Mafalda Robel', 'Abshire-Lakin', 'O', '2024-06-05', 'El Salvador', 'Rockford', 'Fuga cupiditate eaque quis a harum.', '537', '', ''),
(91, 'USR-00048', '2', 'Alvah', 'Ashley Lemke', 'Cummings', 'O', '2024-06-10', 'Croatia', 'Lake Forest', 'Quisquam impedit amet enim quae voluptate.', '266', '', ''),
(92, 'USR-00049', '1', 'Era', 'Kim Rath', 'Purdy', 'O', '2024-06-07', 'Seychelles', 'Pueblo', 'Similique molestiae facere nemo minus fugit reprehenderit optio.', '452', '', ''),
(93, 'USR-00049', '2', 'Talia', 'Craig Hagenes', 'Hintz', 'O', '2024-06-12', 'Palau', 'North Lauderdale', 'Assumenda architecto commodi provident repellat quaerat nulla excepturi.', '601', '', ''),
(94, 'USR-00050', '1', 'Dejuan', 'Alycia Kunze', 'Crona', 'F', '1970-01-01', 'Slovakia', 'State College', 'Molestias minus veniam.', '501', '', ''),
(95, 'USR-00050', '2', 'Damien', 'Andres Graham', 'Hintz', 'F', '1970-01-01', 'Congo, Democratic Republic of the', 'Dallas', 'Placeat adipisci neque qui iure temporibus deserunt.', '30', '', ''),
(96, 'USR-00051', '1', 'Joey', 'Constance Breitenberg', 'Legros', 'F', '1970-01-01', 'Laos', 'Reno', 'Voluptatibus similique ut libero repudiandae voluptatem necessitatibus mollitia similique.', '239', '', ''),
(97, 'USR-00051', '2', 'Josh', 'Bryce Cremin', 'Pacocha', 'O', '1970-01-01', 'Croatia', 'Kent', 'Est voluptas at ad similique expedita temporibus id molestiae.', '321', '', ''),
(98, 'USR-00052', '1', 'Maximillian', 'Garett Little', 'Shanahan-Hartmann', 'F', '2024-07-02', 'Montenegro', 'Raleigh', 'Minus illum iure tempore libero esse.', '636', '', ''),
(99, 'USR-00052', '2', 'Christophe', 'Vicenta Gerhold', 'Vandervort', 'F', '2024-07-09', 'Yemen', 'Taylor', 'Quibusdam quibusdam tempore saepe et delectus.', '614', '', ''),
(100, 'USR-00053', '1', 'Anjali', 'Braden Zieme', 'Hintz', 'F', '1970-01-01', 'Colombia', 'West Palm Beach', 'Quos temporibus mollitia consequatur non.', '131', '', ''),
(101, 'USR-00053', '2', 'Reyes', 'Shaylee Wuckert', 'Quitzon', 'O', '1970-01-01', 'Armenia', 'Montebello', 'Cumque minima eaque nisi sunt esse occaecati.', '607', '', ''),
(102, 'USR-00056', '1', 'HJdsf', 'dfds', 'sdfd', 'M', '2025-02-20', 'Isabela', 'Adsad', 'sadsad', '12344545345', '', ''),
(103, 'USR-00056', '2', 'ADSQD', 'QDQW', 'DQWD', 'O', '2025-02-13', 'Pjjj', 'sdfds', 'dfs', '123456', '', ''),
(104, 'USR-00057', '1', 'Rex', 'Fernandez', 'Luciano', 'M', '2002-08-03', 'Philippines', 'General Tinio', 'None', '09876543210', '', ''),
(105, 'USR-00057', '2', 'Jane', 'Smith', 'Doe', 'F', '2000-07-15', 'United States', 'New York', 'IT Specialist', '09662795223', '', ''),
(106, 'USR-00058', '1', 'J', 'F', 'G', 'M', '2025-02-24', 'Philippines', 'General Tinio', 'N', '09876543210', '', ''),
(107, 'USR-00058', '2', 'Jane', 'Smith', 'Doe', 'M', '2000-07-15', 'United States', 'New York', 'IT Specialist', '09662795223', '', ''),
(108, 'USR-00059', '1', 'J', 'F', 'G', 'M', '2025-02-24', 'Philippines', 'General Tinio', 'N', '09876543210', '', ''),
(109, 'USR-00059', '2', 'Jane', 'Smith', 'Doe', 'M', '2000-07-15', 'United States', 'New York', 'IT Specialist', '09662795223', '', ''),
(110, 'USR-00060', '1', 'Test', 'User', 'User', 'M', '2000-01-01', 'Philippines', 'Manila', 'N/A', '0123456789', '', ''),
(111, 'USR-00060', '2', 'Test', 'User', 'User', 'F', '2000-01-01', 'Philippines', 'Manila', 'N/A', '0123456789', '', ''),
(112, 'USR-00061', '1', 'test', 'test', 'test', 'M', '2025-02-04', 'Philippines', 'test', 'test', '123123123', '', ''),
(113, 'USR-00061', '2', 'test', 'test', 'test', 'F', '2025-02-10', 'Philippines', 'test', 'test', '123', '', ''),
(114, 'USR-00062', '1', 'Frank', 'Ocean', 'Ocean', 'M', '2000-01-01', 'Philippines', 'Manila', 'Singer', '0123456789', '', ''),
(115, 'USR-00062', '2', 'Celine', 'Dion', 'Dion', 'F', '2000-01-02', 'Philippines', 'Cabuyao', 'Business Owner', '0123456789', '', ''),
(116, 'USR-00063', '1', 'Frank', 'Ocean', 'Ocean', 'M', '2000-01-01', 'Philippines', 'Manila', 'Singer', '0123456789', '', ''),
(117, 'USR-00063', '2', 'Celine', 'Dion', 'Dion', 'F', '2000-01-02', 'Philippines', 'Cabuyao', 'Business Owner', '0123456789', '', ''),
(118, 'USR-00064', '1', 'Frank', 'Ocean', 'Ocean', 'M', '2000-01-01', 'Philippines', 'Manila', 'Singer', '0123456789', '', ''),
(119, 'USR-00064', '2', 'Celine', 'Dion', 'Dion', 'F', '2000-01-02', 'Philippines', 'Cabuyao', 'Business Owner', '0123456789', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ext_pro_couple_apc`
--

CREATE TABLE `ext_pro_couple_apc` (
  `recid` int(11) NOT NULL,
  `pro_coupleid` int(20) NOT NULL,
  `concerns` tinytext NOT NULL,
  `detailed_desc` tinytext NOT NULL,
  `clarifications` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `header_menu`
--

CREATE TABLE `header_menu` (
  `recid` int(11) NOT NULL,
  `menprog` varchar(100) NOT NULL,
  `mencap` varchar(30) NOT NULL,
  `menidx` varchar(30) NOT NULL,
  `usrlvl` varchar(30) NOT NULL,
  `mengrp` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `header_menu`
--

INSERT INTO `header_menu` (`recid`, `menprog`, `mencap`, `menidx`, `usrlvl`, `mengrp`) VALUES
(1, 'http://localhost/couplesconnect_wp/index.php', 'Home', '1', 'ALL', 'LOGIN');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `recid` int(11) NOT NULL,
  `mencap` varchar(30) NOT NULL,
  `menprogram` varchar(30) NOT NULL,
  `menlogo` varchar(30) NOT NULL,
  `menidx` varchar(30) DEFAULT NULL,
  `mennum` decimal(10,2) DEFAULT NULL,
  `mensub` varchar(30) NOT NULL,
  `mengrp` varchar(10) NOT NULL,
  `is_removed` varchar(100) NOT NULL,
  `is_disabled` varchar(100) NOT NULL,
  `has_crud` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`recid`, `mencap`, `menprogram`, `menlogo`, `menidx`, `mennum`, `mensub`, `mengrp`, `is_removed`, `is_disabled`, `has_crud`) VALUES
(1, 'Home', 'main.php', 'fas fa-home', '1.00', '0.00', '', '1', '1', '', ''),
(2, 'CC Users', 'mf_cc_users2.php', 'fab fa-adversal', '2.00', '0.00', '', '1', '', '', 'Y'),
(3, 'Utilities', '', 'fas fa-cogs', '3.00', '1.00', 'UTL', '3', '', '', ''),
(4, 'Users', 'utl_users.php', 'fas fa-users-cog', 'x', '1.00', '', 'UTL', '', '', ''),
(5, 'Password', 'utl_password.php', 'fas fa-key', 'x', '2.00', '', 'UTL', '', '', 'N'),
(6, 'User Activity Log', 'utl_useractivitylog.php', 'fas fa-file-contract', 'x', '1.00', '', 'UTL', '', '', 'N'),
(7, 'Patient File', 'mf_patientfile.php', 'fas fa-hospital-user', '.99', NULL, '', '1', '', '', 'N'),
(8, 'Family History', 'mf_family_history.php', 'fas fa-users', '1.1', NULL, '', '1', '1', '', 'Y'),
(9, 'Medical Conditions', 'mf_patient_history.php', 'fas fa-user-alt', '1.01', NULL, '', '1', '', '', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `mf_appointment_info`
--

CREATE TABLE `mf_appointment_info` (
  `recid` int(11) NOT NULL,
  `appointment_info_id` varchar(100) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `sched_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mf_appointment_info`
--

INSERT INTO `mf_appointment_info` (`recid`, `appointment_info_id`, `userid`, `sched_type`) VALUES
(39, 'APP-00002', 'USR-00018', 'PMO'),
(40, 'APP-00003', 'USR-00019', 'PMC'),
(41, 'APP-00004', 'USR-00018', 'PMO'),
(42, 'APP-00005', 'USR-00018', 'PMO'),
(43, 'APP-00006', 'USR-00018', 'PMO'),
(44, 'APP-00007', 'USR-00018', 'PMO'),
(45, 'APP-00008', 'USR-00019', 'PMO'),
(46, 'APP-00009', 'USR-00019', 'PMC'),
(47, 'APP-00010', 'USR-00018', 'PMO'),
(48, 'APP-00011', 'USR-00018', 'PMO'),
(49, 'APP-00012', 'USR-00018', 'PMO'),
(50, 'APP-00013', 'USR-00019', 'PMO'),
(51, 'APP-00014', 'USR-00018', 'PMO');

-- --------------------------------------------------------

--
-- Table structure for table `mf_cc_menu`
--

CREATE TABLE `mf_cc_menu` (
  `recid` int(11) NOT NULL,
  `mencap` varchar(30) NOT NULL,
  `menprog` varchar(30) NOT NULL,
  `menlogo` varchar(30) NOT NULL,
  `menidx` varchar(30) NOT NULL,
  `mensub` varchar(30) NOT NULL,
  `usr_access` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mf_cc_menu`
--

INSERT INTO `mf_cc_menu` (`recid`, `mencap`, `menprog`, `menlogo`, `menidx`, `mensub`, `usr_access`) VALUES
(1, 'Timeslot Viewing', 'cc_timeslotview.php', 'calendar.png', '1', '', 'DSK'),
(2, 'Account Confirmations', 'cc_account_confirm.php', 'certificates.png', '2', '', 'DSK'),
(3, 'Report Generation', 'cc_reportgen.php', 'pdf_logo.png', '3', '', 'DSK, HED'),
(4, 'Certificates', 'cc_certification.php', 'certificates.png', '4', '', 'DSK'),
(5, 'Timeslot Management', 'cc_timeslotmanage2.php', 'calendar.png', '1', '', 'CNR'),
(6, 'Counseling', 'cc_counseling.php', 'counseling.png', '2', '', 'CNR'),
(7, 'Couples Records', 'cc_couplesrecord.php', 'couples_record.png', '3', '', 'CNR'),
(8, 'Mei Forms Approval', 'cc_meiformapproval.php', 'meiformapproval.png', '', '', 'HED'),
(9, 'Add Questions', 'add_questions.php', 'meiformapproval.png', '', '', 'DSK, HED');

-- --------------------------------------------------------

--
-- Table structure for table `mf_concerns`
--

CREATE TABLE `mf_concerns` (
  `recid` int(11) NOT NULL,
  `concern_id` varchar(100) NOT NULL,
  `concerns` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mf_concerns`
--

INSERT INTO `mf_concerns` (`recid`, `concern_id`, `concerns`) VALUES
(4, 'C-00001', 'Concern 1'),
(5, 'C-00002', 'Concern 2'),
(6, 'C-00003', 'Concern 3'),
(8, 'C-00004', 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `mf_country`
--

CREATE TABLE `mf_country` (
  `recid` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `sortid` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mf_country`
--

INSERT INTO `mf_country` (`recid`, `country_name`, `sortid`) VALUES
(116, 'Afghanistan', '1.00'),
(117, 'Albania', '2.00'),
(118, 'Algeria', '3.00'),
(119, 'Andorra', '4.00'),
(120, 'Angola', '5.00'),
(121, 'Antigua and Barbuda', '6.00'),
(122, 'Argentina', '7.00'),
(123, 'Armenia', '8.00'),
(124, 'Australia', '9.00'),
(125, 'Austria', '10.00'),
(126, 'Azerbaijan', '11.00'),
(127, 'Bahamas', '12.00'),
(128, 'Bahrain', '13.00'),
(129, 'Bangladesh', '14.00'),
(130, 'Barbados', '15.00'),
(131, 'Belarus', '16.00'),
(132, 'Belgium', '17.00'),
(133, 'Belize', '18.00'),
(134, 'Benin', '19.00'),
(135, 'Bhutan', '20.00'),
(136, 'Bolivia', '21.00'),
(137, 'Bosnia and Herzegovina', '22.00'),
(138, 'Botswana', '23.00'),
(139, 'Brazil', '24.00'),
(140, 'Brunei', '25.00'),
(141, 'Bulgaria', '26.00'),
(142, 'Burkina Faso', '27.00'),
(143, 'Burundi', '28.00'),
(144, 'Cabo Verde', '29.00'),
(145, 'Cambodia', '30.00'),
(146, 'Cameroon', '31.00'),
(147, 'Canada', '32.00'),
(148, 'Central African Republic', '33.00'),
(149, 'Chad', '34.00'),
(150, 'Chile', '35.00'),
(151, 'China', '36.00'),
(152, 'Colombia', '37.00'),
(153, 'Comoros', '38.00'),
(154, 'Congo, Democratic Republic of the', '39.00'),
(155, 'Congo, Republic of the', '40.00'),
(156, 'Costa Rica', '41.00'),
(157, 'Croatia', '42.00'),
(158, 'Cuba', '43.00'),
(159, 'Cyprus', '44.00'),
(160, 'Czech Republic', '45.00'),
(161, 'Denmark', '46.00'),
(162, 'Djibouti', '47.00'),
(163, 'Dominica', '48.00'),
(164, 'Dominican Republic', '49.00'),
(165, 'Ecuador', '50.00'),
(166, 'Egypt', '51.00'),
(167, 'El Salvador', '52.00'),
(168, 'Equatorial Guinea', '53.00'),
(169, 'Eritrea', '54.00'),
(170, 'Estonia', '55.00'),
(171, 'Eswatini', '56.00'),
(172, 'Ethiopia', '57.00'),
(173, 'Fiji', '58.00'),
(174, 'Finland', '59.00'),
(175, 'France', '60.00'),
(176, 'Gabon', '61.00'),
(177, 'Gambia', '62.00'),
(178, 'Georgia', '63.00'),
(179, 'Germany', '64.00'),
(180, 'Ghana', '65.00'),
(181, 'Greece', '66.00'),
(182, 'Grenada', '67.00'),
(183, 'Guatemala', '68.00'),
(184, 'Guinea', '69.00'),
(185, 'Guinea-Bissau', '70.00'),
(186, 'Guyana', '71.00'),
(187, 'Haiti', '72.00'),
(188, 'Honduras', '73.00'),
(189, 'Hungary', '74.00'),
(190, 'Iceland', '75.00'),
(191, 'India', '76.00'),
(192, 'Indonesia', '77.00'),
(193, 'Iran', '78.00'),
(194, 'Iraq', '79.00'),
(195, 'Ireland', '80.00'),
(196, 'Israel', '81.00'),
(197, 'Italy', '82.00'),
(198, 'Jamaica', '83.00'),
(199, 'Japan', '84.00'),
(200, 'Jordan', '85.00'),
(201, 'Kazakhstan', '86.00'),
(202, 'Kenya', '87.00'),
(203, 'Kiribati', '88.00'),
(204, 'Korea, North', '89.00'),
(205, 'Korea, South', '90.00'),
(206, 'Kosovo', '91.00'),
(207, 'Kuwait', '92.00'),
(208, 'Kyrgyzstan', '93.00'),
(209, 'Laos', '94.00'),
(210, 'Latvia', '95.00'),
(211, 'Lebanon', '96.00'),
(212, 'Lesotho', '97.00'),
(213, 'Liberia', '98.00'),
(214, 'Libya', '99.00'),
(215, 'Liechtenstein', '100.00'),
(216, 'Lithuania', '101.00'),
(217, 'Luxembourg', '102.00'),
(218, 'Madagascar', '103.00'),
(219, 'Malawi', '104.00'),
(220, 'Malaysia', '105.00'),
(221, 'Maldives', '106.00'),
(222, 'Mali', '107.00'),
(223, 'Malta', '108.00'),
(224, 'Marshall Islands', '109.00'),
(225, 'Mauritania', '110.00'),
(226, 'Mauritius', '111.00'),
(227, 'Mexico', '112.00'),
(228, 'Micronesia', '113.00'),
(229, 'Moldova', '114.00'),
(230, 'Monaco', '115.00'),
(231, 'Mongolia', '116.00'),
(232, 'Montenegro', '117.00'),
(233, 'Morocco', '118.00'),
(234, 'Mozambique', '119.00'),
(235, 'Myanmar', '120.00'),
(236, 'Namibia', '121.00'),
(237, 'Nauru', '122.00'),
(238, 'Nepal', '123.00'),
(239, 'Netherlands', '124.00'),
(240, 'New Zealand', '125.00'),
(241, 'Nicaragua', '126.00'),
(242, 'Niger', '127.00'),
(243, 'Nigeria', '128.00'),
(244, 'North Macedonia', '129.00'),
(245, 'Norway', '130.00'),
(246, 'Oman', '131.00'),
(247, 'Pakistan', '132.00'),
(248, 'Palau', '133.00'),
(249, 'Palestine', '134.00'),
(250, 'Panama', '135.00'),
(251, 'Papua New Guinea', '136.00'),
(252, 'Paraguay', '137.00'),
(253, 'Peru', '138.00'),
(254, 'Philippines', '0.99'),
(255, 'Poland', '140.00'),
(256, 'Portugal', '141.00'),
(257, 'Qatar', '142.00'),
(258, 'Romania', '143.00'),
(259, 'Russia', '144.00'),
(260, 'Rwanda', '145.00'),
(261, 'Saint Kitts and Nevis', '146.00'),
(262, 'Saint Lucia', '147.00'),
(263, 'Saint Vincent and the Grenadines', '148.00'),
(264, 'Samoa', '149.00'),
(265, 'San Marino', '150.00'),
(266, 'Sao Tome and Principe', '151.00'),
(267, 'Saudi Arabia', '152.00'),
(268, 'Senegal', '153.00'),
(269, 'Serbia', '154.00'),
(270, 'Seychelles', '155.00'),
(271, 'Sierra Leone', '156.00'),
(272, 'Singapore', '157.00'),
(273, 'Slovakia', '158.00'),
(274, 'Slovenia', '159.00'),
(275, 'Solomon Islands', '160.00'),
(276, 'Somalia', '161.00'),
(277, 'South Africa', '162.00'),
(278, 'South Sudan', '163.00'),
(279, 'Spain', '164.00'),
(280, 'Sri Lanka', '165.00'),
(281, 'Sudan', '166.00'),
(282, 'Suriname', '167.00'),
(283, 'Sweden', '168.00'),
(284, 'Switzerland', '169.00'),
(285, 'Syria', '170.00'),
(286, 'Taiwan', '171.00'),
(287, 'Tajikistan', '172.00'),
(288, 'Tanzania', '173.00'),
(289, 'Thailand', '174.00'),
(290, 'Timor-Leste', '175.00'),
(291, 'Togo', '176.00'),
(292, 'Tonga', '177.00'),
(293, 'Trinidad and Tobago', '178.00'),
(294, 'Tunisia', '179.00'),
(295, 'Turkey', '180.00'),
(296, 'Turkmenistan', '181.00'),
(297, 'Tuvalu', '182.00'),
(298, 'Uganda', '183.00'),
(299, 'Ukraine', '184.00'),
(300, 'United Arab Emirates', '185.00'),
(301, 'United Kingdom', '186.00'),
(302, 'United States', '187.00'),
(303, 'Uruguay', '188.00'),
(304, 'Uzbekistan', '189.00'),
(305, 'Vanuatu', '190.00'),
(306, 'Vatican City', '191.00'),
(307, 'Venezuela', '192.00'),
(308, 'Vietnam', '193.00'),
(309, 'Yemen', '194.00'),
(310, 'Zambia', '195.00'),
(311, 'Zimbabwe', '196.00');

-- --------------------------------------------------------

--
-- Table structure for table `mf_meiform`
--

CREATE TABLE `mf_meiform` (
  `recid` int(11) NOT NULL,
  `meiformid` varchar(100) NOT NULL,
  `sortid` int(10) NOT NULL,
  `questions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mf_meiform`
--

INSERT INTO `mf_meiform` (`recid`, `meiformid`, `sortid`, `questions`) VALUES
(1, 'MEI-00001', 1, 'Papayagan kong magbigay ng pinansyal na tulong ang aking asawa sa aking biyenan at kanyang mga kapatid o kamag-anak\r\n\r\n'),
(2, 'MEI-00002', 0, 'Tatanggapin ko ang tulong pinansyal mula sa aking biyenan o kamag-anak'),
(3, 'MEI-00003', 0, 'Komportable ako kung titingnan o i-tse-tsek ng aking kapareha ang aking mobile phone, pitaka, social media account, etc.'),
(4, 'MEI-00004', 0, 'Pagkatapos ng kasal kami ay bukod ng tirahan at pamumuhay ng hiwalay sa aming mga magulang'),
(5, 'MEI-00005', 0, 'Papayagan ko ang aking asawa ng maghanap-buhay'),
(6, 'MEI-00006', 0, 'Naniniwala ako na ang asawang lalaki ang dapat magdesisyon tungkol sa mga usaping pinansyal'),
(8, 'MEI-00007', 0, 'Ang asawang babae lamang ang dapat mag-asikaso ng mga gawaing bahay'),
(9, 'MEI-00008', 0, 'Kung hindi kami magkakaanak, isinasaalang alang ko ang posibilidad ng alternatibong pag-aalaga'),
(10, 'MEI-00009', 0, 'Ang pagdidisiplina, pangangalaga at pagpapalaki ng aming mga anak ay responsibilidad naming mag-asawa'),
(11, 'MEI-00010', 0, 'Naniniwala ako na ang pamamalo ay isang paraan ng pagdidisiplina sa mga bata');

-- --------------------------------------------------------

--
-- Table structure for table `mf_premariage_concerns`
--

CREATE TABLE `mf_premariage_concerns` (
  `recid` int(11) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `sort_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mf_premariage_concerns`
--

INSERT INTO `mf_premariage_concerns` (`recid`, `desc`, `sort_id`) VALUES
(1, 'Communication Skills', '1'),
(2, 'Expectations and Values', '2'),
(3, 'Relationship Dynamics', '3'),
(4, 'Financial Planning', '4'),
(5, 'Roles and Responsibilities', '5'),
(6, 'Family of Origin Issues', '6'),
(7, 'Conflict Management', '7'),
(8, 'Emotional Well-being', '8');

-- --------------------------------------------------------

--
-- Table structure for table `mf_prog_users`
--

CREATE TABLE `mf_prog_users` (
  `recid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `secondary_email` varchar(100) NOT NULL,
  `usertype` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `act_status` varchar(30) NOT NULL,
  `cert_status` varchar(30) NOT NULL,
  `cert_desc` varchar(30) NOT NULL,
  `date_requested` date NOT NULL,
  `date_requested_desc` varchar(100) NOT NULL,
  `pmoc_online` varchar(100) NOT NULL,
  `doc_link` varchar(50) NOT NULL,
  `crm_link` varchar(50) NOT NULL,
  `justification` text NOT NULL,
  `remarks` varchar(255) NOT NULL DEFAULT 'Subject for approval.',
  `chk_by` varchar(100) NOT NULL,
  `print_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mf_prog_users`
--

INSERT INTO `mf_prog_users` (`recid`, `username`, `userid`, `email`, `secondary_email`, `usertype`, `password`, `act_status`, `cert_status`, `cert_desc`, `date_requested`, `date_requested_desc`, `pmoc_online`, `doc_link`, `crm_link`, `justification`, `remarks`, `chk_by`, `print_status`) VALUES
(17, 'deskstaff@gmail.com', 'USR-00001', 'test@gmail.com', '', 'DSK', '123', 'PMC', '', '', '0000-00-00', '', '', '', '', '', 'Subject for approval.', '', 1),
(18, 'couple1@gmail.com', 'USR-00002', '', '', 'USR', '123', 'NCT', '', '', '2024-10-12', '', '', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(19, 'couple2@gmail.com', 'USR-00003', 'couple2@gmail.com', 'couple2_second@gmail.com', 'USR', '123', '', '', '', '2022-04-13', '', '', 'residencyfile.pdf', 'justificationfile.pdf', 'The reason why I want to apply for online PMOC is because I am uable to go to the office in cabuyao and apply there personally. I am currently residing in Visayas. I also consider going there during only weekends and not the weekdays but it is really confusing for me to commute to cabuyao just for the online counseling that is why it is a bit confusing for me.', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(22, 'brotha@gmail.com', 'USR-00005', 'brotha@gmail.com', '', 'USR', '1234', 'CRT', 'PRP', 'Preparing', '2024-04-11', 'April 11, 2024', 'Y', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(23, 'mari@gmail.com', 'USR-00006', 'mari@gmail.com', '', 'USR', '123', 'DEC', '', '', '2024-03-16', '', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(24, 'Marko@gmail.com', 'USR-00007', 'Marko@gmail.com', 'delafuerte@gmail.com', 'USR', 'xx', 'CRT', 'RCV', 'Received', '2024-04-11', 'April 11, 2024', 'Y', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(25, 'johnny@gmail.com', 'USR-00008', 'johnny@gmail.com', '', 'DSK', '123', '', '', '', '2024-03-16', '', 'JUST DOESNT HIT', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(27, 'motha@gmail.com', 'USR-00009', 'motha@gmail.com', '', 'USR', '67', 'PCT', '', '', '2024-04-24', 'April 24, 2024', 'Y', '', '', 'sdfdfffsdff', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(28, 'lennardlee100@gmail.com', 'USR-00010', 'lennardlee100@gmail.com', '', 'USR', '123', 'CRT', 'PUP', 'For Pickup', '2024-04-11', 'April 11, 2024', 'Y', 'uploads/344921063_253307063937716_1671525311257754', 'uploads/201939.avif', 'lebum        ', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(29, '123@gmail.com', 'USR-00011', '123@gmail.com', '', 'USR', '111', 'DEC', '', '', '2024-04-11', 'April 11, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(30, 'bruh@gmail.com', 'USR-00012', 'bruh@gmail.com', '', 'USR', '123', 'CRT', 'PRP', 'Preparing', '2024-04-11', 'April 11, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(31, '1234@gmail.com', 'USR-00013', '1234@gmail.com', '', 'USR', '111', 'APR', '', '', '2024-04-13', 'April 13, 2024', 'Y', 'uploads/423472452_929274195466944_4082494152046077', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(32, 'johnny2@gmail.com', 'USR-00014', 'johnny2@gmail.com', '', 'USR', 'xx', 'APR', '', '', '2024-04-27', 'April 27, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(33, 'jor@gmail.com', 'USR-00015', 'jor@gmail.com', '', 'USR', '11', 'APR', '', '', '2024-04-27', 'April 27, 2024', 'Y', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(34, 'marky@gmail.com', 'USR-00016', 'marky@gmail.com', '', 'USR', '111', 'APR', '', '', '2024-05-27', 'May 27, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(35, 'yu@gmail.com', 'USR-00017', 'yu@gmail.com', '', 'USR', '123', 'PCT', '', '', '2024-04-24', 'April 24, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(36, 'cnr@gmail.com', 'USR-00018', 'cnr@gmail.com', '', 'CNR', '123', '', '', '', '2024-03-16', '', '', '', '', '', 'Subject for approval.', '', 1),
(37, 'cnr2@gmail.com', 'USR-00019', 'cnr2@gmail.com', '', 'CNR', '123', '', '', '', '2024-03-16', '', '', '', '', '', 'Subject for approval.', '', 1),
(38, 'head1@gmail.com', 'USR-00020', 'head1@gmail.com', '', 'HED', '123', '', '', '', '2024-03-25', '', '', '', '', '', 'Subject for approval.', '', 1),
(39, 'joenel3@gmail.com', 'USR-00021', 'joenel3@gmail.com', '', 'USR', '123', 'APR', '', '', '2024-04-13', 'April 13, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(40, 'test1@gmail.com', 'USR-00022', 'test1@gmail.com', '', 'USR', '123', 'CRT', 'PRP', 'Preparing', '2024-04-12', 'April 12, 2024', 'N', 'uploads/434142151_1120827459118053_756724852019588', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 0),
(41, 'lennard_lee@dlsu.edu.ph', 'USR-00023', 'lennard_lee@dlsu.edu.ph', '', 'USR', '123', 'PCT', '', '', '2024-04-12', 'April 12, 2024', 'Y', '', '', 'JOENEL', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(42, 'brb@gmail.com', 'USR-00024', 'brb@gmail.com', '', 'USR', '123', 'PCT', '', '', '2024-04-13', 'April 13, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(43, 'are@gmail.com', 'USR-00025', 'are@gmail.com', '', 'USR', '123', '', '', '', '2024-04-13', 'April 13, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(44, 'are2@gmail.com', 'USR-00026', 'are2@gmail.com', '', 'USR', '1', 'NCT', '', '', '2024-04-17', 'April 17, 2024', 'Y', 'uploads/434142151_1120827459118053_756724852019588', 'uploads/431681041_1788772974869851_747359344553442', 'IF you went to the moon then it would be over', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(45, '2@gmail.com', 'USR-00027', '2@gmail.com', '', 'USR', '123', 'PCT', '', '', '2024-04-23', 'April 23, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(46, 'y@gmail.com', 'USR-00028', 'y@gmail.com', '', 'USR', '123', 'PCT', '', '', '2024-04-28', 'April 28, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(47, '3@gmail.com', 'USR-00029', '3@gmail.com', '', 'USR', '123', 'PCT', '', '', '2024-04-18', 'April 18, 2024', 'Y', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(48, '4@gmail.com', 'USR-00030', '4@gmail.com', '', 'USR', '1', 'PCT', '', '', '2024-04-18', 'April 18, 2024', 'N', 'uploads/314767425_10160179054267158_59458798754800', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(49, 'register@gmail.com', 'USR-00031', 'register@gmail.com', '', 'USR', '123', 'NCT', '', '', '2024-04-23', 'April 23, 2024', 'Y', 'uploads/doc.pdf', 'uploads/imao-MRW5405.jpg', 'JUSTIFICATION', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(51, 't@gmail.com', 'USR-00032', 't@gmail.com', '', 'USR', '1', 'PCT', '', '', '2024-04-24', 'April 24, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(52, 'jrue@gmail.com', 'USR-00033', 'jrue@gmail.com', '', 'USR', '1', 'PCT', '', '', '2024-04-27', 'April 27, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(53, 'r@gmail.com', 'USR-00034', 'r@gmail.com', '', 'USR', '1', 'PMC', '', '', '2024-04-27', 'April 27, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(54, '333@gmail.com', 'USR-00035', '333@gmail.com', 'marky@gmail.com', 'USR', '333', 'PCT', '', '', '2024-04-28', 'April 28, 2024', 'Y', 'uploads/imao-MRW5405.jpg', 'uploads/download (1).jpg', ' I CHOSE TO APPLY TO PMC BECAUE BECAUSE BECUASE', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(55, 'yuyu@gmail.com', 'USR-00036', 'yuyu@gmail.com', '', 'USR', '1', 'DEC', '', '', '2024-04-28', 'April 28, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(56, 'e@gmail.com', 'USR-00037', 'e@gmail.com', '', 'USR', '123', 'NCT', '', '', '2024-05-03', 'May 03, 2024', 'Y', 'uploads/ABM12-B Sched TERM 3.jpg', 'uploads/434142151_1120827459118053_756724852019588', 'SDADSDDADSDD', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(57, 'BRUH2@gmail.com', 'USR-00038', 'BRUH2@gmail.com', '', 'USR', '123', 'PCT', '', '', '2024-05-06', 'May 06, 2024', 'Y', 'uploads/lhyfpzbifpo21.png', 'uploads/imao-MRW5405.jpg', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(58, 'broseph@gmail.com', 'USR-00039', 'broseph@gmail.com', '', 'USR', '123', 'DEC', '', '', '2024-05-27', 'May 27, 2024', 'N', 'uploads/photo-1574005280900-3ff489fa1f70.jpg', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(59, 'wt@gmail.com', 'USR-00040', 'wt@gmail.com', '', 'USR', '1', 'PMC', '', '', '2024-05-27', 'May 27, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(60, 'g@gmail.com', 'USR-00041', 'g@gmail.com', '', 'USR', '1', 'APR', '', '', '2024-05-28', 'May 28, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(61, 'tt@gmail.com', 'USR-00042', 'tt@gmail.com', '', 'USR', '1', 'PCT', '', '', '2024-06-27', 'June 27, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(62, 'g2@gmail.com', 'USR-00043', 'g2@gmail.com', '', 'USR', '1', 'PMC', '', '', '2024-05-28', 'May 28, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(63, 'r2@gmail.com', 'USR-00044', 'r2@gmail.com', '', 'USR', '1', 'PCT', '', '', '2024-06-27', 'June 27, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(64, 'h@gmail.com', 'USR-00045', 'h@gmail.com', '', 'USR', '1', 'PCT', '', '', '2024-05-29', 'May 29, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(65, 'b@gmail.com', 'USR-00046', 'b@gmail.com', '', 'USR', '1', 'APR', '', '', '2024-05-29', 'May 29, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(66, '222@gmail.com', 'USR-00047', '222@gmail.com', '', 'USR', '123', 'PCT', '', '', '2024-06-27', 'June 27, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(67, 's@gmail.com', 'USR-00048', 's@gmail.com', '', 'USR', '123', 'PCT', '', '', '2024-06-27', 'June 27, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(68, 'f@gmail.com', 'USR-00049', 'f@gmail.com', '', 'USR', '123', 'APR', '', '', '2024-06-24', 'June 24, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(69, 'q@gmail.com', 'USR-00050', 'q@gmail.com', '', 'USR', '1', 'PCT', '', '', '2024-06-27', 'June 27, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(70, 'broseph2@gmail.com', 'USR-00051', 'broseph2@gmail.com', '', 'USR', '1', 'PMO', '', '', '2024-07-15', 'July 15, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(71, 'u@gmail.com', 'USR-00052', 'u@gmail.com', '', 'USR', '123', 'APR', '', '', '2024-07-17', 'July 17, 2024', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(72, '23@gmail.com', 'USR-00053', '23@gmail.com', '', 'CNR', '1', 'PCT', '', '', '2025-02-17', 'February 17, 2025', 'N', '', '', '', 'Subject for approval.', 'deskstaff@gmail.com', 1),
(73, 'joen@gmail.com', 'USR-00054', '', '', 'CNR', '123', '', '', '', '0000-00-00', '', '', '', '', '', 'Subject for approval.', '', 1),
(74, 'jdulatre22@gmail.com', 'USR-00055', 'jdulatre22@gmail.com', 'jdulatre22@gmail.com', 'USR', 'jdulatre22@gmail.com', 'APR', '', '', '2025-02-16', 'February 16, 2025', 'N', 'uploads/2013-10-21_Notice_of_Privacy_Practices_edi', '', '', 'Subject for approval.', 'johnny@gmail.com', 1),
(75, '123456@gmail.com', 'USR-00056', '123456@gmail.com', '123456@gmail.com', 'USR', '123', 'PMO', 'PRP', '', '2025-02-17', 'February 17, 2025', 'N', 'uploads/2013-10-21_Notice_of_Privacy_Practices_edi', '', 'No valid info.', 'Invalid info provided.', '', 1),
(76, 'rexluciano@yahoo.com', 'USR-00057', 'rexluciano@yahoo.com', 'rexluciano36@gmail.com', 'USR', '123', 'PMC', '', '', '2025-02-17', 'February 17, 2025', 'Y', 'uploads/2013-10-21_Notice_of_Privacy_Practices_edi', 'uploads/2013-10-21_Notice_of_Privacy_Practices_edi', 'I Want to apply for PMOC.', 'Subject for approval.', 'johnny@gmail.com', 1),
(77, 'www@gmail.com', 'USR-00058', 'www@gmail.com', 'www@gmail.com', 'USR', '123', 'APR', '', '', '2025-02-17', 'February 17, 2025', 'N', 'uploads/2013-10-21_Notice_of_Privacy_Practices_edi', '', '', 'Invalid.', 'johnny@gmail.com', 0),
(78, 'ttt@gmail.com', 'USR-00059', 'ttt@gmail.com', 'ttt@gmail.com', 'USR', '123', 'PMC', '', '', '2025-02-17', 'February 17, 2025', 'N', 'uploads/2013-10-21_Notice_of_Privacy_Practices_edi', '', '', 'Subject for approval.', 'johnny@gmail.com', 0),
(79, 'testuser@gmail.com', 'USR-00060', 'testuser@gmail.com', '', 'USR', '1234', 'PCT', '', '', '2025-02-26', 'February 26, 2025', 'N', '', '', '', '', 'deskstaff@gmail.com', 1),
(80, 'testuser2@gmail.com', 'USR-00061', 'testuser2@gmail.com', '', 'USR', '1234', 'DEC', '', '', '2025-02-26', 'February 26, 2025', 'N', '', '', '', 'Not a Resident Incomplete', 'deskstaff@gmail.com', 0),
(81, 'frankocean@gmail.com', 'USR-00062', 'frankocean@gmail.com', '', 'USR', 'frank', 'PMO', '', '', '2025-03-25', 'March 25, 2025', 'N', 'uploads/reportgeneration.png', '', '', '', 'deskstaff@gmail.com', 0),
(82, 'frankocean@gmail.com', 'USR-00063', 'frankocean@gmail.com', '', 'USR', 'frank', 'PMO', '', '', '2025-03-25', 'March 25, 2025', 'N', 'uploads/reportgeneration.png', '', '', '', 'deskstaff@gmail.com', 0),
(83, 'frankocean@gmail.com', 'USR-00064', 'frankocean@gmail.com', '', 'USR', 'frank', 'PMO', '', '', '2025-03-25', 'March 25, 2025', 'N', 'uploads/reportgeneration.png', '', '', '', 'deskstaff@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mf_sample_prog`
--

CREATE TABLE `mf_sample_prog` (
  `recid` int(11) NOT NULL,
  `advisorID` varchar(100) DEFAULT NULL,
  `advisorname` varchar(100) DEFAULT NULL,
  `is_vaccinated` int(11) DEFAULT NULL,
  `employee_birthday` date DEFAULT NULL,
  `salary` decimal(20,2) DEFAULT '0.00',
  `address` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mf_time_manage`
--

CREATE TABLE `mf_time_manage` (
  `recid` int(11) NOT NULL,
  `service_cde` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time_mng_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mf_venue`
--

CREATE TABLE `mf_venue` (
  `recid` int(11) NOT NULL,
  `venue_id` varchar(100) NOT NULL,
  `venue` varchar(100) NOT NULL,
  `venue_link` varchar(200) NOT NULL,
  `is_online` varchar(100) NOT NULL,
  `userid` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mf_venue`
--

INSERT INTO `mf_venue` (`recid`, `venue_id`, `venue`, `venue_link`, `is_online`, `userid`) VALUES
(5, 'V-00001', 'Place 1', '', 'N', 'USR-00053'),
(6, 'V-00002', 'Place 2', '', 'N', 'USR-00018'),
(7, 'V-00003', 'Place 3', '', 'N', 'USR-00019'),
(8, 'V-00004', 'ONLINE 1', 'https://zoom.us/signin#/login', 'Y', 'USR-00018'),
(9, 'V-00005', 'ONLINE 2', 'https://www.figma.com/board/5KqP51vqo8X2QW06ho3mqv/Untitled', 'Y', 'USR-00019'),
(10, 'V-00006', 'ONLINE 3', 'https://docs.google.com/document/d/1ESea-K4X4LZEQ5iwS0Z1jQZb-chDjqVgKMYzGli7M_A/edit', 'Y', 'USR-00019'),
(11, 'V-00007', 'ONLINE 4', 'https://test.com', 'Y', 'USR-00018'),
(12, 'V-00008', 'MARKO POLO GUSTO NG TINAPAY', 'https://www.com/rizler.com69', 'Y', 'USR-00019'),
(15, 'V-00009', '222', 'https://www.com/rizzpartygronk', 'Y', 'USR-00019'),
(16, 'V-00010', 'CNR 1 NEW ONLINE ', 'https://www.w3schools.com/howto/howto_html_autocomplete_off.asp', 'Y', 'USR-00018'),
(17, 'V-00011', 'Vivamax', 'pronhub.com', 'Y', 'USR-00053');

-- --------------------------------------------------------

--
-- Table structure for table `pro_cert_table`
--

CREATE TABLE `pro_cert_table` (
  `recid` int(11) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `control_number` varchar(20) NOT NULL,
  `date_claimed` date NOT NULL,
  `date_claimed_desc` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `status_desc` varchar(100) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pro_cert_table`
--

INSERT INTO `pro_cert_table` (`recid`, `userid`, `reason`, `control_number`, `date_claimed`, `date_claimed_desc`, `status`, `status_desc`, `date_created`) VALUES
(32, 'USR-00059', 'No reason provided.', '12261784', '2025-02-17', 'February 17, 2025', 'APRV', 'Preparing', '2025-02-17 18:22:00'),
(33, 'USR-00059', 'SAD', '12261784', '2025-02-17', 'February 17, 2025', 'DEC', 'Preparing', '2025-02-17 18:23:21'),
(34, 'USR-00059', 'No reason provided.', '12261784', '2025-02-17', 'February 17, 2025', 'APRV', 'Preparing', '2025-02-17 18:23:41'),
(35, 'USR-00060', 'Test Request', '12261784', '2025-02-26', 'February 26, 2025', 'PRP', 'Preparing', '2025-02-26 14:26:05'),
(36, 'USR-00060', 'Test Request', '12261784', '2025-02-26', 'February 26, 2025', 'PRP', 'Preparing', '2025-02-26 14:26:14'),
(37, 'USR-00060', 'No reason provided.', '12261784', '2025-02-26', 'February 26, 2025', 'APRV', 'Preparing', '2025-02-26 14:41:20'),
(38, 'USR-00060', 'Test Print', '12261784', '2025-02-26', 'February 26, 2025', 'PRP', 'Preparing', '2025-02-26 14:40:33');

-- --------------------------------------------------------

--
-- Table structure for table `pro_counselorbooking`
--

CREATE TABLE `pro_counselorbooking` (
  `recid` int(11) NOT NULL,
  `pro_crbookingid` varchar(20) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `reccomendation_future` tinytext NOT NULL,
  `status` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `date_desc` varchar(100) NOT NULL,
  `prepared_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pro_counselorbooking`
--

INSERT INTO `pro_counselorbooking` (`recid`, `pro_crbookingid`, `userid`, `reccomendation_future`, `status`, `date`, `date_desc`, `prepared_by`) VALUES
(46, 'CID-00001', 'USR-00048', '', 'APR', '2024-06-27', 'June 27, 2024', 'cnr@gmail.com'),
(47, 'CID-00002', 'USR-00057', '', 'APR', '2024-07-15', 'July 15, 2024', 'cnr2@gmail.com'),
(48, 'CID-00003', 'USR-00053', '', 'APR', '2025-02-17', 'February 17, 2025', '23@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `pro_meiform`
--

CREATE TABLE `pro_meiform` (
  `recid` int(11) NOT NULL,
  `usermeiformid` varchar(100) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `status` varchar(100) NOT NULL,
  `counselorid` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pro_meiform`
--

INSERT INTO `pro_meiform` (`recid`, `usermeiformid`, `userid`, `status`, `counselorid`) VALUES
(178, 'UMF-00001', 'USR-00053', 'PMC', 'USR-00053'),
(179, 'UMF-00002', 'USR-00053', 'PMC', 'USR-00056'),
(180, 'UMF-00003', 'USR-00056', 'PMO', 'USR-00018'),
(181, 'UMF-00004', 'USR-00056', 'PMO', 'USR-00018'),
(182, 'UMF-00005', 'USR-00056', 'PMO', 'USR-00018'),
(183, 'UMF-00006', 'USR-00056', 'PMO', 'USR-00018'),
(184, 'UMF-00007', 'USR-00056', 'PMO', 'USR-00018'),
(185, 'UMF-00008', 'USR-00056', 'PMO', 'USR-00018'),
(186, 'UMF-00009', 'USR-00056', 'PMO', 'USR-00018'),
(187, 'UMF-00010', 'USR-00056', 'PMO', 'USR-00018'),
(189, 'UMF-00011', 'USR-00051', 'PMO', 'USR-00018'),
(190, 'UMF-00012', 'USR-00059', 'PMO', 'USR-00018'),
(191, 'UMF-00013', 'USR-00060', 'PMO', 'USR-00018'),
(192, 'UMF-00014', 'USR-00064', 'PMO', 'USR-00018');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_questions`
--

CREATE TABLE `tbl_questions` (
  `questions_id` int(11) NOT NULL,
  `questions` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `answers` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_questions`
--

INSERT INTO `tbl_questions` (`questions_id`, `questions`, `date_created`, `answers`) VALUES
(1, 'Request A Certificate', '2025-02-16 12:21:36', 'To request a certificate, go to Dashboard->Certificates then click Request Now.'),
(2, 'Test', '2025-02-16 13:32:03', 'Test 123');

-- --------------------------------------------------------

--
-- Table structure for table `useractivitylogfile`
--

CREATE TABLE `useractivitylogfile` (
  `usrcde` varchar(15) DEFAULT NULL,
  `usrname` varchar(20) DEFAULT NULL,
  `usrdte` date DEFAULT NULL,
  `usrtim` varchar(15) DEFAULT NULL,
  `trndte` datetime DEFAULT NULL,
  `module` varchar(100) DEFAULT NULL,
  `activity` varchar(100) DEFAULT NULL,
  `empcode` varchar(50) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `remarks` varchar(150) DEFAULT NULL,
  `linenum` int(11) DEFAULT '0',
  `parameter` varchar(50) DEFAULT NULL,
  `trncde` varchar(3) DEFAULT NULL,
  `trndsc` varchar(50) DEFAULT NULL,
  `recid` bigint(20) UNSIGNED NOT NULL,
  `compname` varchar(30) DEFAULT NULL,
  `usrnam` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `useractivitylogfile`
--

INSERT INTO `useractivitylogfile` (`usrcde`, `usrname`, `usrdte`, `usrtim`, `trndte`, `module`, `activity`, `empcode`, `fullname`, `remarks`, `linenum`, `parameter`, `trncde`, `trndsc`, `recid`, `compname`, `usrnam`) VALUES
('admin', 'admin', '2024-03-17', '10:20:35', '2024-03-17 10:20:35', '', 'Login', 'admin', 'admin_fullname', 'Successfull login', 0, '', '', '', 1, '', 'admin'),
('admin', 'admin', '2024-03-19', '14:34:22', '2024-03-19 14:34:22', '', 'Login', 'admin', 'admin_fullname', 'Successfull login', 0, '', '', '', 2, '', 'admin'),
('admin', 'admin', '2024-03-19', '14:34:41', '2024-03-19 14:34:41', '', 'Added Record', 'admin', 'admin_fullname', 'Added Record In \'USERS\', Email: \'cnr2@gmail.com\' , Record ID: ', 0, '', '', '', 3, '', 'admin'),
('admin', 'admin', '2024-03-25', '04:32:44', '2024-03-25 04:32:44', '', 'Login', 'admin', 'admin_fullname', 'Successfull login', 0, '', '', '', 4, '', 'admin'),
('admin', 'admin', '2024-03-25', '04:32:59', '2024-03-25 04:32:59', '', 'Added Record', 'admin', 'admin_fullname', 'Added Record In \'USERS\', Email: \'head1@gmail.com\' , Record ID: ', 0, '', '', '', 5, '', 'admin'),
('admin', 'admin', '2024-06-25', '08:43:55', '2024-06-25 08:43:55', '', 'Login', 'admin', 'admin_fullname', 'Successfull login', 0, '', '', '', 6, '', 'admin'),
('admin', 'admin', '2024-08-15', '07:21:48', '2024-08-15 07:21:48', '', 'Login', 'admin', 'admin_fullname', 'Successfull login', 0, '', '', '', 7, '', 'admin'),
('admin', 'admin', '2024-08-15', '07:22:18', '2024-08-15 07:22:18', '', 'Login', 'admin', 'admin_fullname', 'Successfull login', 0, '', '', '', 8, '', 'admin'),
('admin', 'admin', '2024-08-15', '07:24:44', '2024-08-15 07:24:44', '', 'Added Record', 'admin', 'admin_fullname', 'Added Record In \'USERS\', Email: \'joen@gmail.com\' , Record ID: ', 0, '', '', '', 9, '', 'admin'),
('admin', 'admin', '2024-08-15', '08:08:40', '2024-08-15 08:08:40', '', 'Login', 'admin', 'admin_fullname', 'Successfull login', 0, '', '', '', 10, '', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ext_appointment_info`
--
ALTER TABLE `ext_appointment_info`
  ADD PRIMARY KEY (`recid`),
  ADD KEY `appointment_info_id` (`appointment_info_id`),
  ADD KEY `venue_id` (`venue_id`);

--
-- Indexes for table `ext_couples_accountinfo`
--
ALTER TABLE `ext_couples_accountinfo`
  ADD PRIMARY KEY (`recid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `ext_pro_couple_apc`
--
ALTER TABLE `ext_pro_couple_apc`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `pro_coupleid` (`pro_coupleid`);

--
-- Indexes for table `header_menu`
--
ALTER TABLE `header_menu`
  ADD PRIMARY KEY (`recid`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `mencap` (`mencap`);

--
-- Indexes for table `mf_appointment_info`
--
ALTER TABLE `mf_appointment_info`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `appointment_info_id` (`appointment_info_id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `mf_cc_menu`
--
ALTER TABLE `mf_cc_menu`
  ADD PRIMARY KEY (`recid`);

--
-- Indexes for table `mf_concerns`
--
ALTER TABLE `mf_concerns`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `concern_id` (`concern_id`);

--
-- Indexes for table `mf_country`
--
ALTER TABLE `mf_country`
  ADD PRIMARY KEY (`recid`);

--
-- Indexes for table `mf_meiform`
--
ALTER TABLE `mf_meiform`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `meiformid` (`meiformid`);

--
-- Indexes for table `mf_premariage_concerns`
--
ALTER TABLE `mf_premariage_concerns`
  ADD PRIMARY KEY (`recid`);

--
-- Indexes for table `mf_prog_users`
--
ALTER TABLE `mf_prog_users`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `userid` (`userid`);

--
-- Indexes for table `mf_sample_prog`
--
ALTER TABLE `mf_sample_prog`
  ADD PRIMARY KEY (`recid`);

--
-- Indexes for table `mf_time_manage`
--
ALTER TABLE `mf_time_manage`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `time_mng_id` (`time_mng_id`);

--
-- Indexes for table `mf_venue`
--
ALTER TABLE `mf_venue`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `venue_id` (`venue_id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `pro_cert_table`
--
ALTER TABLE `pro_cert_table`
  ADD PRIMARY KEY (`recid`);

--
-- Indexes for table `pro_counselorbooking`
--
ALTER TABLE `pro_counselorbooking`
  ADD PRIMARY KEY (`recid`),
  ADD KEY `pro_crbookingid` (`pro_crbookingid`);

--
-- Indexes for table `pro_meiform`
--
ALTER TABLE `pro_meiform`
  ADD PRIMARY KEY (`recid`),
  ADD KEY `usermeiformid` (`usermeiformid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  ADD PRIMARY KEY (`questions_id`);

--
-- Indexes for table `useractivitylogfile`
--
ALTER TABLE `useractivitylogfile`
  ADD PRIMARY KEY (`recid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ext_appointment_info`
--
ALTER TABLE `ext_appointment_info`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT for table `ext_couples_accountinfo`
--
ALTER TABLE `ext_couples_accountinfo`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `ext_pro_couple_apc`
--
ALTER TABLE `ext_pro_couple_apc`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `header_menu`
--
ALTER TABLE `header_menu`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mf_appointment_info`
--
ALTER TABLE `mf_appointment_info`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `mf_cc_menu`
--
ALTER TABLE `mf_cc_menu`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mf_concerns`
--
ALTER TABLE `mf_concerns`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mf_country`
--
ALTER TABLE `mf_country`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=312;

--
-- AUTO_INCREMENT for table `mf_meiform`
--
ALTER TABLE `mf_meiform`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mf_premariage_concerns`
--
ALTER TABLE `mf_premariage_concerns`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mf_prog_users`
--
ALTER TABLE `mf_prog_users`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `mf_sample_prog`
--
ALTER TABLE `mf_sample_prog`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mf_time_manage`
--
ALTER TABLE `mf_time_manage`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mf_venue`
--
ALTER TABLE `mf_venue`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pro_cert_table`
--
ALTER TABLE `pro_cert_table`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `pro_counselorbooking`
--
ALTER TABLE `pro_counselorbooking`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `pro_meiform`
--
ALTER TABLE `pro_meiform`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  MODIFY `questions_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `useractivitylogfile`
--
ALTER TABLE `useractivitylogfile`
  MODIFY `recid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ext_appointment_info`
--
ALTER TABLE `ext_appointment_info`
  ADD CONSTRAINT `ext_appointment_info_ibfk_2` FOREIGN KEY (`appointment_info_id`) REFERENCES `mf_appointment_info` (`appointment_info_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ext_appointment_info_ibfk_3` FOREIGN KEY (`venue_id`) REFERENCES `mf_venue` (`venue_id`);

--
-- Constraints for table `ext_couples_accountinfo`
--
ALTER TABLE `ext_couples_accountinfo`
  ADD CONSTRAINT `ext_couples_accountinfo_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `mf_prog_users` (`userid`);

--
-- Constraints for table `mf_appointment_info`
--
ALTER TABLE `mf_appointment_info`
  ADD CONSTRAINT `mf_appointment_info_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `mf_prog_users` (`userid`);

--
-- Constraints for table `mf_venue`
--
ALTER TABLE `mf_venue`
  ADD CONSTRAINT `mf_venue_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `mf_prog_users` (`userid`);

--
-- Constraints for table `pro_meiform`
--
ALTER TABLE `pro_meiform`
  ADD CONSTRAINT `pro_meiform_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `mf_prog_users` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
