-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 12, 2024 at 06:08 AM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nextgen_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `3d_models`
--

CREATE TABLE `3d_models` (
  `model_id` int(150) NOT NULL,
  `lesson_id` int(150) NOT NULL,
  `model_name` text NOT NULL,
  `model_description` text NOT NULL,
  `model_uid` text NOT NULL,
  `datetime_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `3d_models`
--

INSERT INTO `3d_models` (`model_id`, `lesson_id`, `model_name`, `model_description`, `model_uid`, `datetime_added`) VALUES
(3, 1, 'Desktop', 'A desktop is a personal computer designed for regular use at a single location. It consists of a tower or case that houses the internal components like the CPU, storage, and power supply, and is typically connected to external peripherals like a monitor, keyboard, and mouse.', 'd1d8282c9916438091f11aeb28787b66', '2024-10-08 16:11:18'),
(4, 1, 'Keyboard', 'A keyboard is an input device with a set of keys for typing text and executing commands. It allows users to input letters, numbers, and special functions into the computer.', '05442f97fade4f29aa6d639595b6793b', '2024-10-08 16:11:18'),
(5, 1, 'Monitor', 'A mouse is an input device used to interact with a computer\'s graphical user interface by moving a cursor on the screen. It typically includes buttons for clicking, selecting, and scrolling.', '07debcacbbec408faa54f61097bf3881', '2024-10-08 16:11:18'),
(6, 1, 'Mouse', 'A mouse is an input device used to interact with a computer\'s graphical user interface by moving a cursor on the screen. It typically includes buttons for clicking, selecting, and scrolling.', '784e4a988b474f2ba1156dfd2d03224c', '2024-10-08 16:11:18'),
(7, 1, 'Speakers', 'Speakers are audio output devices that produce sound from a computer. They can be built into the monitor or external units, delivering everything from system sounds to music, movies, and gaming audio.', '3b5adc5be8c4436eb913063c7e3f5c67', '2024-10-08 16:11:18'),
(8, 2, 'Chassis (Case)', 'The protective shell of the computer that users open to access internal components during assembly or repair.', 'a46526af2ac84fa098edc3f01c012450', '2024-10-08 16:11:18'),
(9, 2, 'Case Fans', 'Case fans are fans installed in a computer case to maintain proper airflow, helping cool components such as the CPU, GPU, and motherboard. They play a key role in keeping internal temperatures low, especially during heavy workloads or gaming.', '1180bc1acfff4e4b8aa5cbd237c67e7e', '2024-10-08 16:11:18'),
(10, 2, 'CPU (Central Processing Unit)', 'A CPU cooler is a device that dissipates heat from the CPU to prevent it from overheating. It can be air-based, using fans and heatsinks, or liquid-based, using coolant for more efficient heat management in high-performance systems.', 'aecc64256e1b4e818807df4875947840', '2024-10-08 16:11:18'),
(11, 2, 'CPU Cooler', 'A CPU cooler is a device that dissipates heat from the CPU to prevent it from overheating. It can be air-based, using fans and heatsinks, or liquid-based, using coolant for more efficient heat management in high-performance systems.', 'e54651982f524644a2144b52a6b36e89', '2024-10-08 16:11:18'),
(12, 2, 'GPU', 'A dedicated processor responsible for rendering graphics, installed in an expansion slot on the motherboard.', '22158616a1a44455917ee8e1e8fc4b09', '2024-10-08 16:11:18'),
(13, 2, 'HDD, SSD and M.2', 'These are types of storage devices used in computers. HDDs (Hard Disk Drives) are traditional, mechanical drives with spinning disks that offer large storage capacities at lower prices but slower speeds. SSDs (Solid State Drives) use flash memory, offering significantly faster data access and durability with no moving parts. M.2 is a compact form factor for SSDs that connects directly to the motherboard, often supporting NVMe technology for even faster performance and more efficient use of space.', 'bdd5fd67a7674359ab8648204b5c0575', '2024-10-08 16:11:18'),
(14, 2, 'Liquid Cooler', 'A liquid cooler is a cooling solution for CPUs and GPUs that uses liquid (typically water) to absorb and dissipate heat. It\'s more efficient and quieter than traditional air coolers, making it ideal for high-performance and overclocked systems.', '2cbb94e546204151b35ee315c63c539b', '2024-10-08 16:11:18'),
(15, 2, 'Motherboard', 'Serves as the main board where all components connect, making it central to assembling and disassembling the PC.', '3eba5f45bed74fbeb2647de38047000f', '2024-10-08 16:11:18'),
(16, 2, 'PSU', 'Distributes power to all other components. It connects to the motherboard, drives, and other peripherals through power cables.', '6d122273398b446a876600401ba08b55', '2024-10-08 16:11:18'),
(17, 2, 'RAM (Memory)', 'Memory modules installed in the RAM slots of the motherboard to enable efficient system operation.', '1fce4935471e46cab6ee57ba140c87f9', '2024-10-08 16:11:18'),
(18, 3, 'CPU Socket', 'A CPU socket is a physical interface on a motherboard that holds and connects the CPU to the rest of the system. It ensures proper alignment and electrical connection. Different sockets support different CPU models (e.g., Intel LGA or AMD AM4).', '26d2147e082648949b9c703c514e6901', '2024-10-08 16:11:18'),
(19, 4, 'CPU (Processor)', 'The core component responsible for executing commands and processing data within the system.', 'aecc64256e1b4e818807df4875947840', '2024-10-08 16:11:18'),
(20, 4, 'CPU Cooler', 'A CPU cooler is a device that helps regulate the temperature of a computer\'s central processing unit (CPU) by dissipating heat. It can be air-based, using fans and heatsinks, or liquid-based, using coolant to maintain optimal temperatures and prevent overheating, especially during heavy workloads or gaming.', 'e54651982f524644a2144b52a6b36e89', '2024-10-08 16:11:18'),
(21, 4, 'Processor Sockets', 'The physical interface between the CPU and the motherboard, designed to secure and facilitate communication with the processor.', '26d2147e082648949b9c703c514e6901', '2024-10-08 16:11:18'),
(22, 4, 'Liquid Cooler', 'A liquid cooler is a cooling solution for CPUs and GPUs that uses liquid (typically water) to absorb and dissipate heat. It\'s more efficient and quieter than traditional air coolers, making it ideal for high-performance and overclocked systems.', '2cbb94e546204151b35ee315c63c539b', '2024-10-08 16:11:18'),
(23, 4, 'RAM Memory Technologies - DDR3', 'DDR3 (Double Data Rate 3) is an older type of RAM, introduced around 2007. It provides faster performance and better power efficiency than its predecessor, DDR2, but has been mostly phased out by newer technologies.', 'd2715d60f139421eb6028efd5153fdaf', '2024-10-08 16:11:18'),
(24, 4, 'RAM Memory Technologies - DDR4', 'DDR4 (Double Data Rate 4) is the standard RAM technology used in most computers today. It offers higher data transfer rates, greater capacity, and improved energy efficiency compared to DDR3.', '1fce4935471e46cab6ee57ba140c87f9', '2024-10-08 16:11:18'),
(25, 4, 'RAM Memory Technologies - DDR5', 'DDR5 (Double Data Rate 5) is the latest generation of RAM, delivering even faster speeds, higher bandwidth, and better energy efficiency than DDR4, making it ideal for modern, high-performance systems.', 'b0c76bf1eb484c448e58852efb7e1bd8', '2024-10-08 16:11:18'),
(26, 5, 'Cooling System - Case Fans', 'Fans mounted in the case to circulate air and remove excess heat from inside the chassis', '1180bc1acfff4e4b8aa5cbd237c67e7e', '2024-10-08 16:11:18'),
(27, 5, 'Cooling System - CPU Cooler', 'Fans mounted in the case to circulate air and remove excess heat from inside the chassis', 'e54651982f524644a2144b52a6b36e89', '2024-10-08 16:11:18'),
(28, 5, 'Cooling System - Liquid Cooler', 'A cooling method that uses liquid rather than air to dissipate heat, often used in high-performance computers.', '2cbb94e546204151b35ee315c63c539b', '2024-10-08 16:11:18'),
(29, 5, 'Power Supply Unit (PSU)', 'A component that converts AC power from the outlet to DC power used by the internal components of the computer.', '6d122273398b446a876600401ba08b55', '2024-10-08 16:11:18'),
(30, 6, 'Hard Drive (HDD)', 'Traditional mechanical drives that store data using spinning disks and read/write heads.', '56959df967974b298866420e83c572ac', '2024-10-08 16:11:18'),
(31, 6, 'M.2', 'M.2 is a compact form factor for storage and expansion devices, commonly used for SSDs in modern computers. It plugs directly into the motherboard, allowing for high-speed data transfer, especially with NVMe (Non-Volatile Memory Express) SSDs. M.2 drives are much smaller than traditional SSDs and HDDs, making them ideal for space-saving in laptops and desktops while delivering faster performance.', 'b2face83ca2e463b96753761a23dba30', '2024-10-08 16:11:18'),
(32, 6, 'Solid State Drives (SSD)', 'Flash-based storage drives that provide faster data access and transfer speeds compared to HDDs.', 'ad215e54c381456895e21db5062f8714', '2024-10-08 16:11:18'),
(42, 7, 'Graphics Processing Unit (GPU)', 'A dedicated card responsible for generating and rendering visual output, primarily to the monitor.', '22158616a1a44455917ee8e1e8fc4b09', '2024-10-30 05:21:19'),
(43, 7, 'Keyboard', 'The primary input device used for typing commands, letters, and numbers into the computer.', '05442f97fade4f29aa6d639595b6793b', '2024-10-30 05:21:19'),
(44, 7, 'Monitor', 'The output device that displays visual information from the computer.', '07debcacbbec408faa54f61097bf3881', '2024-10-30 05:21:19'),
(45, 7, 'Mouse', 'A pointing device used to interact with the computer’s graphical user interface.', '784e4a988b474f2ba1156dfd2d03224c', '2024-10-30 05:21:19'),
(46, 7, 'Speakers', 'Devices that output audio from the computer, including built-in speakers or external audio systems.', '3b5adc5be8c4436eb913063c7e3f5c67', '2024-10-30 05:21:19'),
(47, 7, 'Sound Card', 'A sound card is a computer component responsible for generating and recording audio. It enables users to connect analog speakers, headphones and microphones to their computer. Most modern computers have a built-in sound card in the motherboard.', '9c30822f96bc4ef991a936d2e979bbca', '2024-10-30 05:21:19'),
(48, 7, 'Network Interface Card', 'A Network Interface Controller (NIC), also known as a network adapter or network card, is a hardware component that enables a computer or other device to connect to a network. It operates as an intermediary between the device and the network, facilitating communication by converting data into signals suitable for transmission over a network medium, such as Ethernet or Wi-Fi.', '191c8ad40de2430980b879615aa0d2e3', '2024-10-30 05:21:19'),
(49, 7, 'Computer Ports Sockets', 'DVI-I: Dual-function video port supporting both digital and analog signals for displays.\r\nVGA: Analog video connector often used with older monitors and projectors.\r\nMicro-USB: Compact USB connector commonly used for mobile devices and small electronics.\r\nUSB-A: Standard rectangular USB port for data transfer and power.\r\nHDMI: Digital port for transmitting high-definition audio and video to displays.\r\nRJ45 Ethernet: Connector for wired internet/network connections.\r\nRJ11 Phone: Connector used for landline telephone connections.', '0e6edaa6772545e9ae693f903a3bfe0d', '2024-10-30 05:21:19'),
(50, 7, 'USB Ports', 'This model provides a detailed look at the USB port interface, commonly used for connecting a variety of peripherals and transferring data. The USB stick model illustrates a standard flash drive, showing how it connects to the port and provides storage solutions for users. Together, these models highlight essential components for connectivity and data storage in modern computing.', 'f881fba9b3ce4f66858911d48594027b', '2024-10-30 05:21:19');

-- --------------------------------------------------------

--
-- Table structure for table `account_verification`
--

CREATE TABLE `account_verification` (
  `verification_id` bigint(250) NOT NULL,
  `user_id` bigint(250) NOT NULL,
  `verification_code` text NOT NULL,
  `is_verified` varchar(150) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_verification`
--

INSERT INTO `account_verification` (`verification_id`, `user_id`, `verification_code`, `is_verified`) VALUES
(508644, 787825, '478931', 'true'),
(606458, 999986, '444674', 'false'),
(841239, 999986, '317365', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `attachment_id` int(11) NOT NULL,
  `message_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `conversation_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_group` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`conversation_id`, `created_at`, `updated_at`, `is_group`) VALUES
(30, '2024-10-31 06:10:00', '2024-10-31 06:10:00', 0),
(31, '2024-10-31 08:07:17', '2024-10-31 08:07:17', 0);

-- --------------------------------------------------------

--
-- Table structure for table `conversation_participants`
--

CREATE TABLE `conversation_participants` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `joined_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversation_participants`
--

INSERT INTO `conversation_participants` (`id`, `conversation_id`, `user_id`, `joined_at`) VALUES
(65, 30, 999986, '2024-10-31 06:10:00'),
(66, 31, 571458, '2024-10-31 08:07:18'),
(67, 31, 999986, '2024-10-31 08:07:18');

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE `forums` (
  `forum_id` int(150) NOT NULL,
  `user_id` bigint(250) NOT NULL,
  `forum_title` text NOT NULL,
  `forum_description` text NOT NULL,
  `forum_file_upload` text NOT NULL,
  `datetime_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`forum_id`, `user_id`, `forum_title`, `forum_description`, `forum_file_upload`, `datetime_created`) VALUES
(4226474, 320188, 'Test Forum', 'Test description', 'FORUM-2024-10-30-05-47-48.png', '2024-10-30 02:47:48');

-- --------------------------------------------------------

--
-- Table structure for table `forum_comments`
--

CREATE TABLE `forum_comments` (
  `comment_id` int(150) NOT NULL,
  `forum_id` int(150) NOT NULL,
  `user_id` bigint(250) NOT NULL,
  `comment` text NOT NULL,
  `datetime_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `member_id` int(150) NOT NULL,
  `group_id` int(150) NOT NULL,
  `user_id` bigint(250) NOT NULL,
  `datetime_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_tasks`
--

CREATE TABLE `group_tasks` (
  `task_id` int(150) NOT NULL,
  `group_id` int(150) NOT NULL,
  `task_title` text NOT NULL,
  `task_description` text NOT NULL,
  `task_status` enum('Pending','In Progress','Completed','Archived') NOT NULL DEFAULT 'Pending',
  `datetime_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_messages`
--

CREATE TABLE `lecture_messages` (
  `lecture_message_id` int(150) NOT NULL,
  `video_lectures_id` int(200) NOT NULL,
  `user_id` bigint(250) NOT NULL,
  `message_content` text NOT NULL,
  `datetime_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int(150) NOT NULL,
  `week_number` int(150) NOT NULL,
  `lesson_title` text NOT NULL,
  `lesson_description` text NOT NULL,
  `lesson_image_banner` text NOT NULL,
  `datetime_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`lesson_id`, `week_number`, `lesson_title`, `lesson_description`, `lesson_image_banner`, `datetime_created`) VALUES
(1, 1, 'Computer Components', 'Learn about essential computer parts, including the motherboard, chassis, and other hardware components.', 'WEEK1-LESSON-2024-10-01-22-42-50.webp', '2024-10-01 22:51:30'),
(2, 2, 'Disassembly and Reassembly Process of Computers', 'Master the skills required to safely disassemble and reassemble computers step by step.', 'WEEK2-LESSON-2024-10-01-22-42-50.webp', '2024-10-01 22:51:30'),
(3, 3, 'Motherboards, Processor Sockets, and Chipsets', 'Explore the different types of motherboards, processor sockets, and chipsets, and understand their roles in computing.', 'WEEK3-LESSON-2024-10-01-22-42-50.webp', '2024-10-01 22:51:30'),
(4, 4, 'Processors and Memory Technologies', 'Discover how processors and memory (RAM) work, along with their technologies and importance in system performance.', 'WEEK4-LESSON-2024-10-01-22-42-50.webp', '2024-10-01 22:51:30'),
(5, 5, 'Power Supplies and Cooling Systems', 'Understand the role of power supplies and the significance of proper cooling systems in maintaining optimal computer performance.', 'WEEK5-LESSON-2024-10-01-22-42-50.webp', '2024-10-01 22:51:30'),
(6, 6, 'Hard Drive Technologies and RAID', 'Delve into various hard drive technologies and learn about RAID configurations for data storage and protection.', 'WEEK6-LESSON-2024-10-01-22-42-50.webp', '2024-10-01 22:51:30'),
(7, 7, 'Input/Output Devices', 'Get familiar with different input/output devices such as keyboards, mice, monitors, and more, and their interaction with computers.', 'WEEK7-LESSON-2024-10-01-22-42-50.webp', '2024-10-01 22:51:30');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_group_collaborators`
--

CREATE TABLE `lesson_group_collaborators` (
  `group_id` int(150) NOT NULL,
  `lesson_id` int(150) NOT NULL,
  `project_title` text NOT NULL,
  `group_status` varchar(100) NOT NULL DEFAULT 'Active',
  `datetime_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `conversation_id` int(11) DEFAULT NULL,
  `sender_id` bigint(20) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `conversation_id`, `sender_id`, `content`, `created_at`, `is_read`) VALUES
(53, 31, 571458, 'Walter created a conversation', '2024-10-31 08:07:18', 0),
(54, 31, 571458, 'Hi shayne', '2024-10-31 08:07:26', 0),
(55, 31, 999986, 'hi walter', '2024-11-03 11:00:31', 0),
(56, 31, 999986, 'walter test', '2024-11-03 18:19:26', 0),
(57, 30, 999986, 'hello', '2024-11-03 18:19:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `model_comments`
--

CREATE TABLE `model_comments` (
  `model_comment_id` int(150) NOT NULL,
  `model_id` int(150) NOT NULL,
  `user_id` bigint(250) NOT NULL,
  `comment` text NOT NULL,
  `datetime_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `model_comments`
--

INSERT INTO `model_comments` (`model_comment_id`, `model_id`, `user_id`, `comment`, `datetime_created`) VALUES
(1075336, 3, 287342, 'W website', '2024-10-29 17:16:38'),
(1858646, 3, 875014, 'test comment', '2024-10-28 04:33:04'),
(4846556, 19, 830766, 'Test comment', '2024-10-31 06:12:46'),
(9023499, 3, 762819, 'nice', '2024-10-17 13:14:02');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(150) NOT NULL,
  `lesson_id` int(150) NOT NULL,
  `datetime_created` datetime NOT NULL,
  `datetime_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `lesson_id`, `datetime_created`, `datetime_updated`) VALUES
(1, 1, '2024-10-04 13:19:31', '2024-10-04 13:19:31'),
(2, 2, '2024-10-04 13:19:31', '2024-10-04 13:19:31'),
(3, 3, '2024-10-04 13:19:31', '2024-10-04 13:19:31'),
(4, 4, '2024-10-04 13:19:31', '2024-10-04 13:19:31'),
(5, 5, '2024-10-04 13:19:31', '2024-10-04 13:19:31'),
(6, 6, '2024-10-04 13:19:31', '2024-10-04 13:19:31'),
(7, 7, '2024-10-04 13:19:31', '2024-10-04 13:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `attempt_id` int(150) NOT NULL,
  `quiz_id` int(150) NOT NULL,
  `user_id` bigint(250) NOT NULL,
  `score` int(50) NOT NULL,
  `total_questions` int(50) NOT NULL,
  `datetime_created` datetime NOT NULL,
  `datetime_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`attempt_id`, `quiz_id`, `user_id`, `score`, `total_questions`, `datetime_created`, `datetime_updated`) VALUES
(15, 2, 507271, 4, 10, '2024-11-03 09:32:06', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `question_id` int(150) NOT NULL,
  `quiz_id` int(150) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` varchar(50) NOT NULL DEFAULT 'multiple-choice',
  `choice_a` text NOT NULL,
  `choice_b` text NOT NULL,
  `choice_c` text NOT NULL,
  `choice_d` text NOT NULL,
  `correct_answer` enum('A','B','C','D') NOT NULL,
  `datetime_created` datetime NOT NULL,
  `datetime_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`question_id`, `quiz_id`, `question_text`, `question_type`, `choice_a`, `choice_b`, `choice_c`, `choice_d`, `correct_answer`, `datetime_created`, `datetime_updated`) VALUES
(121, 1, 'What is the main function of the CPU in a computer?', 'multiple-choice', 'Store data', 'Process data', 'Display data', 'Connect to the internet', 'B', '2024-10-06 08:31:46', '2024-10-06 08:31:46'),
(122, 1, 'Which of the following is part of the computer chassis?', 'multiple-choice', 'Monitor', 'Motherboard', 'Keyboard', 'Hard drive', 'B', '2024-10-06 08:31:46', '2024-10-06 08:31:46'),
(123, 1, 'What is the primary purpose of a form factor in computer cases?', 'multiple-choice', 'To enhance speed', 'To define the size and layout of components', 'To improve sound quality', 'To power the computer', 'B', '2024-10-06 08:31:46', '2024-10-06 08:31:46'),
(124, 1, 'A laptop computer is different from a desktop because:', 'multiple-choice', 'It consumes more power', 'It has a separate CPU and monitor', 'It is portable', 'It has more storage', 'C', '2024-10-06 08:31:46', '2024-10-06 08:31:46'),
(125, 1, 'An all-in-one computer typically combines:', 'multiple-choice', 'Processor and motherboard', 'Monitor and tower', 'Monitor and system unit', 'CPU and power supply', 'C', '2024-10-06 08:31:46', '2024-10-06 08:31:46'),
(126, 1, 'Which of the following tools is commonly used to maintain laptops?', 'multiple-choice', 'Phillips screwdriver', 'Hammer', 'Pliers', 'Paintbrush', 'A', '2024-10-06 08:31:46', '2024-10-06 08:31:46'),
(127, 1, 'What component is the “brain” of a mobile device?', 'multiple-choice', 'Battery', 'RAM', 'Processor', 'SIM card', 'C', '2024-10-06 08:31:46', '2024-10-06 08:31:46'),
(128, 1, 'Which of these should be regularly cleaned to maintain laptop performance?', 'multiple-choice', 'CPU', 'Fan and vents', 'Power cable', 'Hard drive', 'B', '2024-10-06 08:31:46', '2024-10-06 08:31:46'),
(129, 1, 'Form factor determines the size of the:', 'multiple-choice', 'Processor', 'Power supply', 'Motherboard', 'USB drive', 'C', '2024-10-06 08:31:46', '2024-10-06 08:31:46'),
(130, 1, 'Which of these devices is not considered a mobile device?', 'multiple-choice', 'Smartphone', 'Tablet', 'Desktop computer', 'Smartwatch', 'C', '2024-10-06 08:31:46', '2024-10-06 08:31:46'),
(131, 2, 'What is the first step in disassembling a laptop?', 'multiple-choice', 'Remove the keyboard', 'Disconnect the battery and power', 'Unscrew the chassis', 'Open the laptop', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(132, 2, 'Why is it important to organize screws during disassembly?', 'multiple-choice', 'To speed up the process', 'To avoid losing them', 'To improve airflow', 'To clean the device', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(133, 2, 'Before reassembling a laptop, you should ensure:', 'multiple-choice', 'You have cleaned all internal parts', 'The RAM is upgraded', 'The battery is charged', 'All drivers are installed', 'A', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(134, 2, 'What is a special consideration when working with laptop hardware?', 'multiple-choice', 'More complex cooling systems', 'Non-standardized components', 'Larger power supplies', 'Heavier weight', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(135, 2, 'What can happen if a laptop battery is not removed before disassembly?', 'multiple-choice', 'The laptop will overheat', 'It may damage internal components', 'The keyboard will not work', 'The screen will turn off', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(136, 2, 'After reassembling a laptop, the next step is:', 'multiple-choice', 'Boot the laptop to test functionality', 'Reinstall the operating system', 'Install all drivers', 'Charge the battery', 'A', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(137, 2, 'Which tool is commonly used for opening laptop cases?', 'multiple-choice', 'Hammer', 'Plastic spudger', 'Flathead screwdriver', 'Pliers', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(138, 2, 'How should static electricity be prevented during disassembly?', 'multiple-choice', 'Use a magnetic screwdriver', 'Use an anti-static wrist strap', 'Keep the device plugged in', 'Disassemble near water', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(139, 2, 'What component is typically the hardest to replace in laptops?', 'multiple-choice', 'RAM', 'Battery', 'Keyboard', 'Motherboard', 'D', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(140, 2, 'After reassembling a laptop, you notice a loose component. What should you do?', 'multiple-choice', 'Ignore it', 'Reopen the case and secure it', 'Install a new operating system', 'Press it down harder', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(141, 3, 'What is the purpose of a chipset on a motherboard?', 'multiple-choice', 'To connect storage devices', 'To manage data flow between the processor and peripherals', 'To increase clock speed', 'To cool the CPU', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(142, 3, 'Which socket type is commonly used for Intel processors?', 'multiple-choice', 'AM4', 'LGA', 'PCIe', 'AGP', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(143, 3, 'What are the two main components of a chipset?', 'multiple-choice', 'Northbridge and Southbridge', 'BIOS and CMOS', 'RAM and ROM', 'CPU and GPU', 'A', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(144, 3, 'What is the function of expansion slots?', 'multiple-choice', 'To store data', 'To allow additional components like graphics cards to be added', 'To power the system', 'To regulate cooling', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(145, 3, 'What is the primary role of BIOS/UEFI?', 'multiple-choice', 'To manage installed software', 'To initialize hardware during boot', 'To cool the system', 'To store files', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(146, 3, 'Which type of port is commonly used for connecting a keyboard?', 'multiple-choice', 'HDMI', 'PS/2', 'VGA', 'Ethernet', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(147, 3, 'What should you configure after replacing a motherboard?', 'multiple-choice', 'Power settings', 'BIOS/UEFI settings', 'The mouse', 'The display resolution', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(148, 3, 'What bus type is used for high-speed graphics cards?', 'multiple-choice', 'SATA', 'AGP', 'PCIe', 'USB', 'C', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(149, 3, 'Which of these is an onboard connector?', 'multiple-choice', 'RAM slot', 'SATA port', 'PCIe slot', 'AGP slot', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(150, 3, 'What do you need to do before installing a new motherboard?', 'multiple-choice', 'Update Windows', 'Select a compatible power supply', 'Disable the hard drive', 'Format the hard drive', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(151, 4, 'What is the main function of a computer processor?', 'multiple-choice', 'Store data', 'Execute instructions', 'Display graphics', 'Connect to the internet', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(152, 4, 'What unit is used to measure processor speed?', 'multiple-choice', 'Bytes', 'Hertz (Hz)', 'Volts', 'Amps', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(153, 4, 'Which of the following is NOT a processor manufacturer?', 'multiple-choice', 'Intel', 'AMD', 'Nvidia', 'ARM', 'C', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(154, 4, 'How does a multi-core processor improve performance?', 'multiple-choice', 'By increasing RAM', 'By executing multiple instructions simultaneously', 'By lowering power consumption', 'By increasing the clock speed', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(155, 4, 'What type of memory is volatile and loses its data when powered off?', 'multiple-choice', 'ROM', 'RAM', 'Flash', 'SSD', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(156, 4, 'Which type of memory is used to store the BIOS settings?', 'multiple-choice', 'ROM', 'RAM', 'CMOS', 'Flash', 'C', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(157, 4, 'What should be considered when selecting a new processor?', 'multiple-choice', 'Operating system', 'Motherboard compatibility', 'Monitor type', 'Hard drive capacity', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(158, 4, 'What is a key benefit of DDR4 over DDR3 memory?', 'multiple-choice', 'Increased power consumption', 'Higher speed and lower power usage', 'Larger physical size', 'Backward compatibility', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(159, 4, 'Upgrading memory can improve which aspect of a computer?', 'multiple-choice', 'Graphics quality', 'Speed and multitasking performance', 'Storage capacity', 'Internet connectivity', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(160, 4, 'Which type of memory is non-volatile and used for permanent storage?', 'multiple-choice', 'RAM', 'ROM', 'Flash', 'DRAM', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(161, 5, 'What is the purpose of a computer cooling system?', 'multiple-choice', 'To increase processor speed', 'To maintain an optimal operating temperature', 'To improve display quality', 'To reduce electrical usage', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(162, 5, 'Which component is responsible for distributing power in a desktop computer?', 'multiple-choice', 'Power supply unit (PSU)', 'Motherboard', 'Hard drive', 'CPU', 'A', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(163, 5, 'What issue might indicate a power supply failure?', 'multiple-choice', 'Overheating', 'Blue screen of death (BSOD)', 'No power or lights when the computer is turned on', 'Slow internet speeds', 'C', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(164, 5, 'What does a higher wattage power supply allow?', 'multiple-choice', 'Faster internet', 'Support for more powerful components', 'Increased storage capacity', 'Better cooling', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(165, 5, 'Which part of the laptop is most susceptible to overheating?', 'multiple-choice', 'Screen', 'CPU', 'Keyboard', 'RAM', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(166, 5, 'What is a common cause of overheating in laptops?', 'multiple-choice', 'Too much RAM', 'Dust accumulation in the vents', 'Using a USB mouse', 'Hard drive failure', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(167, 5, 'How can you troubleshoot a motherboard issue?', 'multiple-choice', 'Reset BIOS', 'Replace the monitor', 'Reinstall the operating system', 'Use a different power cord', 'A', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(168, 5, 'What tool can be used to measure power output from the PSU?', 'multiple-choice', 'Multimeter', 'Screwdriver', 'Soldering iron', 'Wire cutter', 'A', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(169, 5, 'When diagnosing a laptop power issue, which should you check first?', 'multiple-choice', 'Battery and charger', 'Screen brightness', 'Keyboard layout', 'Operating system settings', 'A', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(170, 5, 'What could cause a computer to unexpectedly shut down?', 'multiple-choice', 'Loose RAM', 'Overheating or faulty power supply', 'Internet connection failure', 'Broken keyboard', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(171, 6, 'What does SSD stand for?', 'multiple-choice', 'Standard Storage Device', 'Solid State Drive', 'Serial Storage Device', 'Software Storage Disk', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(172, 6, 'Which of the following is NOT a type of storage device?', 'multiple-choice', 'HDD', 'SSD', 'GPU', 'USB Flash Drive', 'C', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(173, 6, 'What is the main difference between an SSD and an HDD?', 'multiple-choice', 'SSDs use flash memory, while HDDs use mechanical platters', 'HDDs are faster than SSDs', 'SSDs consume more power than HDDs', 'SSDs are larger than HDDs', 'A', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(174, 6, 'What is the function of RAID in storage devices?', 'multiple-choice', 'To increase internet speed', 'To create backups and improve performance', 'To boost the processor speed', 'To enhance graphics quality', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(175, 6, 'What storage interface is primarily used for HDDs and SSDs in modern computers?', 'multiple-choice', 'USB', 'PCIe', 'SATA', 'HDMI', 'C', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(176, 6, 'What is the benefit of using an NVMe drive over a traditional SATA SSD?', 'multiple-choice', 'Increased storage capacity', 'Faster data transfer speeds', 'Improved cooling', 'Better power efficiency', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(177, 6, 'Which type of storage is most suitable for long-term data retention?', 'multiple-choice', 'RAM', 'ROM', 'Optical Discs', 'SSD', 'C', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(178, 6, 'Which of the following is considered volatile memory?', 'multiple-choice', 'SSD', 'RAM', 'HDD', 'USB Drive', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(179, 6, 'What does the term “cloud storage” refer to?', 'multiple-choice', 'Storing data on local disks', 'Storing data on a remote server accessed via the internet', 'Using external hard drives', 'Compressing files for storage', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(180, 6, 'What is the advantage of using an external hard drive?', 'multiple-choice', 'It offers faster speeds than internal storage', 'It provides portability and can be used for backups', 'It has unlimited storage capacity', 'It consumes less power', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(181, 7, 'What is the primary input device for a computer?', 'multiple-choice', 'Monitor', 'Keyboard', 'Printer', 'Speaker', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(182, 7, 'What is the function of an output device?', 'multiple-choice', 'To store data', 'To display or output data from a computer', 'To provide power to the system', 'To connect the computer to the internet', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(183, 7, 'Which port is commonly used to connect a monitor to a computer?', 'multiple-choice', 'USB', 'VGA', 'Ethernet', 'HDMI', 'D', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(184, 7, 'Which input device is primarily used for pointing and clicking?', 'multiple-choice', 'Microphone', 'Mouse', 'Keyboard', 'Scanner', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(185, 7, 'What does USB stand for?', 'multiple-choice', 'Universal Serial Bus', 'Universal System Backup', 'Unified Storage Base', 'Unlimited Signal Bandwidth', 'A', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(186, 7, 'What type of device is a printer considered?', 'multiple-choice', 'Input device', 'Output device', 'Both input and output device', 'Storage device', 'B', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(187, 7, 'Which port is often used for connecting network cables?', 'multiple-choice', 'HDMI', 'VGA', 'USB', 'Ethernet', 'D', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(188, 7, 'What is the purpose of a scanner?', 'multiple-choice', 'To input data from a physical document into a digital format', 'To display images', 'To produce sound', 'To store data', 'A', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(189, 7, 'Which of the following is an output device for producing sound?', 'multiple-choice', 'Monitor', 'Printer', 'Speaker', 'Webcam', 'C', '2024-10-04 13:44:08', '2024-10-04 13:44:08'),
(190, 7, 'What is the difference between USB 2.0 and USB 3.0?', 'multiple-choice', 'USB 3.0 provides faster data transfer speeds', 'USB 2.0 uses less power', 'USB 3.0 is smaller in size', 'USB 2.0 supports more devices', 'A', '2024-10-04 13:44:08', '2024-10-04 13:44:08');

-- --------------------------------------------------------

--
-- Table structure for table `system_appearance`
--

CREATE TABLE `system_appearance` (
  `id` bigint(250) NOT NULL,
  `file_name` text NOT NULL,
  `appearance_type` varchar(150) NOT NULL,
  `datetime_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_appearance`
--

INSERT INTO `system_appearance` (`id`, `file_name`, `appearance_type`, `datetime_added`) VALUES
(1, 'LOGO-.png', 'logo', '2024-11-03 15:26:51'),
(2, 'BACKGROUND-11-03-2024-14-16-24.jpg', 'background', '2024-11-03 14:16:24');

-- --------------------------------------------------------

--
-- Table structure for table `users_accounts`
--

CREATE TABLE `users_accounts` (
  `user_id` bigint(250) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_photo` varchar(150) NOT NULL DEFAULT 'default-profile.png',
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_type` varchar(100) NOT NULL DEFAULT 'user',
  `user_status` varchar(100) NOT NULL DEFAULT 'active',
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_accounts`
--

INSERT INTO `users_accounts` (`user_id`, `user_name`, `user_photo`, `user_email`, `user_password`, `user_type`, `user_status`, `date_created`) VALUES
(16, 'NextGen Admin', 'default-profile.png', 'nextgenacademy2002@gmail.com', 'YWRtaW4=', 'admin', 'active', '2024-10-04 12:46:03'),
(142876, 'HANS VILLAFLORES', 'default-profile.png', 'hansvillaflores@gmail.com', 'MTIz', 'user', 'active', '2024-11-02 15:02:44'),
(245404, 'Jaime Tuason', 'default-profile.png', 'jaimetuason@gmail.com', 'cGFzc3dvcmQ=', 'user', 'active', '2024-11-02 12:33:19'),
(320400, 'Jai Tolentino', 'default-profile.png', 'jaitolentinoo@gmail.com', 'Smx0QDU1MjI0NA==', 'user', 'active', '2024-11-02 13:07:24'),
(507271, 'Paul James ', 'default-profile.png', 'pjperz7@gmail.com', 'aGFwcHl5aXBwZXk=', 'user', 'active', '2024-11-03 05:34:27'),
(571458, 'Walter', 'default-profile.png', 'walteriantejada@gmail.com', 'd2FsdGVy', 'user', 'active', '2024-10-31 08:05:09'),
(999986, 'Shayne Victor C. Bauzon', 'default-profile.png', 'shaynebauzon2002@gmail.com', 'c2hheW5lMjAwMg==', 'user', 'active', '2024-10-31 06:06:11');

-- --------------------------------------------------------

--
-- Table structure for table `user_reset_password_logs`
--

CREATE TABLE `user_reset_password_logs` (
  `id` int(11) NOT NULL,
  `user_id` bigint(250) NOT NULL,
  `verify_token` text NOT NULL,
  `is_verified` varchar(200) NOT NULL,
  `reset_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_lectures`
--

CREATE TABLE `video_lectures` (
  `video_lectures_id` int(200) NOT NULL,
  `lesson_id` int(150) NOT NULL,
  `week_number` int(150) NOT NULL,
  `video_url` text NOT NULL,
  `datetime_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video_lectures`
--

INSERT INTO `video_lectures` (`video_lectures_id`, `lesson_id`, `week_number`, `video_url`, `datetime_created`) VALUES
(1, 1, 1, 'http://www.youtube.com/watch?v=FImbNSiUuLU', '2024-10-05 23:28:41'),
(2, 1, 1, 'http://www.youtube.com/watch?v=SP6pA2CYZJI', '2024-10-05 23:28:41'),
(3, 1, 1, 'http://www.youtube.com/watch?v=oqwbPxsN49M', '2024-10-05 23:28:41'),
(4, 1, 1, 'http://www.youtube.com/watch?v=DKpGxONzrhQ', '2024-10-05 23:28:41'),
(5, 1, 1, 'http://www.youtube.com/watch?v=gLZ6n4mQ3Pg', '2024-10-05 23:28:41'),
(6, 1, 1, 'http://www.youtube.com/watch?v=kzqG5iyQVFM', '2024-10-05 23:28:41'),
(7, 1, 1, 'http://www.youtube.com/watch?v=TnrGGMKGsRA', '2024-10-05 23:28:41'),
(8, 1, 1, 'http://www.youtube.com/watch?v=MJUcjfYXiRA', '2024-10-05 23:28:41'),
(9, 2, 2, 'http://www.youtube.com/watch?v=ZIpJiWvzI4E', '2024-10-05 23:28:41'),
(10, 2, 2, 'http://www.youtube.com/watch?v=zSZmGnuxMLg', '2024-10-05 23:28:41'),
(11, 2, 2, 'http://www.youtube.com/watch?v=Crn-Cb5NFvA', '2024-10-05 23:28:41'),
(12, 2, 2, 'http://www.youtube.com/watch?v=32F4et03DTY', '2024-10-05 23:28:41'),
(13, 2, 2, 'http://www.youtube.com/watch?v=Es2RfAdlIcU', '2024-10-05 23:28:41'),
(14, 2, 2, 'http://www.youtube.com/watch?v=hnXjtToq95c', '2024-10-05 23:28:41'),
(15, 3, 3, 'http://www.youtube.com/watch?v=3fq1pYvb9Mk', '2024-10-05 23:28:41'),
(16, 3, 3, 'http://www.youtube.com/watch?v=yB5xkJMrH4Y', '2024-10-05 23:28:41'),
(17, 3, 3, 'http://www.youtube.com/watch?v=Ff33646HZrY', '2024-10-05 23:28:41'),
(18, 3, 3, 'http://www.youtube.com/watch?v=e8zY7zI5Nio', '2024-10-05 23:28:41'),
(19, 3, 3, 'http://www.youtube.com/watch?v=C5gqv6VUw_w', '2024-10-05 23:28:41'),
(20, 3, 3, 'http://www.youtube.com/watch?v=prFVgqRoMlA', '2024-10-05 23:28:41'),
(21, 3, 3, 'http://www.youtube.com/watch?v=Wt0Vpf3wWTA', '2024-10-05 23:28:41'),
(22, 3, 3, 'http://www.youtube.com/watch?v=CvXiG8MxlFU', '2024-10-05 23:28:41'),
(23, 3, 3, 'http://www.youtube.com/watch?v=-bI_f2RNUUU', '2024-10-05 23:28:41'),
(24, 3, 3, 'http://www.youtube.com/watch?v=PdDvgtqcjYQ', '2024-10-05 23:28:41'),
(25, 4, 4, 'http://www.youtube.com/watch?v=w4a-fGhmVGM', '2024-10-05 23:28:41'),
(26, 4, 4, 'http://www.youtube.com/watch?v=FvbVU8n1IX0', '2024-10-05 23:28:41'),
(27, 4, 4, 'http://www.youtube.com/watch?v=W1g_Vtb7Tg8', '2024-10-05 23:28:41'),
(28, 4, 4, 'http://www.youtube.com/watch?v=fPD3VvBbvhg', '2024-10-05 23:28:41'),
(29, 4, 4, 'http://www.youtube.com/watch?v=N143M6ixRVM', '2024-10-05 23:28:41'),
(30, 4, 4, 'http://www.youtube.com/watch?v=uRZOUFiaudY', '2024-10-05 23:28:41'),
(31, 4, 4, 'http://www.youtube.com/watch?v=JjcyIv0Kpjo', '2024-10-05 23:28:41'),
(32, 4, 4, 'http://www.youtube.com/watch?v=9pYbfQPA3TU', '2024-10-05 23:28:41'),
(33, 5, 5, 'http://www.youtube.com/watch?v=3T0WTBr56EQ', '2024-10-05 23:28:41'),
(34, 5, 5, 'http://www.youtube.com/watch?v=H6D7zL2KLqI', '2024-10-05 23:28:41'),
(35, 5, 5, 'http://www.youtube.com/watch?v=kpFoiA9NCA0', '2024-10-05 23:28:41'),
(36, 5, 5, 'http://www.youtube.com/watch?v=gzWluLSTneU', '2024-10-05 23:28:41'),
(37, 5, 5, 'http://www.youtube.com/watch?v=eFsCu9ZHpNA', '2024-10-05 23:28:41'),
(38, 5, 5, 'http://www.youtube.com/watch?v=XhPneP-TiNI', '2024-10-05 23:28:41'),
(39, 5, 5, 'http://www.youtube.com/watch?v=JEq49WtEOWw', '2024-10-05 23:28:41'),
(40, 5, 5, 'http://www.youtube.com/watch?v=pW1Ot06SfGg', '2024-10-05 23:28:41'),
(41, 6, 6, 'http://www.youtube.com/watch?v=GqKfPMc8e9s', '2024-10-05 23:28:41'),
(42, 6, 6, 'http://www.youtube.com/watch?v=bI1atUOkFrw', '2024-10-05 23:28:41'),
(43, 6, 6, 'http://www.youtube.com/watch?v=BgvIdH1whwQ', '2024-10-05 23:28:41'),
(44, 6, 6, 'http://www.youtube.com/watch?v=hKM0iTtXPi4', '2024-10-05 23:28:41'),
(45, 6, 6, 'http://www.youtube.com/watch?v=chgEX3L5SRE', '2024-10-05 23:28:41'),
(46, 6, 6, 'http://www.youtube.com/watch?v=ZT6jEVKp9Dg', '2024-10-05 23:28:41'),
(47, 6, 6, 'http://www.youtube.com/watch?v=7A9xD95-7fA', '2024-10-05 23:28:41'),
(48, 6, 6, 'http://www.youtube.com/watch?v=eHMigHOzteM', '2024-10-05 23:28:41'),
(49, 7, 7, 'http://www.youtube.com/watch?v=I_AlStnNA-s', '2024-10-05 23:28:41'),
(50, 7, 7, 'http://www.youtube.com/watch?v=64b9cBvhIqM', '2024-10-05 23:28:41'),
(51, 7, 7, 'http://www.youtube.com/watch?v=WrndJZcgbqc', '2024-10-05 23:28:41'),
(52, 7, 7, 'http://www.youtube.com/watch?v=GnvG_6xMFlI', '2024-10-05 23:28:41'),
(53, 7, 7, 'http://www.youtube.com/watch?v=GmChPMsSDH4', '2024-10-05 23:28:41'),
(54, 7, 7, 'http://www.youtube.com/watch?v=crijGdswikY', '2024-10-05 23:28:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `3d_models`
--
ALTER TABLE `3d_models`
  ADD PRIMARY KEY (`model_id`);

--
-- Indexes for table `account_verification`
--
ALTER TABLE `account_verification`
  ADD PRIMARY KEY (`verification_id`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversation_id`);

--
-- Indexes for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`forum_id`);

--
-- Indexes for table `forum_comments`
--
ALTER TABLE `forum_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_forum` (`forum_id`),
  ADD KEY `fk_user_comment` (`user_id`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `fk_group_members` (`group_id`);

--
-- Indexes for table `group_tasks`
--
ALTER TABLE `group_tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `fk_group_tasks` (`group_id`);

--
-- Indexes for table `lecture_messages`
--
ALTER TABLE `lecture_messages`
  ADD PRIMARY KEY (`lecture_message_id`),
  ADD KEY `fk_video_lecture` (`video_lectures_id`),
  ADD KEY `fk_user_message` (`user_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`);

--
-- Indexes for table `lesson_group_collaborators`
--
ALTER TABLE `lesson_group_collaborators`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `fk_lesson_group` (`lesson_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `model_comments`
--
ALTER TABLE `model_comments`
  ADD PRIMARY KEY (`model_comment_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `fk_quizzes` (`lesson_id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `fk_quiz_attempts` (`quiz_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `fk_quiz_questions` (`quiz_id`);

--
-- Indexes for table `system_appearance`
--
ALTER TABLE `system_appearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_accounts`
--
ALTER TABLE `users_accounts`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_reset_password_logs`
--
ALTER TABLE `user_reset_password_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `video_lectures`
--
ALTER TABLE `video_lectures`
  ADD PRIMARY KEY (`video_lectures_id`),
  ADD KEY `fk_video_lectures` (`lesson_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `3d_models`
--
ALTER TABLE `3d_models`
  MODIFY `model_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `account_verification`
--
ALTER TABLE `account_verification`
  MODIFY `verification_id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=841240;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `forum_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9686213;

--
-- AUTO_INCREMENT for table `forum_comments`
--
ALTER TABLE `forum_comments`
  MODIFY `comment_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9810220;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `member_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `group_tasks`
--
ALTER TABLE `group_tasks`
  MODIFY `task_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `lecture_messages`
--
ALTER TABLE `lecture_messages`
  MODIFY `lecture_message_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `lesson_group_collaborators`
--
ALTER TABLE `lesson_group_collaborators`
  MODIFY `group_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=929937;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `model_comments`
--
ALTER TABLE `model_comments`
  MODIFY `model_comment_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9951651;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57442;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `attempt_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `question_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `system_appearance`
--
ALTER TABLE `system_appearance`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_accounts`
--
ALTER TABLE `users_accounts`
  MODIFY `user_id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=999987;

--
-- AUTO_INCREMENT for table `user_reset_password_logs`
--
ALTER TABLE `user_reset_password_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99721369;

--
-- AUTO_INCREMENT for table `video_lectures`
--
ALTER TABLE `video_lectures`
  MODIFY `video_lectures_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=777450;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`message_id`) ON DELETE CASCADE;

--
-- Constraints for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  ADD CONSTRAINT `conversation_participants_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`conversation_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversation_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users_accounts` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `forum_comments`
--
ALTER TABLE `forum_comments`
  ADD CONSTRAINT `fk_forum` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`forum_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_comment` FOREIGN KEY (`user_id`) REFERENCES `users_accounts` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `fk_group_members` FOREIGN KEY (`group_id`) REFERENCES `lesson_group_collaborators` (`group_id`) ON DELETE CASCADE;

--
-- Constraints for table `group_tasks`
--
ALTER TABLE `group_tasks`
  ADD CONSTRAINT `fk_group_tasks` FOREIGN KEY (`group_id`) REFERENCES `lesson_group_collaborators` (`group_id`) ON DELETE CASCADE;

--
-- Constraints for table `lecture_messages`
--
ALTER TABLE `lecture_messages`
  ADD CONSTRAINT `fk_user_message` FOREIGN KEY (`user_id`) REFERENCES `users_accounts` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_video_lecture` FOREIGN KEY (`video_lectures_id`) REFERENCES `video_lectures` (`video_lectures_id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_group_collaborators`
--
ALTER TABLE `lesson_group_collaborators`
  ADD CONSTRAINT `fk_lesson_group` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`conversation_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users_accounts` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `fk_quizzes` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `fk_quiz_attempts` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_quiz_attempts_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `fk_quiz_questions` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_quiz_questions_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_reset_password_logs`
--
ALTER TABLE `user_reset_password_logs`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users_accounts` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `video_lectures`
--
ALTER TABLE `video_lectures`
  ADD CONSTRAINT `fk_video_lectures` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
