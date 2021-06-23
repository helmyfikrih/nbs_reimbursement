-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2021 at 02:41 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nbs_reimburse`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(11) NOT NULL DEFAULT 0,
  `data` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('1857j5ck6krinlq5tjqha680uko2hdcq', '::1', 1624352534, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343335323533343b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2231223b733a383a22757365726e616d65223b733a353a2261646d696e223b733a373a22726f6c655f6964223b733a313a2231223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('2ci8pqt3mff4tosms7lqr24c6men3ck1', '::1', 1624357102, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343335373130323b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2231223b733a383a22757365726e616d65223b733a353a2261646d696e223b733a373a22726f6c655f6964223b733a313a2231223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('4ph51isuj4ort1o6nda8h0vehde8sthf', '::1', 1624360352, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343336303335323b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2235223b733a383a22757365726e616d65223b733a383a227065676177616933223b733a373a22726f6c655f6964223b733a313a2233223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('534u8tm0utcui8qv3fb4omq59m260v61', '::1', 1624362169, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343336323136393b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2235223b733a383a22757365726e616d65223b733a383a227065676177616933223b733a373a22726f6c655f6964223b733a313a2233223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('5gr764dts1sajjn9aqvqt6kmiovue596', '::1', 1624357709, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343335373730393b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2231223b733a383a22757365726e616d65223b733a353a2261646d696e223b733a373a22726f6c655f6964223b733a313a2231223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('5ljq2lhhn5ajeq52fu8l71djkl2kf1pr', '::1', 1624355269, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343335353236393b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2231223b733a383a22757365726e616d65223b733a353a2261646d696e223b733a373a22726f6c655f6964223b733a313a2231223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('7q4n1lr6fhog1i8cpknq2ehq1o90di0r', '::1', 1624362553, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343336323338383b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2231223b733a383a22757365726e616d65223b733a353a2261646d696e223b733a373a22726f6c655f6964223b733a313a2231223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('8lkj242mp10bb9cc5mt0dm3ovt7b09f7', '::1', 1624355574, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343335353537343b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2231223b733a383a22757365726e616d65223b733a353a2261646d696e223b733a373a22726f6c655f6964223b733a313a2231223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('a39r11452e32t9uvdg3a28lhfb43h1r1', '::1', 1624353784, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343335333738343b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2231223b733a383a22757365726e616d65223b733a353a2261646d696e223b733a373a22726f6c655f6964223b733a313a2231223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('grk0n2ukukkfq54rsghmg7aibnbdalv9', '::1', 1624356460, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343335363436303b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2231223b733a383a22757365726e616d65223b733a353a2261646d696e223b733a373a22726f6c655f6964223b733a313a2231223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('k7peuhhp6dilu2knkfj3d0vm4gkcms85', '::1', 1624355944, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343335353934343b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2231223b733a383a22757365726e616d65223b733a353a2261646d696e223b733a373a22726f6c655f6964223b733a313a2231223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('osa7moj2mrr58ra4g3epgci5vri03u7h', '::1', 1624354545, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343335343534353b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2231223b733a383a22757365726e616d65223b733a353a2261646d696e223b733a373a22726f6c655f6964223b733a313a2231223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('q97i036oq2l1u16cu3ld1fpq50auc06r', '::1', 1624360709, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343336303730393b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2235223b733a383a22757365726e616d65223b733a383a227065676177616933223b733a373a22726f6c655f6964223b733a313a2233223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('rqbses962n7meq878ngo9fi3a56mijq5', '::1', 1624356765, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343335363736353b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2231223b733a383a22757365726e616d65223b733a353a2261646d696e223b733a373a22726f6c655f6964223b733a313a2231223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('skdmb8lqm3lcsi002rolitoh5m1k6mrf', '::1', 1624352232, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343335323233323b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2231223b733a383a22757365726e616d65223b733a353a2261646d696e223b733a373a22726f6c655f6964223b733a313a2231223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d),
('uvv391fuem7ccmvojh6tboegotub4nec', '::1', 1624358412, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632343335383431323b6c6f676765645f696e7c613a343a7b733a373a22757365725f6964223b733a313a2235223b733a383a22757365726e616d65223b733a383a227065676177616933223b733a373a22726f6c655f6964223b733a313a2233223b733a383a226c616e6775616765223b733a393a22696e646f6e65736961223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `kms_system_settings`
--

CREATE TABLE `kms_system_settings` (
  `setting_id` int(11) NOT NULL,
  `application_name` varchar(255) DEFAULT NULL,
  `header_name` varchar(255) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `footer_year` int(11) DEFAULT NULL,
  `sys_info` varchar(255) DEFAULT NULL,
  `sys_smtp_host` varchar(255) DEFAULT NULL,
  `sys_smtp_user` varchar(255) DEFAULT NULL,
  `sys_smtp_pass` varchar(255) DEFAULT NULL,
  `sys_smtp_crypto` varchar(255) DEFAULT NULL,
  `sys_smtp_port` varchar(255) DEFAULT NULL,
  `sys_smtp_from` varchar(255) DEFAULT NULL,
  `sys_smtp_alias` varchar(255) DEFAULT NULL,
  `logo_header` varchar(255) DEFAULT NULL,
  `logo_icon` varchar(255) DEFAULT NULL,
  `active_register_role` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kms_system_settings`
--

INSERT INTO `kms_system_settings` (`setting_id`, `application_name`, `header_name`, `footer_text`, `footer_year`, `sys_info`, `sys_smtp_host`, `sys_smtp_user`, `sys_smtp_pass`, `sys_smtp_crypto`, `sys_smtp_port`, `sys_smtp_from`, `sys_smtp_alias`, `logo_header`, `logo_icon`, `active_register_role`) VALUES
(1, 'NBS Test Reumbursement', 'NBS Test Reumbursement', 'NBS Test Reumbursement', 2020, 'Maintenance', 'smtp.gmail.com', 'helmyfikrih@gmail.com', 'xayitsJi9b/1', 'ssl', '465', 'helmyfikrih@gmail.com', 'KMSchool.com', 'logo.png', 'logo.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_appointment`
--

CREATE TABLE `m_appointment` (
  `appointment_id` int(11) NOT NULL,
  `appointmen_name` varchar(255) NOT NULL,
  `appointment_status` int(11) NOT NULL,
  `appointment_created_at` datetime DEFAULT NULL,
  `appointment_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `m_department`
--

CREATE TABLE `m_department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `department_status` int(11) NOT NULL,
  `department_created_at` datetime DEFAULT NULL,
  `department_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `m_managerial`
--

CREATE TABLE `m_managerial` (
  `manager_id` int(11) NOT NULL,
  `manager_type` varchar(255) NOT NULL,
  `manager_created_at` datetime DEFAULT NULL,
  `manager_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `manager_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_managerial`
--

INSERT INTO `m_managerial` (`manager_id`, `manager_type`, `manager_created_at`, `manager_modified_at`, `manager_status`) VALUES
(1, 'Line Manager 1', NULL, '2021-06-22 10:25:10', 1),
(2, 'Line Manager 2', NULL, '2021-06-22 10:25:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_menu`
--

CREATE TABLE `m_menu` (
  `menu_id` int(11) NOT NULL,
  `menu_url` varchar(255) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_nama` varchar(255) NOT NULL,
  `menu_parent` int(11) NOT NULL,
  `menu_child` tinyint(1) NOT NULL,
  `menu_sort` int(11) NOT NULL,
  `menu_icon` varchar(255) DEFAULT NULL,
  `menu_status` int(11) NOT NULL,
  `menu_access` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_menu`
--

INSERT INTO `m_menu` (`menu_id`, `menu_url`, `menu_name`, `menu_nama`, `menu_parent`, `menu_child`, `menu_sort`, `menu_icon`, `menu_status`, `menu_access`) VALUES
(1, 'home', 'Home', 'Home', 0, 0, 1, 'fa fa-home', 1, NULL),
(2, '#', 'Minutes', 'Notulensi', 0, 1, 2, 'fa fa-edit', 0, NULL),
(3, 'user', 'Data Users', 'Data Pengguna', 12, 0, 1, 'fa fa-user', 0, 'add,delete,view,edit'),
(4, '#', 'Settings', 'Pengaturan', 0, 1, 100, 'fa fa-cogs', 1, NULL),
(5, 'profile', 'Profile', 'Profil', 4, 0, 1, 'fa fa-user', 0, NULL),
(6, '#', 'Document', 'Dokumen', 0, 1, 3, 'fa fa-book', 0, ''),
(7, '#', 'Forum', 'Forum', 0, 1, 7, 'fa fa-comments-o', 0, NULL),
(8, 'role', 'Data Role', 'Data Role', 12, 0, 3, 'fa fa-user', 1, NULL),
(9, 'document', 'Document List', 'Daftar Dokumen', 6, 0, 6, 'fa fa-book', 0, 'upload,add,validasi,edit,delete,view'),
(10, 'forum', 'Forum List', 'Daftar Forum', 7, 0, 3, 'fa fa-comment', 0, 'add,comment,edit,delete,close,open'),
(11, 'notulensi', 'Minutes List', 'Daftar Notulensi', 2, 0, 1, 'fa fa-paper', 0, 'add,edit,delete,validasi,view'),
(12, '#', 'Data Master', 'Data Master', 4, 1, 1, 'fa fa-database', 1, NULL),
(13, 'designation', 'Data Designation', 'Data Jabatan', 12, 0, 3, 'fa fa-thumb-tack', 0, NULL),
(14, 'subject', 'Data Subejcts', 'Data Mata Pelajaran', 12, 0, 2, 'fa fa-book', 0, NULL),
(15, 'document_type', 'Document Type', 'Jenis Dokumen', 12, 0, 4, 'fa fa-list', 0, NULL),
(16, 'announcement', 'Announcement List', 'Daftar Pengumuman', 24, 0, 1, 'fa fa-bullhorn', 0, 'add,edit,delete,view'),
(17, 'settings', 'System Settings', 'Pengaturan System', 4, 0, 1, 'fa fa-cogs', 1, NULL),
(18, 'meeting_type', 'Meeting Type', 'Tipe Rapat', 12, 0, 5, 'fa fa-list', 0, NULL),
(19, 'register_user', 'User Register', 'Pendaftaran Pengguna', 12, 0, 0, 'fa fa-users', 0, NULL),
(20, '#', 'Calculation', 'Perhitungan', 0, 1, 99, 'fa fa-tachometer', 0, NULL),
(21, 'topsis', 'Topsis', 'Topsis', 20, 0, 1, 'fa fa-tachometer', 0, NULL),
(23, 'schools', 'Data Schools', 'Data Sekolah', 12, 0, 3, 'fa fa-home', 0, 'add,view,edit'),
(24, '#', 'Announcement', 'Pengumuman', 0, 1, 8, 'fa fa-bullhorn', 0, NULL),
(25, '#', 'Letter', 'Surat', 0, 1, 7, 'fa fa-envelope', 0, NULL),
(26, 'letter', 'Letter List', 'Daftar Surat', 25, 0, 1, 'fa fa-envelope', 0, 'upload,add,validasi,edit,delete,view'),
(27, '#', 'Reimburse', 'Reimburse', 0, 1, 7, 'fa fa-envelope', 1, NULL),
(28, 'reimburse', 'Reimburse List', 'Reimburse List', 27, 0, 1, 'fa fa-envelope', 1, 'upload,add,validasi,edit,delete,view');

-- --------------------------------------------------------

--
-- Table structure for table `m_reimburse_type`
--

CREATE TABLE `m_reimburse_type` (
  `reimburse_type_id` int(11) NOT NULL,
  `reimburse_type_name` varchar(255) DEFAULT NULL,
  `reimburse_type_status` int(11) DEFAULT NULL,
  `reimburse_type_created_at` datetime DEFAULT NULL,
  `reimburse_type_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_reimburse_type`
--

INSERT INTO `m_reimburse_type` (`reimburse_type_id`, `reimburse_type_name`, `reimburse_type_status`, `reimburse_type_created_at`, `reimburse_type_modified_at`) VALUES
(1, 'travel', 1, NULL, '2021-06-22 08:35:11'),
(2, 'shift', 1, NULL, '2021-06-22 08:35:11');

-- --------------------------------------------------------

--
-- Table structure for table `m_role`
--

CREATE TABLE `m_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_status` int(11) NOT NULL,
  `role_created_at` datetime DEFAULT NULL,
  `role_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role_allow_menu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_role`
--

INSERT INTO `m_role` (`role_id`, `role_name`, `role_status`, `role_created_at`, `role_modified_at`, `role_allow_menu`) VALUES
(1, 'admin', 1, NULL, '2021-06-22 07:43:07', '1,27,28,level_28_upload,level_28_add,level_28_validasi,level_28_edit,level_28_delete,level_28_view,4,12,8,17'),
(2, 'stackholder', 1, NULL, '2021-06-22 10:18:03', '1,27,28,level_28_upload,level_28_add,level_28_validasi,level_28_edit,level_28_delete,level_28_view'),
(3, 'pegawai', 1, NULL, '2021-06-22 10:18:19', '1,27,28,level_28_upload,level_28_add,level_28_edit,level_28_delete,level_28_view');

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE `m_user` (
  `user_id` bigint(20) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_status` int(11) NOT NULL,
  `user_created_at` datetime DEFAULT NULL,
  `user_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`user_id`, `role_id`, `user_username`, `user_password`, `user_email`, `user_status`, `user_created_at`, `user_modified_at`) VALUES
(1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'pegawai@mail.com', 1, NULL, '2021-06-22 07:13:58'),
(2, 3, 'pegawai', '047aeeb234644b9e2d4138ed3bc7976a', 'pegawai@mail.com', 1, NULL, '2021-06-22 07:33:03'),
(3, 2, 'pimpinan', '90973652b88fe07d05a4304f0a945de8', 'pimpinan@mail.com', 1, NULL, '2021-06-22 10:23:39'),
(4, 1, 'pegawai2', 'fa23517aa1adfaab707494340009a330', 'pegawai2@mail.com', 1, NULL, '2021-06-22 10:23:33'),
(5, 3, 'pegawai3', '64d49c82b467b76f5d1d5c3179c28f3b', 'pegawai3@mail.com', 1, NULL, '2021-06-22 10:23:25');

-- --------------------------------------------------------

--
-- Table structure for table `reimburse`
--

CREATE TABLE `reimburse` (
  `reimburse_id` bigint(20) NOT NULL,
  `reimburse_type_id` int(11) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `reimburse_start_date` date NOT NULL,
  `reimburse_end_date` date NOT NULL,
  `reimburse_status` int(11) NOT NULL,
  `reimburse_value` float NOT NULL,
  `reimburse_created_at` datetime NOT NULL,
  `reimburse_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reimburse_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reimburse_approval`
--

CREATE TABLE `reimburse_approval` (
  `reimburse_approval_id` bigint(20) NOT NULL,
  `reimburse_id` bigint(20) DEFAULT NULL,
  `user_manager_id` int(11) DEFAULT NULL,
  `reimburse_approval_status` int(11) NOT NULL,
  `reimburse_approval_created_at` datetime DEFAULT NULL,
  `reimburse_approval_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reimburse_approval_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reimburse_attachment`
--

CREATE TABLE `reimburse_attachment` (
  `reimburse_attachment_id` bigint(20) NOT NULL,
  `reimburse_id` bigint(20) DEFAULT NULL,
  `reimburse_attachment_name` varchar(255) NOT NULL,
  `reimburse_attachment_dir` varchar(255) NOT NULL,
  `reimburse_attachment_client_name` varchar(255) NOT NULL,
  `reimburse_attachment_url` varchar(255) NOT NULL,
  `reimburse_attachment_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_managerial`
--

CREATE TABLE `users_managerial` (
  `user_managerial_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `user_manager_id` int(11) DEFAULT NULL,
  `user_managerial_status` int(11) NOT NULL,
  `user_managerial_created_at` datetime DEFAULT NULL,
  `user_managerial_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_managerial`
--

INSERT INTO `users_managerial` (`user_managerial_id`, `user_id`, `user_manager_id`, `user_managerial_status`, `user_managerial_created_at`, `user_managerial_modified_at`) VALUES
(1, 5, 1, 1, NULL, '2021-06-22 10:27:20'),
(2, 5, 2, 1, NULL, '2021-06-22 10:27:58');

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE `user_detail` (
  `user_id` bigint(20) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `user_f_name` varchar(255) NOT NULL,
  `user_l_name` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_photo_url` varchar(255) DEFAULT NULL,
  `user_detail_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_manager`
--

CREATE TABLE `user_manager` (
  `user_manager_id` int(11) NOT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `user_manager_status` int(11) NOT NULL,
  `user_manager_created_at` datetime DEFAULT NULL,
  `user_manager_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_manager`
--

INSERT INTO `user_manager` (`user_manager_id`, `manager_id`, `user_id`, `user_manager_status`, `user_manager_created_at`, `user_manager_modified_at`) VALUES
(1, 1, 2, 1, NULL, '2021-06-22 10:25:52'),
(2, 2, 4, 1, NULL, '2021-06-22 10:26:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kms_system_settings`
--
ALTER TABLE `kms_system_settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `m_appointment`
--
ALTER TABLE `m_appointment`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `m_department`
--
ALTER TABLE `m_department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `m_managerial`
--
ALTER TABLE `m_managerial`
  ADD PRIMARY KEY (`manager_id`);

--
-- Indexes for table `m_menu`
--
ALTER TABLE `m_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `m_reimburse_type`
--
ALTER TABLE `m_reimburse_type`
  ADD PRIMARY KEY (`reimburse_type_id`);

--
-- Indexes for table `m_role`
--
ALTER TABLE `m_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `relationship_5` (`role_id`);

--
-- Indexes for table `reimburse`
--
ALTER TABLE `reimburse`
  ADD PRIMARY KEY (`reimburse_id`),
  ADD KEY `relationship_10` (`user_id`),
  ADD KEY `relationship_8` (`reimburse_type_id`);

--
-- Indexes for table `reimburse_approval`
--
ALTER TABLE `reimburse_approval`
  ADD PRIMARY KEY (`reimburse_approval_id`),
  ADD KEY `relationship_11` (`user_manager_id`),
  ADD KEY `relationship_9` (`reimburse_id`);

--
-- Indexes for table `reimburse_attachment`
--
ALTER TABLE `reimburse_attachment`
  ADD PRIMARY KEY (`reimburse_attachment_id`),
  ADD KEY `relationship_7` (`reimburse_id`);

--
-- Indexes for table `users_managerial`
--
ALTER TABLE `users_managerial`
  ADD PRIMARY KEY (`user_managerial_id`),
  ADD KEY `relationship_12` (`user_id`),
  ADD KEY `relationship_13` (`user_manager_id`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD KEY `relationship_1` (`user_id`),
  ADD KEY `relationship_2` (`department_id`),
  ADD KEY `relationship_6` (`appointment_id`);

--
-- Indexes for table `user_manager`
--
ALTER TABLE `user_manager`
  ADD PRIMARY KEY (`user_manager_id`),
  ADD KEY `relationship_3` (`manager_id`),
  ADD KEY `relationship_4` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kms_system_settings`
--
ALTER TABLE `kms_system_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_appointment`
--
ALTER TABLE `m_appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_department`
--
ALTER TABLE `m_department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_managerial`
--
ALTER TABLE `m_managerial`
  MODIFY `manager_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_menu`
--
ALTER TABLE `m_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `m_reimburse_type`
--
ALTER TABLE `m_reimburse_type`
  MODIFY `reimburse_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_role`
--
ALTER TABLE `m_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_user`
--
ALTER TABLE `m_user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reimburse`
--
ALTER TABLE `reimburse`
  MODIFY `reimburse_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reimburse_approval`
--
ALTER TABLE `reimburse_approval`
  MODIFY `reimburse_approval_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reimburse_attachment`
--
ALTER TABLE `reimburse_attachment`
  MODIFY `reimburse_attachment_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_managerial`
--
ALTER TABLE `users_managerial`
  MODIFY `user_managerial_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_manager`
--
ALTER TABLE `user_manager`
  MODIFY `user_manager_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_user`
--
ALTER TABLE `m_user`
  ADD CONSTRAINT `relationship_5` FOREIGN KEY (`role_id`) REFERENCES `m_role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reimburse`
--
ALTER TABLE `reimburse`
  ADD CONSTRAINT `relationship_10` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relationship_8` FOREIGN KEY (`reimburse_type_id`) REFERENCES `m_reimburse_type` (`reimburse_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reimburse_approval`
--
ALTER TABLE `reimburse_approval`
  ADD CONSTRAINT `relationship_11` FOREIGN KEY (`user_manager_id`) REFERENCES `user_manager` (`user_manager_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relationship_9` FOREIGN KEY (`reimburse_id`) REFERENCES `reimburse` (`reimburse_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reimburse_attachment`
--
ALTER TABLE `reimburse_attachment`
  ADD CONSTRAINT `relationship_7` FOREIGN KEY (`reimburse_id`) REFERENCES `reimburse` (`reimburse_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_managerial`
--
ALTER TABLE `users_managerial`
  ADD CONSTRAINT `relationship_12` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relationship_13` FOREIGN KEY (`user_manager_id`) REFERENCES `user_manager` (`user_manager_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD CONSTRAINT `relationship_1` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relationship_2` FOREIGN KEY (`department_id`) REFERENCES `m_department` (`department_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relationship_6` FOREIGN KEY (`appointment_id`) REFERENCES `m_appointment` (`appointment_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_manager`
--
ALTER TABLE `user_manager`
  ADD CONSTRAINT `relationship_3` FOREIGN KEY (`manager_id`) REFERENCES `m_managerial` (`manager_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `relationship_4` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
