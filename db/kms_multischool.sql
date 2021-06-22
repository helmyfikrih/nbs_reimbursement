-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2020 at 12:39 PM
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
-- Database: `test_kms`
--

-- --------------------------------------------------------

--
-- Table structure for table `kms_announcement`
--

CREATE TABLE `kms_announcement` (
  `announ_id` bigint(20) NOT NULL,
  `school_id` bigint(20) DEFAULT NULL,
  `announ_subject` longtext NOT NULL,
  `announ_number` longtext NOT NULL,
  `announ_date` date NOT NULL,
  `announ_title` longtext NOT NULL,
  `announ_content` text NOT NULL,
  `announ_status` int(11) NOT NULL,
  `announ_created_date` datetime NOT NULL,
  `announ_created_by` int(11) NOT NULL,
  `announ_last_update` datetime DEFAULT NULL,
  `announ_last_update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kms_announcement_attachment`
--

CREATE TABLE `kms_announcement_attachment` (
  `aa_id` bigint(20) NOT NULL,
  `announ_id` bigint(20) DEFAULT NULL,
  `aa_name` longtext NOT NULL,
  `aa_dir` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kms_designation`
--

CREATE TABLE `kms_designation` (
  `designation_id` int(11) NOT NULL,
  `designation_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kms_designation`
--

INSERT INTO `kms_designation` (`designation_id`, `designation_name`) VALUES
(2, 'Guru'),
(3, 'Kepala Sekolah'),
(4, 'Wali Kelas'),
(5, 'Murid');

-- --------------------------------------------------------

--
-- Table structure for table `kms_document`
--

CREATE TABLE `kms_document` (
  `document_id` bigint(20) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `doctype_id` int(11) DEFAULT NULL,
  `school_id` bigint(20) DEFAULT NULL,
  `document_code` varchar(255) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `document_desc` varchar(255) NOT NULL,
  `document_status` int(11) NOT NULL,
  `document_is_request` int(11) DEFAULT NULL,
  `document_created_date` datetime NOT NULL,
  `document_last_update` datetime DEFAULT NULL,
  `document_last_update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kms_document_attachment`
--

CREATE TABLE `kms_document_attachment` (
  `da_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `document_id` bigint(20) DEFAULT NULL,
  `da_name` varchar(255) NOT NULL,
  `da_dir` varchar(255) NOT NULL,
  `da_status` int(11) DEFAULT NULL,
  `da_created_date` datetime DEFAULT NULL,
  `da_last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kms_document_type`
--

CREATE TABLE `kms_document_type` (
  `doctype_id` int(11) NOT NULL,
  `doctype_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kms_document_type`
--

INSERT INTO `kms_document_type` (`doctype_id`, `doctype_name`) VALUES
(1, 'Bahan Ajar'),
(2, 'Training'),
(3, 'Gallery');

-- --------------------------------------------------------

--
-- Table structure for table `kms_forum`
--

CREATE TABLE `kms_forum` (
  `forum_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `forum_title` varchar(255) NOT NULL,
  `forum_slug` varchar(255) NOT NULL,
  `forum_category` varchar(255) DEFAULT NULL,
  `forum_content` text NOT NULL,
  `forum_created_date` datetime NOT NULL,
  `forum_last_update` datetime DEFAULT NULL,
  `forum_last_update_by` int(11) DEFAULT NULL,
  `forum_status` int(11) NOT NULL,
  `forum_is_closed` int(11) DEFAULT NULL,
  `forum_closed_by` int(11) DEFAULT NULL,
  `forum_closed_date` datetime DEFAULT NULL,
  `forum_open_by` int(11) DEFAULT NULL,
  `forum_open_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kms_forum_comment`
--

CREATE TABLE `kms_forum_comment` (
  `fc_id` bigint(20) NOT NULL,
  `forum_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `fc_status` int(11) NOT NULL,
  `fc_content` text NOT NULL,
  `fc_created_date` datetime NOT NULL,
  `fc_last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kms_log_search`
--

CREATE TABLE `kms_log_search` (
  `ls_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `ls_keyword` varchar(255) NOT NULL,
  `ls_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kms_meeting_type`
--

CREATE TABLE `kms_meeting_type` (
  `meetType_id` int(11) NOT NULL,
  `meetType_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kms_meeting_type`
--

INSERT INTO `kms_meeting_type` (`meetType_id`, `meetType_name`) VALUES
(2, 'Mingguan'),
(3, 'Bulanan');

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
(2, '#', 'Minutes', 'Notulensi', 0, 1, 2, 'fa fa-edit', 1, NULL),
(3, 'user', 'Data Users', 'Data Pengguna', 12, 0, 1, 'fa fa-user', 1, 'add,delete,view,edit'),
(4, '#', 'Settings', 'Pengaturan', 0, 1, 100, 'fa fa-cogs', 1, NULL),
(5, 'profile', 'Profile', 'Profil', 4, 0, 1, 'fa fa-user', 1, NULL),
(6, '#', 'Document', 'Dokumen', 0, 1, 3, 'fa fa-book', 1, ''),
(7, '#', 'Forum', 'Forum', 0, 1, 7, 'fa fa-comments-o', 1, NULL),
(8, 'role', 'Data Role', 'Data Role', 12, 0, 3, 'fa fa-user', 1, NULL),
(9, 'document', 'Document List', 'Daftar Dokumen', 6, 0, 6, 'fa fa-book', 1, 'upload,add,validasi,edit,delete,view'),
(10, 'forum', 'Forum List', 'Daftar Forum', 7, 0, 3, 'fa fa-comment', 1, 'add,comment,edit,delete,close,open'),
(11, 'notulensi', 'Minutes List', 'Daftar Notulensi', 2, 0, 1, 'fa fa-paper', 1, 'add,edit,delete,validasi,view'),
(12, '#', 'Data Master', 'Data Master', 4, 1, 1, 'fa fa-database', 1, NULL),
(13, 'designation', 'Data Designation', 'Data Jabatan', 12, 0, 3, 'fa fa-thumb-tack', 1, NULL),
(14, 'subject', 'Data Subejcts', 'Data Mata Pelajaran', 12, 0, 2, 'fa fa-book', 1, NULL),
(15, 'document_type', 'Document Type', 'Jenis Dokumen', 12, 0, 4, 'fa fa-list', 1, NULL),
(16, 'announcement', 'Announcement List', 'Daftar Pengumuman', 24, 0, 1, 'fa fa-bullhorn', 1, 'add,edit,delete,view'),
(17, 'settings', 'System Settings', 'Pengaturan System', 4, 0, 1, 'fa fa-cogs', 1, NULL),
(18, 'meeting_type', 'Meeting Type', 'Tipe Rapat', 12, 0, 5, 'fa fa-list', 1, NULL),
(19, 'register_user', 'User Register', 'Pendaftaran Pengguna', 12, 0, 0, 'fa fa-users', 1, NULL),
(20, '#', 'Calculation', 'Perhitungan', 0, 1, 99, 'fa fa-tachometer', 1, NULL),
(21, 'topsis', 'Topsis', 'Topsis', 20, 0, 1, 'fa fa-tachometer', 1, NULL),
(23, 'schools', 'Data Schools', 'Data Sekolah', 12, 0, 3, 'fa fa-home', 1, 'add,view,edit'),
(24, '#', 'Announcement', 'Pengumuman', 0, 1, 8, 'fa fa-bullhorn', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kms_notification`
--

CREATE TABLE `kms_notification` (
  `notif_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `notif_subj` varchar(255) NOT NULL,
  `notif_msg` varchar(255) NOT NULL,
  `notif_url` varchar(255) DEFAULT NULL,
  `notif_status` tinyint(1) NOT NULL,
  `notif_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kms_notulensi`
--

CREATE TABLE `kms_notulensi` (
  `notulensi_id` bigint(20) NOT NULL,
  `school_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `meetType_id` int(11) DEFAULT NULL,
  `notulensi_code` varchar(255) NOT NULL,
  `notulensi_agenda` varchar(255) NOT NULL,
  `notulensi_place` varchar(255) NOT NULL,
  `notulensi_leader` varchar(255) NOT NULL,
  `notulensi_date` date NOT NULL,
  `notulensi_start` time NOT NULL,
  `notulensi_end` time NOT NULL,
  `notulensi_content` text NOT NULL,
  `notulensi_status` int(11) NOT NULL,
  `notulensi_created_date` datetime NOT NULL,
  `notulensi_last_update` datetime DEFAULT NULL,
  `notulensi_last_update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kms_notulensi_attachment`
--

CREATE TABLE `kms_notulensi_attachment` (
  `na_id` bigint(20) NOT NULL,
  `notulensi_id` bigint(20) DEFAULT NULL,
  `na_name` varchar(255) NOT NULL,
  `na_dir` varchar(255) NOT NULL,
  `na_created_date` datetime NOT NULL,
  `na_last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kms_schools`
--

CREATE TABLE `kms_schools` (
  `school_id` bigint(20) NOT NULL,
  `school_name` longtext NOT NULL,
  `school_nsm` longtext NOT NULL,
  `school_phone` longtext DEFAULT NULL,
  `school_type` varchar(10) NOT NULL,
  `school_address` longtext DEFAULT NULL,
  `school_status` int(11) NOT NULL,
  `school_created_date` datetime NOT NULL,
  `school_created_by` int(11) NOT NULL,
  `school_last_update` datetime DEFAULT NULL,
  `school_last_update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kms_schools`
--

INSERT INTO `kms_schools` (`school_id`, `school_name`, `school_nsm`, `school_phone`, `school_type`, `school_address`, `school_status`, `school_created_date`, `school_created_by`, `school_last_update`, `school_last_update_by`) VALUES
(1, 'Madrasah Aliyah Negeri 4 Jakarta', '131131740001', '324234234', 'NEGERI', '131131740001', 1, '0000-00-00 00:00:00', 0, NULL, NULL),
(2, 'Madrasah Aliyah Manaratul Islam', '131231740004', '324234', 'SWASTA', '131231740004', 1, '0000-00-00 00:00:00', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kms_sessions`
--

CREATE TABLE `kms_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(11) NOT NULL DEFAULT 0,
  `data` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kms_subject`
--

CREATE TABLE `kms_subject` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `subject_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kms_subject`
--

INSERT INTO `kms_subject` (`subject_id`, `subject_code`, `subject_name`) VALUES
(2, 'bhs001', 'Bahasa Indonesia'),
(3, 'bhs002', 'Bahasa Inggris'),
(4, 'mtk001', 'Matematika'),
(5, 'bhsjp001', 'Bahasa Jepang');

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
(1, 'KMS MAN x JAKARTA', 'KMS MAN x JAKARTA', 'KMS MAN x JAKARTA', 2020, 'Maintenance', 'smtp.gmail.com', 'helmyfikrih@gmail.com', 'xayitsJi9b/1', 'ssl', '465', 'helmyfikrih@gmail.com', 'KMSchool.com', 'logo.png', 'icon.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE `m_user` (
  `user_id` bigint(20) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `school_id` bigint(20) DEFAULT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_ip` varchar(255) DEFAULT NULL,
  `user_browser` varchar(255) DEFAULT NULL,
  `user_created_date` datetime DEFAULT NULL,
  `user_created_by` int(11) DEFAULT NULL,
  `user_last_update` datetime DEFAULT NULL,
  `user_last_update_by` int(11) DEFAULT NULL,
  `user_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`user_id`, `role_id`, `school_id`, `user_username`, `user_email`, `user_password`, `user_ip`, `user_browser`, `user_created_date`, `user_created_by`, `user_last_update`, `user_last_update_by`, `user_status`) VALUES
(1, 1, NULL, 'admin', 'helmyfikrih@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '::1', 'Chrome 87.0.4280.88', NULL, NULL, '2020-12-21 18:37:53', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE `user_detail` (
  `ud_id` bigint(20) NOT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `user_f_name` varchar(255) DEFAULT NULL,
  `ud_gender` varchar(2) DEFAULT NULL,
  `ud_nik` varchar(255) DEFAULT NULL,
  `ud_address` text DEFAULT NULL,
  `ud_birth_place` varchar(255) DEFAULT NULL,
  `ud_birth_date` date DEFAULT NULL,
  `ud_phone` varchar(255) DEFAULT NULL,
  `ud_img_name` varchar(255) DEFAULT NULL,
  `ud_img_dir` varchar(255) DEFAULT NULL,
  `ud_last_update` datetime DEFAULT NULL,
  `ud_last_update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `m_user_forgot_password`
--

CREATE TABLE `m_user_forgot_password` (
  `forgot_password_id` bigint(20) NOT NULL,
  `forgot_password_token` varchar(255) NOT NULL,
  `forgot_password_email` varchar(255) NOT NULL,
  `forgot_password_date` datetime NOT NULL,
  `forgot_password_status` int(11) NOT NULL,
  `forgot_password_last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `m_user_register`
--

CREATE TABLE `m_user_register` (
  `register_id` bigint(20) NOT NULL,
  `register_full_name` varchar(255) NOT NULL,
  `register_school_id` int(11) NOT NULL,
  `register_role` int(11) DEFAULT NULL,
  `register_subject_id` int(11) DEFAULT NULL,
  `register_email` varchar(255) NOT NULL,
  `register_nip` varchar(255) NOT NULL,
  `register_username` varchar(255) NOT NULL,
  `register_password` varchar(255) NOT NULL,
  `register_date` datetime NOT NULL,
  `register_uniq_code` varchar(255) NOT NULL,
  `register_agreement` tinyint(1) NOT NULL,
  `last_date_resend_verify` datetime DEFAULT NULL,
  `register_status` int(11) DEFAULT NULL,
  `email_verify_status` int(11) DEFAULT NULL,
  `email_verify_date` datetime DEFAULT NULL,
  `mandatory_approve` int(11) DEFAULT NULL,
  `approve_status` int(11) DEFAULT NULL,
  `approve_date` datetime DEFAULT NULL,
  `approve_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `m_role`
--

CREATE TABLE `m_role` (
  `role_id` int(11) NOT NULL,
  `role_code` varchar(255) DEFAULT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_allow_menu` text NOT NULL,
  `role_status` int(11) NOT NULL,
  `role_created_date` datetime NOT NULL,
  `role_created_by` int(11) NOT NULL,
  `role_last_update` datetime DEFAULT NULL,
  `role_last_update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_role`
--

INSERT INTO `m_role` (`role_id`, `role_code`, `role_name`, `role_allow_menu`, `role_status`, `role_created_date`, `role_created_by`, `role_last_update`, `role_last_update_by`) VALUES
(1, 'adm', 'Admin', '1,2,11,level_11_add,level_11_edit,level_11_delete,level_11_validasi,level_11_view,6,9,level_9_upload,level_9_add,level_9_validasi,level_9_edit,level_9_delete,level_9_view,7,10,level_10_add,level_10_comment,level_10_edit,level_10_delete,level_10_close,level_10_open,24,16,level_16_add,level_16_edit,level_16_delete,level_16_view,20,21,4,5,12,19,3,level_3_add,level_3_delete,level_3_view,level_3_edit,14,8,13,23,level_23_add,level_23_view,level_23_edit,15,18,17', 1, '2020-05-28 21:42:11', 1, NULL, NULL),
(2, 'guru', 'Guru', '1,2,11,level_11_add,level_11_edit,level_11_view,6,9,level_9_upload,level_9_add,level_9_edit,level_9_view,7,10,level_10_add,level_10_comment,level_10_edit,24,16,level_16_view,4,5,12,3,level_3_view', 1, '2020-05-28 21:23:09', 1, NULL, NULL),
(3, 'op', 'Operator', '1,2,11,level_11_add,level_11_edit,level_11_validasi,level_11_view,6,9,level_9_upload,level_9_add,level_9_validasi,level_9_edit,7,10,level_10_add,level_10_comment,level_10_close,level_10_open,24,16,level_16_add,level_16_edit,level_16_view,4,5,12,19,3,level_3_view', 1, '2020-05-28 21:23:15', 1, NULL, NULL),
(4, 'mrd', 'Murid', '1,2,11,level_11_view,6,9,level_9_view,7,10,level_10_add,level_10_comment,level_10_edit,24,16,level_16_view,4,5', 1, '2020-05-28 21:23:23', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `topsis_alternatif`
--

CREATE TABLE `topsis_alternatif` (
  `topsis_alternatif_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `topsis_alternatif_kriteria`
--

CREATE TABLE `topsis_alternatif_kriteria` (
  `topsis_alt_kirt_id` bigint(20) NOT NULL,
  `topsis_kriteria_id` int(11) DEFAULT NULL,
  `topsis_alternatif_id` bigint(20) DEFAULT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `topsis_hasil`
--

CREATE TABLE `topsis_hasil` (
  `topsis_hasil_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `ranking` int(11) NOT NULL,
  `hasil` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `topsis_kriteria`
--

CREATE TABLE `topsis_kriteria` (
  `topsis_kriteria_id` int(11) NOT NULL,
  `nama_kriteria` varchar(255) NOT NULL,
  `kepentingan` float NOT NULL,
  `costBenefit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kms_announcement`
--
ALTER TABLE `kms_announcement`
  ADD PRIMARY KEY (`announ_id`),
  ADD KEY `FK_KMS_ANNO_REL_KMS_SCHOOOL` (`school_id`);

--
-- Indexes for table `kms_announcement_attachment`
--
ALTER TABLE `kms_announcement_attachment`
  ADD PRIMARY KEY (`aa_id`),
  ADD KEY `FK_KMS_KAA_REL_KMS_ANOUN` (`announ_id`);

--
-- Indexes for table `kms_designation`
--
ALTER TABLE `kms_designation`
  ADD PRIMARY KEY (`designation_id`);

--
-- Indexes for table `kms_document`
--
ALTER TABLE `kms_document`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `FK_KMS_DOC_REL_KMS_SUBJ` (`subject_id`),
  ADD KEY `FK_KMS_DOC_REL_KMS_SCHOOL` (`school_id`),
  ADD KEY `FK_KMS_DOC_REL_m_user` (`user_id`),
  ADD KEY `FK_KMS_DOC_REL_KMS_DOC_TYPE` (`doctype_id`);

--
-- Indexes for table `kms_document_attachment`
--
ALTER TABLE `kms_document_attachment`
  ADD PRIMARY KEY (`da_id`),
  ADD KEY `FK_KMS_DOC_ATT_REL_KMS_DOC` (`document_id`),
  ADD KEY `FK_KMS_DOC_ATT_REL_m_user` (`user_id`);

--
-- Indexes for table `kms_document_type`
--
ALTER TABLE `kms_document_type`
  ADD PRIMARY KEY (`doctype_id`);

--
-- Indexes for table `kms_forum`
--
ALTER TABLE `kms_forum`
  ADD PRIMARY KEY (`forum_id`),
  ADD KEY `FK_KMS_FORUM_REL_m_user` (`user_id`);

--
-- Indexes for table `kms_forum_comment`
--
ALTER TABLE `kms_forum_comment`
  ADD PRIMARY KEY (`fc_id`),
  ADD KEY `FK_KMS_FORUM_CMNT_REL_KMS_FORUM` (`forum_id`),
  ADD KEY `FK_KMS_FORUM_CMNT_REL_m_user` (`user_id`);

--
-- Indexes for table `kms_log_search`
--
ALTER TABLE `kms_log_search`
  ADD PRIMARY KEY (`ls_id`),
  ADD KEY `FK_KMS_LOGS__REL_m_user` (`user_id`);

--
-- Indexes for table `kms_meeting_type`
--
ALTER TABLE `kms_meeting_type`
  ADD PRIMARY KEY (`meetType_id`);

--
-- Indexes for table `m_menu`
--
ALTER TABLE `m_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `kms_notification`
--
ALTER TABLE `kms_notification`
  ADD PRIMARY KEY (`notif_id`),
  ADD KEY `FK_KMS_NOTIF_REL_m_user` (`user_id`);

--
-- Indexes for table `kms_notulensi`
--
ALTER TABLE `kms_notulensi`
  ADD PRIMARY KEY (`notulensi_id`),
  ADD KEY `FK_KMS_NOTE_REL_m_user` (`user_id`),
  ADD KEY `FK_KMS_NOTE_REL_KMS_SCHOOL` (`school_id`),
  ADD KEY `FK_KMS_NOTE_REL_KMS_MEET_TYPE` (`meetType_id`);

--
-- Indexes for table `kms_notulensi_attachment`
--
ALTER TABLE `kms_notulensi_attachment`
  ADD PRIMARY KEY (`na_id`),
  ADD KEY `FK_KMS_NOTE_ATT_REL_KMS_NOTE` (`notulensi_id`);

--
-- Indexes for table `kms_schools`
--
ALTER TABLE `kms_schools`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `kms_sessions`
--
ALTER TABLE `kms_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kms_subject`
--
ALTER TABLE `kms_subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `kms_system_settings`
--
ALTER TABLE `kms_system_settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `FK_m_user_REL_KMS_SCHOOL` (`school_id`),
  ADD KEY `FK_m_user_REL_m_role` (`role_id`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD PRIMARY KEY (`ud_id`),
  ADD KEY `FK_m_userD_REL_m_user` (`user_id`),
  ADD KEY `FK_m_userD_REL_KMS_SUBJ` (`subject_id`),
  ADD KEY `FK_m_userD_REL_KMS_DESIGNATION` (`designation_id`);

--
-- Indexes for table `m_user_forgot_password`
--
ALTER TABLE `m_user_forgot_password`
  ADD PRIMARY KEY (`forgot_password_id`);

--
-- Indexes for table `m_user_register`
--
ALTER TABLE `m_user_register`
  ADD PRIMARY KEY (`register_id`);

--
-- Indexes for table `m_role`
--
ALTER TABLE `m_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `topsis_alternatif`
--
ALTER TABLE `topsis_alternatif`
  ADD PRIMARY KEY (`topsis_alternatif_id`),
  ADD KEY `FK_TOPSIS_ALT_REL_m_user` (`user_id`);

--
-- Indexes for table `topsis_alternatif_kriteria`
--
ALTER TABLE `topsis_alternatif_kriteria`
  ADD PRIMARY KEY (`topsis_alt_kirt_id`),
  ADD KEY `FK_TOPSIS_ALTKRIT_REL_TOPSIS_ALT` (`topsis_alternatif_id`),
  ADD KEY `FK_TOPSIS_ALTKRIT_REL_TOPSIS_KRIT` (`topsis_kriteria_id`);

--
-- Indexes for table `topsis_hasil`
--
ALTER TABLE `topsis_hasil`
  ADD PRIMARY KEY (`topsis_hasil_id`),
  ADD KEY `FK_TOPSIS_HASIL_REL_m_user` (`user_id`);

--
-- Indexes for table `topsis_kriteria`
--
ALTER TABLE `topsis_kriteria`
  ADD PRIMARY KEY (`topsis_kriteria_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kms_announcement`
--
ALTER TABLE `kms_announcement`
  MODIFY `announ_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kms_announcement_attachment`
--
ALTER TABLE `kms_announcement_attachment`
  MODIFY `aa_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kms_designation`
--
ALTER TABLE `kms_designation`
  MODIFY `designation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kms_document`
--
ALTER TABLE `kms_document`
  MODIFY `document_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kms_document_attachment`
--
ALTER TABLE `kms_document_attachment`
  MODIFY `da_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kms_document_type`
--
ALTER TABLE `kms_document_type`
  MODIFY `doctype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kms_forum`
--
ALTER TABLE `kms_forum`
  MODIFY `forum_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kms_forum_comment`
--
ALTER TABLE `kms_forum_comment`
  MODIFY `fc_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kms_log_search`
--
ALTER TABLE `kms_log_search`
  MODIFY `ls_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kms_meeting_type`
--
ALTER TABLE `kms_meeting_type`
  MODIFY `meetType_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_menu`
--
ALTER TABLE `m_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `kms_notification`
--
ALTER TABLE `kms_notification`
  MODIFY `notif_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kms_notulensi`
--
ALTER TABLE `kms_notulensi`
  MODIFY `notulensi_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kms_notulensi_attachment`
--
ALTER TABLE `kms_notulensi_attachment`
  MODIFY `na_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kms_schools`
--
ALTER TABLE `kms_schools`
  MODIFY `school_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kms_subject`
--
ALTER TABLE `kms_subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kms_system_settings`
--
ALTER TABLE `kms_system_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_user`
--
ALTER TABLE `m_user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_detail`
--
ALTER TABLE `user_detail`
  MODIFY `ud_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_user_forgot_password`
--
ALTER TABLE `m_user_forgot_password`
  MODIFY `forgot_password_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_user_register`
--
ALTER TABLE `m_user_register`
  MODIFY `register_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_role`
--
ALTER TABLE `m_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `topsis_alternatif`
--
ALTER TABLE `topsis_alternatif`
  MODIFY `topsis_alternatif_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topsis_alternatif_kriteria`
--
ALTER TABLE `topsis_alternatif_kriteria`
  MODIFY `topsis_alt_kirt_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topsis_hasil`
--
ALTER TABLE `topsis_hasil`
  MODIFY `topsis_hasil_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topsis_kriteria`
--
ALTER TABLE `topsis_kriteria`
  MODIFY `topsis_kriteria_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kms_announcement`
--
ALTER TABLE `kms_announcement`
  ADD CONSTRAINT `FK_KMS_ANNO_REL_KMS_SCHOOOL` FOREIGN KEY (`school_id`) REFERENCES `kms_schools` (`school_id`);

--
-- Constraints for table `kms_announcement_attachment`
--
ALTER TABLE `kms_announcement_attachment`
  ADD CONSTRAINT `FK_KMS_KAA_REL_KMS_ANOUN` FOREIGN KEY (`announ_id`) REFERENCES `kms_announcement` (`announ_id`);

--
-- Constraints for table `kms_document`
--
ALTER TABLE `kms_document`
  ADD CONSTRAINT `FK_KMS_DOC_REL_KMS_DOC_TYPE` FOREIGN KEY (`doctype_id`) REFERENCES `kms_document_type` (`doctype_id`),
  ADD CONSTRAINT `FK_KMS_DOC_REL_KMS_SCHOOL` FOREIGN KEY (`school_id`) REFERENCES `kms_schools` (`school_id`),
  ADD CONSTRAINT `FK_KMS_DOC_REL_KMS_SUBJ` FOREIGN KEY (`subject_id`) REFERENCES `kms_subject` (`subject_id`),
  ADD CONSTRAINT `FK_KMS_DOC_REL_m_user` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);

--
-- Constraints for table `kms_document_attachment`
--
ALTER TABLE `kms_document_attachment`
  ADD CONSTRAINT `FK_KMS_DOC_ATT_REL_KMS_DOC` FOREIGN KEY (`document_id`) REFERENCES `kms_document` (`document_id`),
  ADD CONSTRAINT `FK_KMS_DOC_ATT_REL_m_user` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);

--
-- Constraints for table `kms_forum`
--
ALTER TABLE `kms_forum`
  ADD CONSTRAINT `FK_KMS_FORUM_REL_m_user` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);

--
-- Constraints for table `kms_forum_comment`
--
ALTER TABLE `kms_forum_comment`
  ADD CONSTRAINT `FK_KMS_FORUM_CMNT_REL_KMS_FORUM` FOREIGN KEY (`forum_id`) REFERENCES `kms_forum` (`forum_id`),
  ADD CONSTRAINT `FK_KMS_FORUM_CMNT_REL_m_user` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);

--
-- Constraints for table `kms_log_search`
--
ALTER TABLE `kms_log_search`
  ADD CONSTRAINT `FK_KMS_LOGS__REL_m_user` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);

--
-- Constraints for table `kms_notification`
--
ALTER TABLE `kms_notification`
  ADD CONSTRAINT `FK_KMS_NOTIF_REL_m_user` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);

--
-- Constraints for table `kms_notulensi`
--
ALTER TABLE `kms_notulensi`
  ADD CONSTRAINT `FK_KMS_NOTE_REL_KMS_MEET_TYPE` FOREIGN KEY (`meetType_id`) REFERENCES `kms_meeting_type` (`meetType_id`),
  ADD CONSTRAINT `FK_KMS_NOTE_REL_KMS_SCHOOL` FOREIGN KEY (`school_id`) REFERENCES `kms_schools` (`school_id`),
  ADD CONSTRAINT `FK_KMS_NOTE_REL_m_user` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);

--
-- Constraints for table `kms_notulensi_attachment`
--
ALTER TABLE `kms_notulensi_attachment`
  ADD CONSTRAINT `FK_KMS_NOTE_ATT_REL_KMS_NOTE` FOREIGN KEY (`notulensi_id`) REFERENCES `kms_notulensi` (`notulensi_id`);

--
-- Constraints for table `m_user`
--
ALTER TABLE `m_user`
  ADD CONSTRAINT `FK_m_user_REL_KMS_SCHOOL` FOREIGN KEY (`school_id`) REFERENCES `kms_schools` (`school_id`),
  ADD CONSTRAINT `FK_m_user_REL_m_role` FOREIGN KEY (`role_id`) REFERENCES `m_role` (`role_id`);

--
-- Constraints for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD CONSTRAINT `FK_m_userD_REL_KMS_DESIGNATION` FOREIGN KEY (`designation_id`) REFERENCES `kms_designation` (`designation_id`),
  ADD CONSTRAINT `FK_m_userD_REL_KMS_SUBJ` FOREIGN KEY (`subject_id`) REFERENCES `kms_subject` (`subject_id`),
  ADD CONSTRAINT `FK_m_userD_REL_m_user` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);

--
-- Constraints for table `topsis_alternatif`
--
ALTER TABLE `topsis_alternatif`
  ADD CONSTRAINT `FK_TOPSIS_ALT_REL_m_user` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);

--
-- Constraints for table `topsis_alternatif_kriteria`
--
ALTER TABLE `topsis_alternatif_kriteria`
  ADD CONSTRAINT `FK_TOPSIS_ALTKRIT_REL_TOPSIS_ALT` FOREIGN KEY (`topsis_alternatif_id`) REFERENCES `topsis_alternatif` (`topsis_alternatif_id`),
  ADD CONSTRAINT `FK_TOPSIS_ALTKRIT_REL_TOPSIS_KRIT` FOREIGN KEY (`topsis_kriteria_id`) REFERENCES `topsis_kriteria` (`topsis_kriteria_id`);

--
-- Constraints for table `topsis_hasil`
--
ALTER TABLE `topsis_hasil`
  ADD CONSTRAINT `FK_TOPSIS_HASIL_REL_m_user` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
