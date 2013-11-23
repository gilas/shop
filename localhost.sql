-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2013 at 03:46 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shop`
--
DROP DATABASE `shop`;
CREATE DATABASE `shop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `shop`;

-- --------------------------------------------------------

--
-- Table structure for table `gl_acos`
--

CREATE TABLE IF NOT EXISTS `gl_acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=659 ;

--
-- Dumping data for table `gl_acos`
--

INSERT INTO `gl_acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 894),
(2, 1, NULL, NULL, 'Comments', 2, 33),
(3, 2, NULL, NULL, 'admin_index', 3, 4),
(5, 2, NULL, NULL, 'admin_view', 7, 8),
(6, 2, NULL, NULL, 'admin_publish_comment', 9, 10),
(7, 2, NULL, NULL, 'admin_unpublish_comment', 11, 12),
(8, 2, NULL, NULL, 'admin_delete', 13, 14),
(9, 2, NULL, NULL, 'admin_replyComment', 15, 16),
(10, 2, NULL, NULL, 'admin_editComment', 17, 18),
(523, 120, NULL, NULL, 'dispatch', 483, 484),
(12, 1, NULL, NULL, 'ContactDetails', 34, 61),
(13, 12, NULL, NULL, 'admin_add', 35, 36),
(14, 12, NULL, NULL, 'admin_edit', 37, 38),
(15, 12, NULL, NULL, 'admin_delete', 39, 40),
(16, 12, NULL, NULL, 'admin_index', 41, 42),
(17, 12, NULL, NULL, 'admin_getLinkItem', 43, 44),
(522, 120, NULL, NULL, 'admin_dispatch', 481, 482),
(20, 1, NULL, NULL, 'ContentCategories', 62, 89),
(21, 20, NULL, NULL, 'admin_add', 63, 64),
(22, 20, NULL, NULL, 'admin_index', 65, 66),
(23, 20, NULL, NULL, 'admin_delete', 67, 68),
(24, 20, NULL, NULL, 'admin_edit', 69, 70),
(25, 20, NULL, NULL, 'admin_publish', 71, 72),
(26, 20, NULL, NULL, 'admin_unPublish', 73, 74),
(27, 20, NULL, NULL, 'admin_getLinkItem', 75, 76),
(29, 1, NULL, NULL, 'Contents', 90, 157),
(30, 29, NULL, NULL, 'admin_index', 91, 92),
(31, 29, NULL, NULL, 'admin_add', 93, 94),
(32, 29, NULL, NULL, 'admin_delete', 95, 96),
(33, 29, NULL, NULL, 'admin_edit', 97, 98),
(34, 29, NULL, NULL, 'admin_move', 99, 100),
(35, 29, NULL, NULL, 'admin_publish', 101, 102),
(36, 29, NULL, NULL, 'admin_unPublish', 103, 104),
(37, 29, NULL, NULL, 'admin_addToFrontPage', 105, 106),
(38, 29, NULL, NULL, 'admin_removeFromFrontPage', 107, 108),
(39, 29, NULL, NULL, 'admin_allowComment', 109, 110),
(40, 29, NULL, NULL, 'admin_disallowComment', 111, 112),
(41, 29, NULL, NULL, 'admin_getLinkItem', 113, 114),
(520, 113, NULL, NULL, 'admin_settings', 451, 452),
(49, 1, NULL, NULL, 'Dashboards', 158, 171),
(50, 49, NULL, NULL, 'admin_index', 159, 160),
(514, 108, NULL, NULL, 'admin_dispatch', 419, 420),
(52, 1, NULL, NULL, 'GalleryCategories', 172, 203),
(53, 52, NULL, NULL, 'admin_index', 173, 174),
(54, 52, NULL, NULL, 'admin_add', 175, 176),
(55, 52, NULL, NULL, 'admin_edit', 177, 178),
(56, 52, NULL, NULL, 'admin_delete', 179, 180),
(57, 52, NULL, NULL, 'admin_publish', 181, 182),
(58, 52, NULL, NULL, 'admin_unPublish', 183, 184),
(59, 52, NULL, NULL, 'admin_getLinkItem', 185, 186),
(511, 323, NULL, NULL, 'admin_dispatch', 595, 596),
(62, 1, NULL, NULL, 'GalleryItems', 204, 241),
(63, 62, NULL, NULL, 'admin_index', 205, 206),
(64, 62, NULL, NULL, 'admin_add', 207, 208),
(65, 62, NULL, NULL, 'admin_edit', 209, 210),
(66, 62, NULL, NULL, 'admin_delete', 211, 212),
(67, 62, NULL, NULL, 'admin_unPublish', 213, 214),
(68, 62, NULL, NULL, 'admin_publish', 215, 216),
(71, 62, NULL, NULL, 'admin_move', 221, 222),
(72, 62, NULL, NULL, 'admin_getLinkItem', 223, 224),
(74, 1, NULL, NULL, 'MenuTypes', 242, 261),
(75, 74, NULL, NULL, 'admin_index', 243, 244),
(76, 74, NULL, NULL, 'admin_add', 245, 246),
(77, 74, NULL, NULL, 'admin_edit', 247, 248),
(78, 74, NULL, NULL, 'admin_getTypes', 249, 250),
(79, 74, NULL, NULL, 'admin_delete', 251, 252),
(507, 98, NULL, NULL, 'dispatch', 377, 378),
(81, 1, NULL, NULL, 'Menus', 262, 297),
(82, 81, NULL, NULL, 'admin_index', 263, 264),
(83, 81, NULL, NULL, 'admin_add', 265, 266),
(84, 81, NULL, NULL, 'admin_edit', 267, 268),
(85, 81, NULL, NULL, 'admin_delete', 269, 270),
(86, 81, NULL, NULL, 'admin_move', 271, 272),
(87, 81, NULL, NULL, 'admin_publish', 273, 274),
(88, 81, NULL, NULL, 'admin_unPublish', 275, 276),
(91, 1, NULL, NULL, 'Pages', 298, 321),
(503, 94, NULL, NULL, 'dispatch', 341, 342),
(94, 1, NULL, NULL, 'Settings', 322, 347),
(95, 94, NULL, NULL, 'admin_index', 323, 324),
(463, 344, NULL, NULL, 'admin_dispatch', 615, 616),
(98, 1, NULL, NULL, 'SliderItems', 348, 383),
(99, 98, NULL, NULL, 'admin_index', 349, 350),
(100, 98, NULL, NULL, 'admin_add', 351, 352),
(101, 98, NULL, NULL, 'admin_edit', 353, 354),
(102, 98, NULL, NULL, 'admin_delete', 355, 356),
(103, 98, NULL, NULL, 'admin_move', 357, 358),
(104, 98, NULL, NULL, 'admin_publish', 359, 360),
(105, 98, NULL, NULL, 'admin_unPublish', 361, 362),
(461, 29, NULL, NULL, 'admin_settings', 153, 154),
(108, 1, NULL, NULL, 'Users', 384, 427),
(109, 108, NULL, NULL, 'admin_login', 385, 386),
(110, 108, NULL, NULL, 'admin_logout', 387, 388),
(455, 20, NULL, NULL, 'admin_dispatch', 81, 82),
(113, 1, NULL, NULL, 'WeblinkCategories', 428, 455),
(114, 113, NULL, NULL, 'admin_index', 429, 430),
(115, 113, NULL, NULL, 'admin_add', 431, 432),
(116, 113, NULL, NULL, 'admin_edit', 433, 434),
(117, 113, NULL, NULL, 'admin_delete', 435, 436),
(118, 113, NULL, NULL, 'admin_getLinkItem', 437, 438),
(453, 12, NULL, NULL, 'admin_settings', 57, 58),
(120, 1, NULL, NULL, 'Weblinks', 456, 489),
(121, 120, NULL, NULL, 'admin_index', 457, 458),
(122, 120, NULL, NULL, 'admin_add', 459, 460),
(123, 120, NULL, NULL, 'admin_edit', 461, 462),
(124, 120, NULL, NULL, 'admin_delete', 463, 464),
(125, 120, NULL, NULL, 'admin_publish', 465, 466),
(126, 120, NULL, NULL, 'admin_unPublish', 467, 468),
(451, 12, NULL, NULL, 'admin_dispatch', 53, 54),
(135, 1, NULL, NULL, 'TinyMCE', 490, 491),
(136, 1, NULL, NULL, 'UploadPack', 492, 493),
(137, 1, NULL, NULL, 'AclPermissions', 494, 509),
(138, 137, NULL, NULL, 'admin_index', 495, 496),
(139, 137, NULL, NULL, 'admin_editPermission', 497, 498),
(140, 137, NULL, NULL, 'admin_sync', 499, 500),
(347, 344, NULL, NULL, 'agent_index', 607, 608),
(473, 62, NULL, NULL, 'admin_dispatch', 233, 234),
(165, 1, NULL, NULL, 'DebugKit', 510, 525),
(166, 165, NULL, NULL, 'ToolbarAccess', 511, 524),
(167, 166, NULL, NULL, 'history_state', 512, 513),
(168, 166, NULL, NULL, 'sql_explain', 514, 515),
(356, 353, NULL, NULL, 'admin_reverse', 627, 628),
(355, 353, NULL, NULL, 'admin_changeStatus', 625, 626),
(354, 353, NULL, NULL, 'admin_index', 623, 624),
(353, 1, NULL, NULL, 'Payments', 622, 645),
(515, 108, NULL, NULL, 'dispatch', 421, 422),
(516, 108, NULL, NULL, 'admin_settings', 423, 424),
(474, 62, NULL, NULL, 'dispatch', 235, 236),
(475, 62, NULL, NULL, 'admin_settings', 237, 238),
(477, 74, NULL, NULL, 'admin_dispatch', 255, 256),
(478, 74, NULL, NULL, 'dispatch', 257, 258),
(479, 74, NULL, NULL, 'admin_settings', 259, 260),
(480, 81, NULL, NULL, 'admin_dispatch', 289, 290),
(481, 81, NULL, NULL, 'dispatch', 291, 292),
(482, 81, NULL, NULL, 'admin_settings', 293, 294),
(484, 91, NULL, NULL, 'admin_dispatch', 313, 314),
(485, 91, NULL, NULL, 'dispatch', 315, 316),
(486, 91, NULL, NULL, 'admin_settings', 317, 318),
(488, 353, NULL, NULL, 'admin_dispatch', 637, 638),
(489, 353, NULL, NULL, 'dispatch', 639, 640),
(490, 353, NULL, NULL, 'admin_settings', 641, 642),
(225, 215, NULL, NULL, 'countNewMessages', 557, 558),
(224, 215, NULL, NULL, 'admin_read', 555, 556),
(212, 1, NULL, NULL, 'Profile', 526, 547),
(213, 212, NULL, NULL, 'view', 527, 528),
(469, 52, NULL, NULL, 'admin_dispatch', 195, 196),
(215, 1, NULL, NULL, 'Pms', 548, 577),
(216, 215, NULL, NULL, 'admin_add', 549, 550),
(218, 215, NULL, NULL, 'admin_index', 551, 552),
(219, 215, NULL, NULL, 'admin_delete', 553, 554),
(471, 52, NULL, NULL, 'admin_settings', 199, 200),
(226, 108, NULL, NULL, 'admin_add', 395, 396),
(227, 108, NULL, NULL, 'admin_index', 397, 398),
(228, 108, NULL, NULL, 'admin_active', 399, 400),
(229, 108, NULL, NULL, 'admin_inactive', 401, 402),
(230, 108, NULL, NULL, 'admin_edit', 403, 404),
(231, 108, NULL, NULL, 'admin_delete', 405, 406),
(232, 108, NULL, NULL, 'login', 407, 408),
(233, 108, NULL, NULL, 'logout', 409, 410),
(447, 2, NULL, NULL, 'admin_dispatch', 25, 26),
(448, 2, NULL, NULL, 'dispatch', 27, 28),
(449, 2, NULL, NULL, 'admin_settings', 29, 30),
(349, 344, NULL, NULL, 'userDashboard', 611, 612),
(348, 344, NULL, NULL, 'admin_insurance', 609, 610),
(460, 29, NULL, NULL, 'dispatch', 151, 152),
(468, 49, NULL, NULL, 'admin_settings', 169, 170),
(493, 215, NULL, NULL, 'dispatch', 573, 574),
(494, 215, NULL, NULL, 'admin_settings', 575, 576),
(495, 212, NULL, NULL, 'admin_dispatch', 539, 540),
(496, 212, NULL, NULL, 'dispatch', 541, 542),
(497, 212, NULL, NULL, 'admin_settings', 543, 544),
(499, 360, NULL, NULL, 'admin_dispatch', 659, 660),
(500, 360, NULL, NULL, 'dispatch', 661, 662),
(501, 360, NULL, NULL, 'admin_settings', 663, 664),
(502, 94, NULL, NULL, 'admin_dispatch', 339, 340),
(284, 29, NULL, NULL, 'listArticles', 141, 142),
(346, 344, NULL, NULL, 'admin_index', 605, 606),
(345, 344, NULL, NULL, 'index', 603, 604),
(344, 1, NULL, NULL, 'Dashboard', 602, 621),
(289, 215, NULL, NULL, 'index', 559, 560),
(290, 215, NULL, NULL, 'add', 561, 562),
(291, 215, NULL, NULL, 'read', 563, 564),
(292, 215, NULL, NULL, 'delete', 565, 566),
(524, 120, NULL, NULL, 'admin_settings', 485, 486),
(518, 113, NULL, NULL, 'admin_dispatch', 447, 448),
(519, 113, NULL, NULL, 'dispatch', 449, 450),
(512, 323, NULL, NULL, 'dispatch', 597, 598),
(510, 323, NULL, NULL, 'admin_settings', 593, 594),
(508, 98, NULL, NULL, 'admin_settings', 379, 380),
(506, 98, NULL, NULL, 'admin_dispatch', 375, 376),
(504, 94, NULL, NULL, 'admin_settings', 343, 344),
(492, 215, NULL, NULL, 'admin_dispatch', 571, 572),
(343, 49, NULL, NULL, 'profile', 161, 162),
(470, 52, NULL, NULL, 'dispatch', 197, 198),
(467, 49, NULL, NULL, 'dispatch', 167, 168),
(368, 29, NULL, NULL, 'admin_moveToCategory', 143, 144),
(459, 29, NULL, NULL, 'admin_dispatch', 149, 150),
(452, 12, NULL, NULL, 'dispatch', 55, 56),
(443, 1, NULL, NULL, 'Captcha', 670, 671),
(444, 137, NULL, NULL, 'admin_dispatch', 503, 504),
(445, 137, NULL, NULL, 'dispatch', 505, 506),
(446, 137, NULL, NULL, 'admin_settings', 507, 508),
(568, 567, NULL, NULL, 'Categories', 711, 732),
(323, 1, NULL, NULL, 'Smses', 578, 601),
(326, 323, NULL, NULL, 'receive', 579, 580),
(327, 323, NULL, NULL, 'admin_send', 581, 582),
(328, 323, NULL, NULL, 'admin_index', 583, 584),
(457, 20, NULL, NULL, 'admin_settings', 85, 86),
(456, 20, NULL, NULL, 'dispatch', 83, 84),
(569, 568, NULL, NULL, 'admin_index', 712, 713),
(570, 568, NULL, NULL, 'admin_add', 714, 715),
(528, 166, NULL, NULL, 'admin_settings', 522, 523),
(526, 166, NULL, NULL, 'admin_dispatch', 518, 519),
(527, 166, NULL, NULL, 'dispatch', 520, 521),
(340, 212, NULL, NULL, 'admin_view', 529, 530),
(341, 91, NULL, NULL, 'contact_us', 303, 304),
(342, 94, NULL, NULL, 'admin_clearCache', 329, 330),
(360, 1, NULL, NULL, 'Roles', 646, 665),
(361, 360, NULL, NULL, 'admin_index', 647, 648),
(362, 360, NULL, NULL, 'admin_add', 649, 650),
(363, 360, NULL, NULL, 'admin_edit', 651, 652),
(364, 360, NULL, NULL, 'admin_delete', 653, 654),
(466, 49, NULL, NULL, 'admin_dispatch', 165, 166),
(464, 344, NULL, NULL, 'dispatch', 617, 618),
(465, 344, NULL, NULL, 'admin_settings', 619, 620),
(571, 568, NULL, NULL, 'admin_edit', 716, 717),
(572, 568, NULL, NULL, 'admin_delete', 718, 719),
(573, 568, NULL, NULL, 'admin_dispatch', 720, 721),
(576, 568, NULL, NULL, 'admin_move', 726, 727),
(577, 568, NULL, NULL, 'admin_publish', 728, 729),
(578, 568, NULL, NULL, 'admin_unPublish', 730, 731),
(574, 568, NULL, NULL, 'dispatch', 722, 723),
(575, 568, NULL, NULL, 'admin_settings', 724, 725),
(567, 1, NULL, NULL, 'Shop', 710, 893),
(579, 567, NULL, NULL, 'Stuffs', 733, 752),
(580, 579, NULL, NULL, 'admin_index', 734, 735),
(581, 579, NULL, NULL, 'admin_add', 736, 737),
(582, 579, NULL, NULL, 'admin_edit', 738, 739),
(583, 579, NULL, NULL, 'admin_delete', 740, 741),
(584, 579, NULL, NULL, 'admin_publish', 742, 743),
(585, 579, NULL, NULL, 'admin_unPublish', 744, 745),
(586, 579, NULL, NULL, 'admin_dispatch', 746, 747),
(587, 579, NULL, NULL, 'dispatch', 748, 749),
(588, 579, NULL, NULL, 'admin_settings', 750, 751),
(589, 567, NULL, NULL, 'Orders', 753, 774),
(590, 589, NULL, NULL, 'admin_index', 754, 755),
(591, 589, NULL, NULL, 'admin_add', 756, 757),
(592, 589, NULL, NULL, 'admin_edit', 758, 759),
(593, 589, NULL, NULL, 'admin_delete', 760, 761),
(594, 589, NULL, NULL, 'admin_publish', 762, 763),
(595, 589, NULL, NULL, 'admin_unPublish', 764, 765),
(596, 589, NULL, NULL, 'admin_dispatch', 766, 767),
(597, 589, NULL, NULL, 'dispatch', 768, 769),
(598, 589, NULL, NULL, 'admin_settings', 770, 771),
(599, 567, NULL, NULL, 'User', 775, 784),
(600, 599, NULL, NULL, 'admin_index', 776, 777),
(601, 599, NULL, NULL, 'admin_dispatch', 778, 779),
(602, 599, NULL, NULL, 'dispatch', 780, 781),
(603, 599, NULL, NULL, 'admin_settings', 782, 783),
(604, 589, NULL, NULL, 'viewFactor', 772, 773),
(605, 567, NULL, NULL, 'Comments', 785, 806),
(606, 605, NULL, NULL, 'admin_index', 786, 787),
(607, 605, NULL, NULL, 'admin_view', 788, 789),
(608, 605, NULL, NULL, 'admin_publish_comment', 790, 791),
(609, 605, NULL, NULL, 'admin_unpublish_comment', 792, 793),
(610, 605, NULL, NULL, 'admin_delete', 794, 795),
(611, 605, NULL, NULL, 'admin_replyComment', 796, 797),
(612, 605, NULL, NULL, 'admin_editComment', 798, 799),
(613, 605, NULL, NULL, 'admin_dispatch', 800, 801),
(614, 605, NULL, NULL, 'dispatch', 802, 803),
(615, 605, NULL, NULL, 'admin_settings', 804, 805),
(616, 567, NULL, NULL, 'Coupons', 807, 824),
(617, 616, NULL, NULL, 'admin_index', 808, 809),
(618, 616, NULL, NULL, 'admin_add', 810, 811),
(619, 616, NULL, NULL, 'admin_edit', 812, 813),
(620, 616, NULL, NULL, 'admin_delete', 814, 815),
(621, 616, NULL, NULL, 'admin_view', 816, 817),
(622, 616, NULL, NULL, 'admin_dispatch', 818, 819),
(623, 616, NULL, NULL, 'dispatch', 820, 821),
(624, 616, NULL, NULL, 'admin_settings', 822, 823),
(625, 567, NULL, NULL, 'Deports', 825, 842),
(626, 625, NULL, NULL, 'admin_index', 826, 827),
(627, 625, NULL, NULL, 'admin_add', 828, 829),
(628, 625, NULL, NULL, 'admin_edit', 830, 831),
(629, 625, NULL, NULL, 'admin_delete', 832, 833),
(630, 625, NULL, NULL, 'admin_view', 834, 835),
(631, 625, NULL, NULL, 'admin_dispatch', 836, 837),
(632, 625, NULL, NULL, 'dispatch', 838, 839),
(633, 625, NULL, NULL, 'admin_settings', 840, 841),
(634, 567, NULL, NULL, 'Groups', 843, 860),
(635, 634, NULL, NULL, 'admin_index', 844, 845),
(636, 634, NULL, NULL, 'admin_add', 846, 847),
(637, 634, NULL, NULL, 'admin_edit', 848, 849),
(638, 634, NULL, NULL, 'admin_delete', 850, 851),
(639, 634, NULL, NULL, 'admin_view', 852, 853),
(640, 634, NULL, NULL, 'admin_dispatch', 854, 855),
(641, 634, NULL, NULL, 'dispatch', 856, 857),
(642, 634, NULL, NULL, 'admin_settings', 858, 859),
(643, 567, NULL, NULL, 'Payments', 861, 874),
(644, 643, NULL, NULL, 'admin_index', 862, 863),
(645, 643, NULL, NULL, 'admin_changeStatus', 864, 865),
(646, 643, NULL, NULL, 'admin_reverse', 866, 867),
(647, 643, NULL, NULL, 'admin_dispatch', 868, 869),
(648, 643, NULL, NULL, 'dispatch', 870, 871),
(649, 643, NULL, NULL, 'admin_settings', 872, 873),
(650, 567, NULL, NULL, 'Taxes', 875, 892),
(651, 650, NULL, NULL, 'admin_index', 876, 877),
(652, 650, NULL, NULL, 'admin_add', 878, 879),
(653, 650, NULL, NULL, 'admin_edit', 880, 881),
(654, 650, NULL, NULL, 'admin_delete', 882, 883),
(655, 650, NULL, NULL, 'admin_view', 884, 885),
(656, 650, NULL, NULL, 'admin_dispatch', 886, 887),
(657, 650, NULL, NULL, 'dispatch', 888, 889),
(658, 650, NULL, NULL, 'admin_settings', 890, 891);

-- --------------------------------------------------------

--
-- Table structure for table `gl_aros`
--

CREATE TABLE IF NOT EXISTS `gl_aros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `gl_aros`
--

INSERT INTO `gl_aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'Roles', 1, 12),
(2, 1, 'Role', 1, 'Admin', 2, 3),
(3, 1, 'Role', 2, 'Super Admin', 4, 5),
(4, 1, 'Role', 3, 'Register', 6, 7),
(8, 1, 'Role', 18, 'User', 10, 11);

-- --------------------------------------------------------

--
-- Table structure for table `gl_aros_acos`
--

CREATE TABLE IF NOT EXISTS `gl_aros_acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aro_id` int(11) DEFAULT NULL,
  `aco_id` int(11) DEFAULT NULL,
  `_create` varchar(2) COLLATE utf8_persian_ci DEFAULT NULL,
  `_read` varchar(2) COLLATE utf8_persian_ci DEFAULT NULL,
  `_update` varchar(2) COLLATE utf8_persian_ci DEFAULT NULL,
  `_delete` varchar(2) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aco_id` (`aco_id`),
  KEY `aro_id` (`aro_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=569 ;

--
-- Dumping data for table `gl_aros_acos`
--

INSERT INTO `gl_aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 2, 3, '1', '1', '1', '1'),
(2, 2, 50, '1', '1', '1', '1'),
(3, 2, 138, '-1', '-1', '-1', '-1'),
(4, 2, 78, '1', '1', '1', '1'),
(5, 2, 30, '1', '1', '1', '1'),
(6, 2, 110, '1', '1', '1', '1'),
(7, 2, 109, '1', '1', '1', '1'),
(8, 2, 140, '-1', '-1', '-1', '-1'),
(9, 2, 139, '-1', '-1', '-1', '-1'),
(363, 2, 514, '1', '1', '1', '1'),
(11, 2, 53, '1', '1', '1', '1'),
(12, 2, 54, '1', '1', '1', '1'),
(13, 2, 55, '1', '1', '1', '1'),
(14, 2, 14, '1', '1', '1', '1'),
(15, 2, 16, '1', '1', '1', '1'),
(361, 3, 514, '1', '1', '1', '1'),
(359, 3, 518, '1', '1', '1', '1'),
(357, 2, 518, '1', '1', '1', '1'),
(19, 2, 10, '1', '1', '1', '1'),
(20, 2, 9, '1', '1', '1', '1'),
(21, 2, 8, '1', '1', '1', '1'),
(22, 2, 5, '1', '1', '1', '1'),
(23, 2, 6, '1', '1', '1', '1'),
(24, 2, 7, '1', '1', '1', '1'),
(25, 2, 13, '1', '1', '1', '1'),
(26, 2, 17, '1', '1', '1', '1'),
(27, 2, 31, '1', '1', '1', '1'),
(28, 2, 32, '1', '1', '1', '1'),
(29, 2, 34, '1', '1', '1', '1'),
(30, 2, 35, '1', '1', '1', '1'),
(31, 2, 36, '1', '1', '1', '1'),
(32, 2, 37, '1', '1', '1', '1'),
(33, 2, 38, '1', '1', '1', '1'),
(34, 2, 39, '1', '1', '1', '1'),
(35, 2, 40, '1', '1', '1', '1'),
(36, 2, 41, '1', '1', '1', '1'),
(354, 3, 524, '1', '1', '1', '1'),
(38, 2, 15, '1', '1', '1', '1'),
(39, 2, 21, '1', '1', '1', '1'),
(40, 2, 22, '1', '1', '1', '1'),
(41, 2, 23, '1', '1', '1', '1'),
(42, 2, 24, '1', '1', '1', '1'),
(43, 2, 25, '1', '1', '1', '1'),
(44, 2, 26, '1', '1', '1', '1'),
(45, 2, 27, '1', '1', '1', '1'),
(46, 2, 33, '1', '1', '1', '1'),
(47, 2, 121, '1', '1', '1', '1'),
(48, 2, 122, '1', '1', '1', '1'),
(49, 2, 123, '1', '1', '1', '1'),
(50, 2, 124, '1', '1', '1', '1'),
(51, 2, 125, '1', '1', '1', '1'),
(52, 2, 126, '1', '1', '1', '1'),
(321, 3, 444, '1', '1', '1', '1'),
(54, 2, 114, '1', '1', '1', '1'),
(55, 2, 115, '1', '1', '1', '1'),
(56, 2, 116, '1', '1', '1', '1'),
(57, 2, 117, '1', '1', '1', '1'),
(58, 2, 118, '1', '1', '1', '1'),
(323, 2, 506, '1', '1', '1', '1'),
(61, 2, 99, '1', '1', '1', '1'),
(62, 2, 100, '1', '1', '1', '1'),
(63, 2, 101, '1', '1', '1', '1'),
(64, 2, 102, '1', '1', '1', '1'),
(65, 2, 103, '1', '1', '1', '1'),
(66, 2, 104, '1', '1', '1', '1'),
(67, 2, 105, '1', '1', '1', '1'),
(329, 3, 368, '1', '1', '1', '1'),
(69, 2, 95, '1', '1', '1', '1'),
(331, 2, 469, '1', '1', '1', '1'),
(71, 2, 82, '1', '1', '1', '1'),
(72, 2, 83, '1', '1', '1', '1'),
(73, 2, 84, '1', '1', '1', '1'),
(74, 2, 85, '1', '1', '1', '1'),
(75, 2, 86, '1', '1', '1', '1'),
(76, 2, 87, '1', '1', '1', '1'),
(77, 2, 88, '1', '1', '1', '1'),
(341, 2, 477, '1', '1', '1', '1'),
(79, 2, 75, '1', '1', '1', '1'),
(80, 2, 76, '1', '1', '1', '1'),
(81, 2, 77, '1', '1', '1', '1'),
(82, 2, 79, '1', '1', '1', '1'),
(343, 3, 480, '1', '1', '1', '1'),
(84, 2, 63, '1', '1', '1', '1'),
(85, 2, 64, '1', '1', '1', '1'),
(86, 2, 65, '1', '1', '1', '1'),
(87, 2, 66, '1', '1', '1', '1'),
(88, 2, 67, '1', '1', '1', '1'),
(89, 2, 68, '1', '1', '1', '1'),
(90, 2, 71, '1', '1', '1', '1'),
(91, 2, 72, '1', '1', '1', '1'),
(345, 2, 480, '1', '1', '1', '1'),
(93, 2, 56, '1', '1', '1', '1'),
(94, 2, 57, '1', '1', '1', '1'),
(95, 2, 58, '1', '1', '1', '1'),
(96, 2, 59, '1', '1', '1', '1'),
(347, 3, 499, '1', '1', '1', '1'),
(99, 3, 3, '1', '1', '1', '1'),
(100, 3, 5, '1', '1', '1', '1'),
(101, 3, 6, '1', '1', '1', '1'),
(102, 3, 7, '1', '1', '1', '1'),
(103, 3, 8, '1', '1', '1', '1'),
(104, 3, 9, '1', '1', '1', '1'),
(105, 3, 10, '1', '1', '1', '1'),
(360, 3, 520, '1', '1', '1', '1'),
(107, 3, 13, '1', '1', '1', '1'),
(108, 3, 14, '1', '1', '1', '1'),
(109, 3, 15, '1', '1', '1', '1'),
(110, 3, 16, '1', '1', '1', '1'),
(111, 3, 17, '1', '1', '1', '1'),
(358, 2, 520, '1', '1', '1', '1'),
(113, 3, 21, '1', '1', '1', '1'),
(114, 3, 22, '1', '1', '1', '1'),
(115, 3, 23, '1', '1', '1', '1'),
(116, 3, 24, '1', '1', '1', '1'),
(117, 3, 25, '1', '1', '1', '1'),
(118, 3, 26, '1', '1', '1', '1'),
(119, 3, 27, '1', '1', '1', '1'),
(356, 2, 524, '1', '1', '1', '1'),
(121, 3, 30, '1', '1', '1', '1'),
(122, 3, 31, '1', '1', '1', '1'),
(123, 3, 32, '1', '1', '1', '1'),
(124, 3, 33, '1', '1', '1', '1'),
(125, 3, 34, '1', '1', '1', '1'),
(126, 3, 35, '1', '1', '1', '1'),
(127, 3, 36, '1', '1', '1', '1'),
(128, 3, 37, '1', '1', '1', '1'),
(129, 3, 38, '1', '1', '1', '1'),
(130, 3, 39, '1', '1', '1', '1'),
(131, 3, 40, '1', '1', '1', '1'),
(132, 3, 41, '1', '1', '1', '1'),
(353, 3, 522, '1', '1', '1', '1'),
(135, 3, 50, '1', '1', '1', '1'),
(348, 3, 501, '1', '1', '1', '1'),
(137, 3, 53, '1', '1', '1', '1'),
(138, 3, 54, '1', '1', '1', '1'),
(139, 3, 55, '1', '1', '1', '1'),
(140, 3, 56, '1', '1', '1', '1'),
(141, 3, 57, '1', '1', '1', '1'),
(142, 3, 58, '1', '1', '1', '1'),
(143, 3, 59, '1', '1', '1', '1'),
(346, 2, 482, '1', '1', '1', '1'),
(145, 3, 63, '1', '1', '1', '1'),
(146, 3, 64, '1', '1', '1', '1'),
(147, 3, 65, '1', '1', '1', '1'),
(148, 3, 66, '1', '1', '1', '1'),
(149, 3, 67, '1', '1', '1', '1'),
(150, 3, 68, '1', '1', '1', '1'),
(151, 3, 71, '1', '1', '1', '1'),
(152, 3, 72, '1', '1', '1', '1'),
(344, 3, 482, '1', '1', '1', '1'),
(154, 3, 75, '1', '1', '1', '1'),
(155, 3, 76, '1', '1', '1', '1'),
(156, 3, 77, '1', '1', '1', '1'),
(157, 3, 78, '1', '1', '1', '1'),
(158, 3, 79, '1', '1', '1', '1'),
(342, 2, 479, '1', '1', '1', '1'),
(160, 3, 82, '1', '1', '1', '1'),
(161, 3, 83, '1', '1', '1', '1'),
(162, 3, 84, '1', '1', '1', '1'),
(163, 3, 85, '1', '1', '1', '1'),
(164, 3, 86, '1', '1', '1', '1'),
(165, 3, 87, '1', '1', '1', '1'),
(166, 3, 88, '1', '1', '1', '1'),
(340, 3, 479, '1', '1', '1', '1'),
(339, 3, 477, '1', '1', '1', '1'),
(169, 3, 95, '1', '1', '1', '1'),
(330, 3, 461, '1', '1', '1', '1'),
(171, 3, 99, '1', '1', '1', '1'),
(172, 3, 100, '1', '1', '1', '1'),
(173, 3, 101, '1', '1', '1', '1'),
(174, 3, 102, '1', '1', '1', '1'),
(175, 3, 103, '1', '1', '1', '1'),
(176, 3, 104, '1', '1', '1', '1'),
(177, 3, 105, '1', '1', '1', '1'),
(328, 2, 461, '1', '1', '1', '1'),
(179, 3, 109, '1', '1', '1', '1'),
(180, 3, 110, '1', '1', '1', '1'),
(324, 3, 506, '1', '1', '1', '1'),
(182, 3, 114, '1', '1', '1', '1'),
(183, 3, 115, '1', '1', '1', '1'),
(184, 3, 116, '1', '1', '1', '1'),
(185, 3, 117, '1', '1', '1', '1'),
(186, 3, 118, '1', '1', '1', '1'),
(322, 3, 447, '1', '1', '1', '1'),
(188, 3, 121, '1', '1', '1', '1'),
(189, 3, 122, '1', '1', '1', '1'),
(190, 3, 123, '1', '1', '1', '1'),
(191, 3, 124, '1', '1', '1', '1'),
(192, 3, 125, '1', '1', '1', '1'),
(193, 3, 126, '1', '1', '1', '1'),
(320, 2, 447, '1', '1', '1', '1'),
(195, 3, 138, '1', '1', '1', '1'),
(196, 3, 139, '1', '1', '1', '1'),
(197, 3, 140, '1', '1', '1', '1'),
(362, 3, 516, '1', '1', '1', '1'),
(338, 2, 475, '1', '1', '1', '1'),
(422, 2, 571, '1', '1', '1', '1'),
(308, 3, 342, '1', '1', '1', '1'),
(307, 2, 342, '1', '1', '1', '1'),
(421, 2, 570, '1', '1', '1', '1'),
(420, 2, 569, '1', '1', '1', '1'),
(386, 3, 539, '1', '1', '1', '1'),
(385, 2, 538, '1', '1', '1', '1'),
(309, 4, 343, '1', '1', '1', '1'),
(334, 3, 471, '1', '1', '1', '1'),
(313, 3, 364, '1', '1', '1', '1'),
(312, 3, 363, '1', '1', '1', '1'),
(311, 3, 362, '1', '1', '1', '1'),
(310, 3, 361, '1', '1', '1', '1'),
(380, 2, 533, '1', '1', '1', '1'),
(379, 2, 532, '1', '1', '1', '1'),
(375, 3, 536, '1', '1', '1', '1'),
(378, 2, 531, '1', '1', '1', '1'),
(377, 3, 538, '1', '1', '1', '1'),
(376, 3, 537, '1', '1', '1', '1'),
(228, 3, 213, '1', '1', '1', '1'),
(372, 3, 533, '1', '1', '1', '1'),
(373, 3, 534, '1', '1', '1', '1'),
(374, 3, 535, '1', '1', '1', '1'),
(335, 3, 473, '1', '1', '1', '1'),
(230, 3, 216, '1', '1', '1', '1'),
(232, 3, 218, '1', '1', '1', '1'),
(233, 3, 219, '1', '1', '1', '1'),
(249, 2, 225, '1', '1', '1', '1'),
(247, 3, 225, '1', '1', '1', '1'),
(337, 2, 473, '1', '1', '1', '1'),
(238, 2, 216, '1', '1', '1', '1'),
(240, 2, 218, '1', '1', '1', '1'),
(241, 2, 219, '1', '1', '1', '1'),
(248, 2, 224, '1', '1', '1', '1'),
(246, 3, 224, '1', '1', '1', '1'),
(336, 3, 475, '1', '1', '1', '1'),
(250, 3, 226, '1', '1', '1', '1'),
(251, 2, 226, '1', '1', '1', '1'),
(252, 2, 227, '1', '1', '1', '1'),
(253, 2, 228, '1', '1', '1', '1'),
(254, 2, 229, '1', '1', '1', '1'),
(255, 2, 230, '1', '1', '1', '1'),
(256, 2, 231, '1', '1', '1', '1'),
(257, 3, 227, '1', '1', '1', '1'),
(258, 3, 228, '1', '1', '1', '1'),
(259, 3, 229, '1', '1', '1', '1'),
(260, 3, 230, '1', '1', '1', '1'),
(261, 3, 231, '1', '1', '1', '1'),
(262, 4, 232, '1', '1', '1', '1'),
(263, 4, 233, '1', '1', '1', '1'),
(384, 2, 537, '1', '1', '1', '1'),
(383, 2, 536, '1', '1', '1', '1'),
(382, 2, 535, '1', '1', '1', '1'),
(381, 2, 534, '1', '1', '1', '1'),
(355, 2, 522, '1', '1', '1', '1'),
(352, 3, 512, '1', '1', '1', '1'),
(317, 4, 3, '-1', '-1', '-1', '-1'),
(332, 2, 471, '1', '1', '1', '1'),
(333, 3, 469, '1', '1', '1', '1'),
(276, 4, 289, '1', '1', '1', '1'),
(277, 4, 290, '1', '1', '1', '1'),
(278, 4, 291, '1', '1', '1', '1'),
(279, 4, 292, '1', '1', '1', '1'),
(280, 4, 225, '1', '1', '1', '1'),
(351, 3, 510, '1', '1', '1', '1'),
(350, 2, 501, '1', '1', '1', '1'),
(349, 2, 499, '1', '1', '1', '1'),
(327, 2, 368, '1', '1', '1', '1'),
(289, 3, 326, '1', '1', '1', '1'),
(290, 3, 327, '1', '1', '1', '1'),
(291, 3, 328, '1', '1', '1', '1'),
(326, 3, 459, '1', '1', '1', '1'),
(325, 2, 459, '1', '1', '1', '1'),
(371, 3, 532, '1', '1', '1', '1'),
(370, 3, 531, '1', '1', '1', '1'),
(369, 3, 446, '1', '1', '1', '1'),
(367, 3, 502, '1', '1', '1', '1'),
(365, 2, 502, '1', '1', '1', '1'),
(368, 3, 504, '1', '1', '1', '1'),
(366, 2, 504, '1', '1', '1', '1'),
(319, 4, 408, '1', '1', '1', '1'),
(364, 2, 516, '1', '1', '1', '1'),
(419, 3, 575, '1', '1', '1', '1'),
(415, 3, 571, '1', '1', '1', '1'),
(414, 3, 570, '1', '1', '1', '1'),
(396, 3, 549, '1', '1', '1', '1'),
(397, 3, 550, '1', '1', '1', '1'),
(398, 3, 551, '1', '1', '1', '1'),
(399, 3, 552, '1', '1', '1', '1'),
(400, 3, 553, '1', '1', '1', '1'),
(412, 3, 566, '1', '1', '1', '1'),
(402, 3, 555, '1', '1', '1', '1'),
(403, 3, 556, '1', '1', '1', '1'),
(404, 3, 557, '1', '1', '1', '1'),
(416, 3, 572, '1', '1', '1', '1'),
(417, 3, 573, '1', '1', '1', '1'),
(418, 3, 574, '1', '1', '1', '1'),
(413, 3, 569, '1', '1', '1', '1'),
(423, 2, 572, '1', '1', '1', '1'),
(424, 2, 573, '1', '1', '1', '1'),
(425, 2, 574, '1', '1', '1', '1'),
(426, 2, 575, '1', '1', '1', '1'),
(427, 3, 576, '1', '1', '1', '1'),
(428, 3, 577, '1', '1', '1', '1'),
(429, 3, 578, '1', '1', '1', '1'),
(430, 2, 576, '1', '1', '1', '1'),
(431, 2, 577, '1', '1', '1', '1'),
(432, 2, 578, '1', '1', '1', '1'),
(433, 2, 580, '1', '1', '1', '1'),
(434, 2, 581, '1', '1', '1', '1'),
(435, 2, 582, '1', '1', '1', '1'),
(436, 2, 583, '1', '1', '1', '1'),
(437, 2, 584, '1', '1', '1', '1'),
(438, 2, 585, '1', '1', '1', '1'),
(439, 2, 586, '1', '1', '1', '1'),
(440, 2, 588, '1', '1', '1', '1'),
(441, 3, 580, '1', '1', '1', '1'),
(442, 3, 581, '1', '1', '1', '1'),
(443, 3, 582, '1', '1', '1', '1'),
(444, 3, 583, '1', '1', '1', '1'),
(445, 3, 584, '1', '1', '1', '1'),
(446, 3, 585, '1', '1', '1', '1'),
(447, 3, 586, '1', '1', '1', '1'),
(448, 3, 588, '1', '1', '1', '1'),
(449, 3, 590, '1', '1', '1', '1'),
(450, 3, 591, '1', '1', '1', '1'),
(451, 3, 592, '1', '1', '1', '1'),
(452, 3, 593, '1', '1', '1', '1'),
(453, 3, 594, '1', '1', '1', '1'),
(454, 3, 595, '1', '1', '1', '1'),
(455, 3, 596, '1', '1', '1', '1'),
(456, 3, 598, '1', '1', '1', '1'),
(457, 2, 590, '1', '1', '1', '1'),
(458, 2, 591, '1', '1', '1', '1'),
(459, 2, 592, '1', '1', '1', '1'),
(460, 2, 593, '1', '1', '1', '1'),
(461, 2, 594, '1', '1', '1', '1'),
(462, 2, 595, '1', '1', '1', '1'),
(463, 2, 596, '1', '1', '1', '1'),
(464, 2, 598, '1', '1', '1', '1'),
(465, 3, 600, '1', '1', '1', '1'),
(466, 3, 601, '1', '1', '1', '1'),
(467, 3, 603, '1', '1', '1', '1'),
(468, 2, 600, '1', '1', '1', '1'),
(469, 2, 601, '1', '1', '1', '1'),
(470, 2, 603, '1', '1', '1', '1'),
(471, 8, 604, '1', '1', '1', '1'),
(472, 2, 602, '1', '1', '1', '1'),
(473, 2, 606, '1', '1', '1', '1'),
(474, 2, 607, '1', '1', '1', '1'),
(475, 2, 608, '1', '1', '1', '1'),
(476, 2, 609, '1', '1', '1', '1'),
(477, 2, 610, '1', '1', '1', '1'),
(478, 2, 611, '1', '1', '1', '1'),
(479, 2, 612, '1', '1', '1', '1'),
(480, 2, 613, '1', '1', '1', '1'),
(481, 2, 614, '1', '1', '1', '1'),
(482, 2, 615, '1', '1', '1', '1'),
(483, 2, 617, '1', '1', '1', '1'),
(484, 2, 618, '1', '1', '1', '1'),
(485, 2, 619, '1', '1', '1', '1'),
(486, 2, 620, '1', '1', '1', '1'),
(487, 2, 621, '1', '1', '1', '1'),
(488, 2, 622, '1', '1', '1', '1'),
(489, 2, 623, '1', '1', '1', '1'),
(490, 2, 624, '1', '1', '1', '1'),
(491, 2, 626, '1', '1', '1', '1'),
(492, 2, 627, '1', '1', '1', '1'),
(493, 2, 628, '1', '1', '1', '1'),
(494, 2, 629, '1', '1', '1', '1'),
(495, 2, 630, '1', '1', '1', '1'),
(496, 2, 631, '1', '1', '1', '1'),
(497, 2, 632, '1', '1', '1', '1'),
(498, 2, 633, '1', '1', '1', '1'),
(499, 2, 635, '1', '1', '1', '1'),
(500, 2, 636, '1', '1', '1', '1'),
(501, 2, 637, '1', '1', '1', '1'),
(502, 2, 638, '1', '1', '1', '1'),
(503, 2, 639, '1', '1', '1', '1'),
(504, 2, 640, '1', '1', '1', '1'),
(505, 2, 641, '1', '1', '1', '1'),
(506, 2, 642, '1', '1', '1', '1'),
(507, 2, 644, '1', '1', '1', '1'),
(508, 2, 645, '1', '1', '1', '1'),
(509, 2, 646, '1', '1', '1', '1'),
(510, 2, 647, '1', '1', '1', '1'),
(511, 2, 648, '1', '1', '1', '1'),
(512, 2, 649, '1', '1', '1', '1'),
(513, 2, 651, '1', '1', '1', '1'),
(514, 2, 652, '1', '1', '1', '1'),
(515, 2, 653, '1', '1', '1', '1'),
(516, 2, 654, '1', '1', '1', '1'),
(517, 2, 655, '1', '1', '1', '1'),
(518, 2, 656, '1', '1', '1', '1'),
(519, 2, 657, '1', '1', '1', '1'),
(520, 2, 658, '1', '1', '1', '1'),
(521, 3, 606, '1', '1', '1', '1'),
(522, 3, 607, '1', '1', '1', '1'),
(523, 3, 608, '1', '1', '1', '1'),
(524, 3, 609, '1', '1', '1', '1'),
(525, 3, 610, '1', '1', '1', '1'),
(526, 3, 611, '1', '1', '1', '1'),
(527, 3, 612, '1', '1', '1', '1'),
(528, 3, 613, '1', '1', '1', '1'),
(529, 3, 614, '1', '1', '1', '1'),
(530, 3, 615, '1', '1', '1', '1'),
(531, 3, 617, '1', '1', '1', '1'),
(532, 3, 618, '1', '1', '1', '1'),
(533, 3, 619, '1', '1', '1', '1'),
(534, 3, 620, '1', '1', '1', '1'),
(535, 3, 621, '1', '1', '1', '1'),
(536, 3, 622, '1', '1', '1', '1'),
(537, 3, 623, '1', '1', '1', '1'),
(538, 3, 624, '1', '1', '1', '1'),
(539, 3, 626, '1', '1', '1', '1'),
(540, 3, 627, '1', '1', '1', '1'),
(541, 3, 628, '1', '1', '1', '1'),
(542, 3, 629, '1', '1', '1', '1'),
(543, 3, 630, '1', '1', '1', '1'),
(544, 3, 631, '1', '1', '1', '1'),
(545, 3, 632, '1', '1', '1', '1'),
(546, 3, 633, '1', '1', '1', '1'),
(547, 3, 635, '1', '1', '1', '1'),
(548, 3, 636, '1', '1', '1', '1'),
(549, 3, 637, '1', '1', '1', '1'),
(550, 3, 638, '1', '1', '1', '1'),
(551, 3, 639, '1', '1', '1', '1'),
(552, 3, 640, '1', '1', '1', '1'),
(553, 3, 641, '1', '1', '1', '1'),
(554, 3, 642, '1', '1', '1', '1'),
(555, 3, 644, '1', '1', '1', '1'),
(556, 3, 645, '1', '1', '1', '1'),
(557, 3, 646, '1', '1', '1', '1'),
(558, 3, 647, '1', '1', '1', '1'),
(559, 3, 648, '1', '1', '1', '1'),
(560, 3, 649, '1', '1', '1', '1'),
(561, 3, 651, '1', '1', '1', '1'),
(562, 3, 652, '1', '1', '1', '1'),
(563, 3, 653, '1', '1', '1', '1'),
(564, 3, 654, '1', '1', '1', '1'),
(565, 3, 655, '1', '1', '1', '1'),
(566, 3, 656, '1', '1', '1', '1'),
(567, 3, 657, '1', '1', '1', '1'),
(568, 3, 658, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `gl_comments`
--

CREATE TABLE IF NOT EXISTS `gl_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'id of comment for replying from users for example administrator reply a comment which posted from Mohammad and it will be show in a quote tag in below the parent comment \r\n default is set to 0 for the main(parent) comments',
  `content_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'first name of user who add the comment this field is for guest users who haven''t user account in site',
  `email` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'user email address',
  `website` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'web site address',
  `content` text COLLATE utf8_persian_ci COMMENT 'comment body',
  `published` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'comment is published or not By default all comment is published => published = 1',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `content_id` (`content_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `gl_comments`
--

INSERT INTO `gl_comments` (`id`, `parent_id`, `content_id`, `name`, `email`, `website`, `content`, `published`, `created`) VALUES
(1, 0, 2, '456', 'dsf@df.sd', 'http://www.df.df', '12312333333333333333333333333333333333333333333333333333333', 0, '1391-10-14 13:41:31'),
(2, 0, 5, 'dfg', 'dsf@df.sd', 'http://www.df.df', 'dfgdfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff', 0, '1391-10-22 19:23:17'),
(3, 0, 5, 'sdf', 'dsf@df.sd', 'http://www.df.df', 'sddsdsssssssssssssssssssssssssssss', 0, '1391-10-22 19:24:47'),
(4, 0, 5, 'dfg', 'dsf@df.sd', 'http://www.df.df', '456666665555555555555555555555555555555555555555555555555', 0, '1391-10-22 19:32:18'),
(5, 0, 5, 'sdf', 'dsf@df.sd', 'http://www.df.df', '12333333333333333333333333333333333333333333333333333333', 0, '1391-10-22 19:37:28'),
(6, 0, 5, 'sdf', 'dsf@df.sd', 'http://www.df.df', '12333333333333333333333333333333333333333333333333333333', 0, '1391-10-22 19:40:24'),
(7, 0, 5, 'sdf', 'dsf@df.sd', 'http://www.df.df', '12333333333333333333333333333333333333333333333333333333', 0, '1391-10-22 19:40:48'),
(8, 0, 5, 'df', 'dsf@df.sd', 'http://www.df.df', 'sdfdfsddssddssdsddssssssssssssssfsdfs', 0, '1391-10-22 19:41:13'),
(9, 0, 5, 'df', 'dsf@df.sd', 'http://www.df.df', 'sdfdfsddssddssdsddssssssssssssssfsdfs', 0, '1391-10-22 19:41:18'),
(10, 0, 5, 'df', 'dsf@df.sd', 'http://www.df.df', 'sdfdfsddssddssdsddssssssssssssssfsdfs', 0, '1391-10-22 19:41:35'),
(11, 0, 5, 'df', 'dsf@df.sd', 'http://www.df.df', 'sdfdfsddssddssdsddssssssssssssssfsdfs', 0, '1391-10-22 19:41:42'),
(12, 0, 5, 'df', 'dsf@df.sd', 'http://www.df.df', 'sdfdfsddssddssdsddssssssssssssssfsdfs', 0, '1391-10-22 19:42:01'),
(13, 0, 5, 'df', 'dsf@df.sd', 'http://www.df.df', 'sdfdfsddssddssdsddssssssssssssssfsdfs', 0, '1391-10-22 19:42:08'),
(14, 0, 5, 'dfg', 'dsf@df.sd', 'http://www.df.df', 'dssddddddddddddddddddddddddddddddddddddd', 0, '1391-10-22 19:42:29'),
(15, 0, 5, 'dfg', 'dsf@df.sd', 'http://www.df.df', 'dssddddddddddddddddddddddddddddddddddddd', 0, '1391-10-22 19:45:24'),
(16, 0, 5, 'dfg', 'dsf@df.sd', 'http://www.df.df', 'dssddddddddddddddddddddddddddddddddddddd', 0, '1391-10-22 19:46:36'),
(17, 0, 5, 'fdg', 'dsf@df.sd', 'http://www.df.df', 'asdfasdddddddddddddddddddddd', 0, '1391-10-22 21:41:59'),
(18, 0, 5, 'fdg', 'dsf@df.sd', 'http://www.df.df', 'asdfasdddddddddddddddddddddd', 0, '1391-10-22 21:43:27'),
(19, 0, 8, 'cb', 'dsf@df.sd', 'http://www.df.df', 'cvbcxbvcxb xcv bcxv bcdf gdsf dfs', 0, '1391-10-23 09:59:53'),
(20, 0, 11, 'xcvb', 'dsf@df.sd', 'http://www.df.df', 'xcvbcxvbcxvbcxvbcxvbcxvbxcv', 1, '1391-10-23 14:33:31');

-- --------------------------------------------------------

--
-- Table structure for table `gl_contact_details`
--

CREATE TABLE IF NOT EXISTS `gl_contact_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'title of contact',
  `manager` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'manager name of company or web site',
  `telephone_1` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'company tel #1 example : 05118456628',
  `telephone_2` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'company tel #2 example : 05118456629',
  `fax` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'company fax number',
  `mobile` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'manger mobile number or company mobile number',
  `sms_center` varchar(14) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'company sms center for example : 3000662849',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gl_content_categories`
--

CREATE TABLE IF NOT EXISTS `gl_content_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT '0' COMMENT 'parent id of a category default is 0 this mean the category is parent! ',
  `name` varchar(30) COLLATE utf8_persian_ci NOT NULL COMMENT 'name of category',
  `descriptions` text COLLATE utf8_persian_ci,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `access` int(11) DEFAULT NULL COMMENT 'نشان می دهد که این مجموعه کجا باید نمایش داده شود.',
  `is_lock` int(11) DEFAULT NULL COMMENT 'اگر قفل باشد دیگر غیر قابل ویرایش و حذف است',
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `gl_content_categories`
--

INSERT INTO `gl_content_categories` (`id`, `user_id`, `parent_id`, `name`, `descriptions`, `published`, `access`, `is_lock`, `lft`, `rght`, `level`) VALUES
(1, 0, NULL, 'درباره اعضا', '<p>در این مجموعه اطلاعاتی که هر عضو درباره خود می دهد قرار می گیرد. این مجموعه غیرقابل حذف و ویرایش است</p>', 1, 1, 1, 1, 2, 0),
(4, 2, NULL, 'تست', '<p>تست</p>', 1, 1, NULL, 3, 6, 0),
(5, 2, 4, 'تست 2', '<p>سیسیییییییییییییییییییییییییییییییییییییییییییییی</p>', 1, 1, NULL, 4, 5, 1),
(6, 0, NULL, 'اخبار', '', 1, NULL, NULL, 7, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gl_contents`
--

CREATE TABLE IF NOT EXISTS `gl_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'the id of user from users table who post the content',
  `content_category_id` int(11) NOT NULL COMMENT 'id of content category',
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `intro` text COLLATE utf8_persian_ci NOT NULL,
  `content` text COLLATE utf8_persian_ci,
  `allow_comment` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'determine users can adding comments to this post or not?',
  `published_comment` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'this field determine comment show after added by users or after published by administrator',
  `frontpage` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status of content to show on the frontpage or not in the other pages By default all content is in other pages!',
  `published` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'status of content to be published or not By default all content is published',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_gl_contents_slug` (`slug`),
  KEY `content_category_id` (`content_category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `gl_contents`
--

INSERT INTO `gl_contents` (`id`, `user_id`, `content_category_id`, `title`, `slug`, `intro`, `content`, `allow_comment`, `published_comment`, `frontpage`, `published`, `created`, `modified`, `lft`, `rght`, `parent_id`) VALUES
(19, 3, 0, 'jh', 'jjh', '<p><img style="display: block; margin-left: auto; margin-right: auto;" src="/mosafer-behesht/app/webroot/uploads/bg_mon_1680x1050.jpg" alt="" width="427" height="266" /></p>', NULL, 0, 0, 1, 0, '1392-03-19 10:30:38', '1392-03-19 10:31:26', 3, 4, NULL),
(17, 3, 4, 'گرامی ترین وارد شونده بر خدا', 'گرامی_ترین_وارد_شونده_بر_خدا', '<div style="width: 600px; margin: 0 auto; padding-bottom: 20px; float: none;"><br /> السلام علیک یا علی بن موسی الرضا (ع)<br /> <em> سوگند به خدایی که ما را به امامت بعد از محمد عظمت بخشید ، و به جانشینی  پیامبر اختصاص داد، زائران قبرم روز رستاخیز ،گرامی ترین وارد شونده بر خدا  خواهند بود . هر مو منی که مرا زیارت کند و قطره اشکی بر رخسارش روان گردد  ، خدا پیکرش را برآتش دوزخ حرام کند.</em>\r\n<div style="text-align: left;"><span style="color: #008080;">امام رضا (علیه السلام)</span></div>\r\n</div>\r\n<div style="width: 600px; margin: 0 auto; padding-bottom: 20px; float: none;"><em> هر اقدامی که به منظور آسایش زوار و میهمانان آستان قدس رضوی انجام گیرد، بجا و موجب ثواب و اجر الهی برای اقدام کننده است. </em>\r\n<div style="text-align: left;"><span style="color: #008080;">مقام معظم رهبری</span></div>\r\n</div>\r\n<p>کثرت عاشقان و مشتاقان زیارت مرقد مطهر ثامن الحجج (ع) و خیل عظیم زائران  آنحضرت ، بویژه در مناسبتها و ایام خاص موجب گردیده است که علی رغم وجود  بیش از نیمی از واحدهای اقامتی و رفاهی کشور در شهر مقدس مشهد باز هم شاهد  کمبود و کاستی های زیاد در این زمینه باشیم . آموزش و اطلاع رسانی ، برنامه  ریزی از مبدا ، تقسیم سفر در طول سال ،سفر گروهی و کاروانی بجای سفر  انفرادی و.....ودر یک کلام ( <strong>مدیریت یکپارچه زائر</strong> ) می تواند بخشی از این کاستیها را ترمیم نماید. بدین منظور(سامانه  جامع مدیریت یکپارچه زائر) توسط ستاد ساماندهی امور زائرین مشهد و  با  حمایت همه جانبه و هماهنگ اعضای ستاد بویژه فرمانداری مشهد  &ndash; آستان قدس  رضوی &ndash; شهرداری مشهد &ndash; معاونت فرهنگی و اجتماعی &ndash; مدیریت امور زائرین و  گردشگری &ndash; سازمان میراث فرهنگی صنایع دستی و گردشگری خراسان رضوی - انجمن  صنفی دفاتر خدمات مسافرت هوایی و جهانگردی خراسان رضوی &ndash; اتحادیه های  واحدهای اقامتی مشهد - کمیته اجرای مراکز تجاری مشهد و ... طراحی گردیده و  انتظار می رود بتوانیم با بهره گیری از تمام امکانات موجود ضمن حفظ کرامت  والای زائرین محترم با ارائه خدمات مطلوب و قیمت مناسب گام کوچکی در خدمت  رسانی و جلب رضایت زائرین محترم و خشنودی علی بن موسی الرضا (ع) برداریم .</p>\r\n<p><strong class="head s">نحوه ورود به سامانه جامع مدیریت یکپارچه زائر :</strong></p>\r\n<p>ثبت نام در سامانه با توجه به دو گروه هدف یعنی زائرین و کارگزاران به دو بخش تقسیم می شود: یعنی زائرین محترم برای          <a href="http://mosafer-behesht.ir/users/register">ثبت نام</a> و          <a href="http://mosafer-behesht.ir/users/login">ورود</a>، به سامانه ثبت نام زائر کلیک می نمایند و کارگزاران محترم ، یعنی         <a href="http://mosafer-behesht.ir/agency/users/login">دفاتر خدمات مسافرتی و زیارتی</a> ،          <a href="http://mosafer-behesht.ir/hotel/users/login">واحدهای اقامتی</a> ،          <a href="http://mosafer-behesht.ir/refahi/users/login">مراکز رفاهی</a> ،          <a href="http://mosafer-behesht.ir/restaurant/users/login">واحدهای پذیرایی</a> ،          <a href="http://mosafer-behesht.ir/tafrihi/users/login">مراکز فرهنگی، تفریحی</a> ،          <a href="http://mosafer-behesht.ir/transfer/users/login">حمل و نقل</a> و....روی گزینه ثبت نام مربوط به خود کلیک می نمایند. زائرین محترم با  توجه به خدمات ، زمان ومکان&nbsp; درخواستی خود مراحل ثبت نام را بر حسب اولویت  در سامانه ادامه می دهند و در پایان با أخذ شماره پیگیری منتظر نتیجه بررسی  خواسته ها و اقدامات بعدی می شوند . کارگزاران محترم که تمایل به همکاری و  ارائه خدمات به زائرین را دارند گزینه ثبت نام را کلیک نموده و با تکمیل و  ارسال فرم مربوطه آمادگی خود را اعلام می دارند . اطلاعات کارگزاران  محترم&nbsp; بررسی و سپس برای مذاکره وعقد قرارداد با ایشان ارتباط برقرار خواهد  شد.</p>', NULL, 0, 0, 1, 1, '0000-00-00 00:00:00', '1392-03-19 10:31:01', 1, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gl_gallery_categories`
--

CREATE TABLE IF NOT EXISTS `gl_gallery_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0' COMMENT 'category parent id  By default all category added to the app is parent while the admin did ''nt  select a parent for its',
  `name` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `folder_name` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'category folder name for inserting images! for example image category folder is stored to : app/webroot/images/gallery \r\n and category name is MyFreinds so the images which added to this category will stored into :  app/webroot/images/gallery/MyFreinds',
  `published` int(11) DEFAULT NULL,
  `lft` tinyint(4) NOT NULL,
  `rght` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gl_gallery_categories`
--

INSERT INTO `gl_gallery_categories` (`id`, `parent_id`, `name`, `folder_name`, `published`, `lft`, `rght`) VALUES
(1, NULL, 'خدمات', 'services', 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `gl_gallery_items`
--

CREATE TABLE IF NOT EXISTS `gl_gallery_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'user id who added this image!',
  `gallery_category_id` int(11) NOT NULL,
  `title` varchar(30) COLLATE utf8_persian_ci NOT NULL COMMENT 'image title',
  `image_file_name` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'image name for accessing to it on gallery category folder',
  `description` text COLLATE utf8_persian_ci COMMENT 'image descriptions',
  `published` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'By default all images is published!',
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_category_id` (`gallery_category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gl_gallery_items`
--

INSERT INTO `gl_gallery_items` (`id`, `user_id`, `gallery_category_id`, `title`, `image_file_name`, `description`, `published`, `lft`, `rght`, `parent_id`) VALUES
(1, 3, 1, '3', 'eghamat.png', '23', 1, 1, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gl_link_types`
--

CREATE TABLE IF NOT EXISTS `gl_link_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `check_path` tinyint(4) DEFAULT NULL COMMENT 'check rule of url',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `gl_link_types`
--

INSERT INTO `gl_link_types` (`id`, `name`, `path`, `check_path`) VALUES
(1, 'مطلب', 'Contents', NULL),
(2, 'مجموعه مطالب', 'ContentCategories', NULL),
(3, 'تماس', 'ContactDetails', NULL),
(4, 'مجموعه گالری', 'GalleryCategories', NULL),
(5, 'گالری', 'GalleryItems', NULL),
(6, 'مجموعه لینک', 'WeblinkCategories', NULL),
(8, 'لینک خارجی', NULL, 1),
(9, 'صفحه اصلی', '/', NULL),
(10, 'جدا کننده', '#', NULL),
(11, 'لینک داخلی', NULL, NULL),
(12, 'مجموعه فروشگاه', 'Shop/Categories', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gl_menu_types`
--

CREATE TABLE IF NOT EXISTS `gl_menu_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gl_menu_types`
--

INSERT INTO `gl_menu_types` (`id`, `type`, `title`, `description`) VALUES
(1, 'public_menu', 'منوی عمومی', 'منویی که به همه کاربران نمایش داده می شود.'),
(2, 'right_manu', 'منوی راست', ''),
(3, 'zaer', 'زائر', 'منویی که فقط به زائرین وارد شده نمایش داده می شود');

-- --------------------------------------------------------

--
-- Table structure for table `gl_menus`
--

CREATE TABLE IF NOT EXISTS `gl_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'menu parent id for example a gallery menu which link''s to My Friends Gallery is a Child of Gallery menu which was an separator menu type   By default all menu is parent=>0',
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'menu alias for using on slugs',
  `link_type_id` int(11) DEFAULT NULL,
  `menu_type_id` int(11) NOT NULL COMMENT 'menu type for example :  1) contact 2) gallery 3) static page(linked to content) 4) web links 5) register 6) menu separator 7) site map ,.....',
  `published` int(1) NOT NULL DEFAULT '1' COMMENT 'By default all menu is published',
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=60 ;

--
-- Dumping data for table `gl_menus`
--

INSERT INTO `gl_menus` (`id`, `parent_id`, `title`, `link`, `link_type_id`, `menu_type_id`, `published`, `lft`, `rght`, `level`) VALUES
(1, 0, 'صفحه اصلی', '/', 9, 1, 1, 1, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gl_messages`
--

CREATE TABLE IF NOT EXISTS `gl_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` text,
  `created` char(20) DEFAULT NULL,
  `files` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `gl_messages`
--

INSERT INTO `gl_messages` (`id`, `user_id`, `subject`, `message`, `created`, `files`) VALUES
(1, 3, '213', '<p>12312321</p>', '1391-10-27 22:37:18', NULL),
(2, 3, 'fdhfdh', '<p>fdhfdhfdh</p>', '1391-10-27 22:37:37', NULL),
(3, 3, 'sdfgdsfg', '<p>dsfgsdfgsdfgdsfg</p>', '1391-10-27 22:37:55', NULL),
(4, 3, 'dfgh', '<p>fghdfgh</p>', '1391-10-27 22:38:25', NULL),
(5, 2, 'dfghdfgh', '<p>dfhdfhdfh</p>', '1391-10-27 22:38:42', NULL),
(6, 2, 'sd', '<p>dssd</p>', '1391-11-02 13:28:52', NULL),
(7, 3, 'شکایت', 'شکایتی از شما شده است', '1391-11-03 01:10:06', NULL),
(8, 3, 'شکایت', 'شکایتی از شما شده است', '1391-11-03 01:12:37', NULL),
(9, 3, 'شکایت شماره 9', 'واحد صنفی گرامی, از شما شکایتی به دست اتحادیه رسیده است. <br /> لطفا با مشاهده شکایت مربوطه دفاعیه خود را اعلام نمیید.', '1391-11-03 01:15:06', NULL),
(10, 3, 'شکایت شماره 10', '<p>واحد صنفی گرامی, از شما شکایتی به دست اتحادیه رسیده است. </p><p> لطفا با مشاهده شکایت مربوطه دفاعیه خود را اعلام نمائید. </p>', '1391-11-03 01:17:46', NULL),
(11, 3, 'شکایت شماره 6', '<p>واحد صنفی گرامی, از شما شکایتی به دست اتحادیه رسیده است. </p><p> لطفا با مشاهده شکایت مربوطه دفاعیه خود را اعلام نمائید. </p>', '1391-11-09 15:07:32', NULL),
(12, 3, 'شکایت شماره 11', '<p>واحد صنفی گرامی, از شما شکایتی به دست اتحادیه رسیده است. </p><p> لطفا با مشاهده شکایت مربوطه دفاعیه خود را اعلام نمائید. </p>', '1391-11-30 10:20:43', NULL),
(13, 2, 'پیام تست', '<p>این یک پیام تست است</p>', '1391-12-03 11:41:00', NULL),
(14, 3, 'پیام تست', '<p>این یک پیام تست است</p>', '1391-12-03 11:42:24', NULL),
(15, 3, 'درباره تمامی وقت ها و تمرینات', '<p>بییببییببی</p>', '1392-03-18 14:52:55', NULL),
(16, 3, 'درباره تمامی وقت ها و تمرینات', '<p>یبیبرز</p>', '1392-03-18 14:53:12', NULL),
(17, 3, 'hg', '<p>یبلا بیتیبانمبا یب امکتنیسب اسیبتنملا نسیتما صثقعفغ تنسیبل <a href="/mosafer-behesht/gh">نتسیبتل </a>سیبتنلا صثهعفغ عهثغنتیابن لتاسیبتلا سیب لسیب ل</p>', '1392-03-19 12:04:13', NULL),
(18, 3, 'df', '<p>یبلا بیتیبانمبا یب امکتنیسب اسیبتنملا نسیتما صثقعفغ تنسیبل <a href="/mosafer-behesht/gh">نتسیبتل </a>سیبتنلا صثهعفغ عهثغنتیابن لتاسیبتلا dffdfdfd df df df df df سیب لسیب ل</p>', '1392-03-19 12:04:30', NULL),
(19, 3, 'ds', '<p>sdsd</p>', '1392-06-28 11:58:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gl_messages_users`
--

CREATE TABLE IF NOT EXISTS `gl_messages_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `read_date` char(20) DEFAULT NULL,
  `new` int(2) DEFAULT NULL,
  `folder` int(1) DEFAULT NULL,
  `is_sender` tinyint(4) NOT NULL COMMENT 'if this user iis sender set true',
  `parent_id` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `gl_messages_users`
--

INSERT INTO `gl_messages_users` (`id`, `message_id`, `user_id`, `read_date`, `new`, `folder`, `is_sender`, `parent_id`, `lft`, `rght`) VALUES
(1, 1, 3, '1392-06-28 11:58:07', 0, 2, 1, 0, 1, 22),
(2, 1, 2, '1391-11-03 01:12:40', 0, 1, 0, 0, 23, 46),
(3, 2, 3, '1392-06-28 11:58:07', 0, 2, 1, 1, 2, 3),
(4, 2, 2, '1391-11-03 01:12:40', 0, 1, 0, 2, 24, 25),
(5, 3, 3, '1392-06-28 11:58:07', 0, 2, 1, 1, 4, 5),
(6, 3, 2, '1391-11-03 01:12:40', 0, 1, 0, 2, 26, 27),
(7, 4, 3, '1392-06-28 11:58:07', 0, 2, 1, 1, 6, 7),
(8, 4, 2, '1391-11-03 01:12:40', 0, 1, 0, 2, 28, 29),
(9, 5, 2, '1391-11-03 01:12:40', 0, 2, 1, 2, 30, 31),
(10, 5, 3, '1392-06-28 11:58:07', 0, 1, 0, 1, 8, 9),
(11, 6, 2, '1391-11-03 01:12:40', 0, 2, 1, 2, 32, 33),
(12, 6, 3, '1392-06-28 11:58:07', 0, 1, 0, 1, 10, 11),
(13, 7, 3, '1391-11-03 01:10:57', 0, 2, 1, 0, 47, 48),
(14, 7, 2, '1391-11-03 01:12:40', 0, 1, 0, 2, 34, 35),
(15, 8, 3, '1391-11-03 01:12:37', 0, 2, 1, 0, 49, 50),
(16, 8, 2, '1391-11-03 01:13:01', 0, 1, 0, 0, 51, 52),
(17, 9, 3, '1391-11-03 01:15:06', 0, 2, 1, 0, 53, 54),
(18, 9, 2, '1391-11-03 01:15:16', 0, 1, 0, 0, 55, 56),
(19, 10, 3, '1391-11-03 01:17:46', 0, 2, 1, 0, 57, 58),
(20, 10, 2, '1391-11-03 01:17:55', 0, 1, 0, 0, 59, 60),
(21, 11, 3, '1391-11-09 15:07:31', 0, 2, 1, 0, 61, 62),
(22, 11, NULL, '0', 1, 1, 0, 0, 63, 64),
(23, 12, 3, '1391-11-30 10:20:42', 0, 2, 1, 0, 65, 66),
(24, 12, 2, '0', 1, 1, 0, 0, 67, 68),
(25, 13, 2, '1391-12-03 11:41:00', 0, 2, 1, 0, 69, 70),
(26, 13, 3, '1392-03-18 14:32:06', 0, 1, 0, 0, 71, 72),
(27, 14, 3, '1391-12-03 11:42:24', 0, 2, 1, 0, 73, 74),
(28, 14, 1, '0', 1, 1, 0, 0, 75, 76),
(29, 14, 2, '0', 1, 1, 0, 0, 77, 78),
(30, 14, 15, '0', 1, 1, 0, 0, 79, 80),
(31, 15, 3, '1392-06-28 11:58:07', 0, 2, 1, 1, 12, 13),
(32, 15, 2, '0', 1, 1, 0, 2, 36, 37),
(33, 16, 3, '1392-06-28 11:58:07', 0, 2, 1, 1, 14, 15),
(34, 16, 2, '0', 1, 1, 0, 2, 38, 39),
(35, 17, 3, '1392-06-28 11:58:07', 0, 2, 1, 1, 16, 17),
(36, 17, 2, '0', 1, 1, 0, 2, 40, 41),
(37, 18, 3, '1392-06-28 11:58:07', 0, 2, 1, 1, 18, 19),
(38, 18, 2, '0', 1, 1, 0, 2, 42, 43),
(39, 19, 3, '1392-06-28 11:58:07', 0, 2, 1, 1, 20, 21),
(40, 19, 2, '0', 1, 1, 0, 2, 44, 45);

-- --------------------------------------------------------

--
-- Table structure for table `gl_options`
--

CREATE TABLE IF NOT EXISTS `gl_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `section` varchar(50) NOT NULL COMMENT 'نام جدولی که از این فیلد استفاده می کند در اینجا قرار میگیرد',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='این جدول شامل گزینه هایی است که در برنامه استفاده می شود' AUTO_INCREMENT=17 ;

--
-- Dumping data for table `gl_options`
--

INSERT INTO `gl_options` (`id`, `name`, `section`) VALUES
(1, 'در حریم آرایشگاه زنانه', 'warden'),
(2, 'در حریم مسجد', 'warden'),
(3, 'در حریم مدرسه', 'warden'),
(4, 'در حریم باشگاه', 'warden'),
(5, 'در حریم فروشگاه', 'warden'),
(6, 'زیر زمین', 'warden'),
(7, 'طبقه فوقانی', 'warden'),
(8, 'تصویر تمام صفحات شناسنامه (2 سری)', 'docs'),
(9, 'تصویر کارت پایان خدمت پشت و رو (2 سری)', 'docs'),
(10, 'تصویر آخرین مدرک تحصیلی (2 برگ)', 'docs'),
(11, 'عکس 3 در 4 رنگی (20 قطعه)', 'docs'),
(12, 'کد پستی 10 رقمی محل کار و سکونت', 'docs'),
(13, 'تصویر اجاره خط یا سند مغازه بعد از بازدید و تائید اتحادیه (2 برگ)', 'docs'),
(14, 'کپی تجاری مغازه (2 سری)', 'docs'),
(15, 'استعلام شهرداری', 'inquiry'),
(16, 'استعلام فرمانداری', 'inquiry');

-- --------------------------------------------------------

--
-- Table structure for table `gl_roles`
--

CREATE TABLE IF NOT EXISTS `gl_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `gl_roles`
--

INSERT INTO `gl_roles` (`id`, `name`, `title`, `lft`, `rght`, `parent_id`) VALUES
(1, 'Admin', 'مدیریت', 1, 2, NULL),
(2, 'SuperAdmin', 'مدیریت ارشد', 3, 4, NULL),
(3, 'Register', 'زائر', 5, 6, NULL),
(4, 'Hotel', 'واحد اقامتی', 7, 8, NULL),
(5, 'Agency', 'دفاتر مسافرتی', 9, 10, NULL),
(6, 'Refahi', 'مراکز خدمات رفاهی بین راهی', 11, 12, NULL),
(7, 'Restaurant', 'واحدهای پذیرایی/رستوران/کافی شاپ/فست فود و...', 13, 14, NULL),
(8, 'Tafrihi', 'مراکز فرهنگی، تفریحی، ورزشی، تجاری و ...', 15, 16, NULL),
(9, 'Transfer', 'شرکت های حمل و نقل', 17, 18, NULL),
(10, 'Insurance', 'بیمه', 19, 20, NULL),
(11, 'Agent', 'پیشخوان دولت', 21, 22, NULL),
(12, 'Personel_Place', 'مسئول واحد اقامتی', 23, 24, NULL),
(18, 'User', 'کاربر', 25, 26, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gl_settings`
--

CREATE TABLE IF NOT EXISTS `gl_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `namedSection` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `key` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `value` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `params` text COLLATE utf8_persian_ci,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `gl_settings`
--

INSERT INTO `gl_settings` (`id`, `section`, `namedSection`, `key`, `value`, `alias`, `params`, `modified`) VALUES
(1, 'Site', 'سایت', 'Name', 'مسافر بهشت - سامانه جامع ثبت نام زائر', 'عنوان سایت', NULL, '1392-03-20 12:12:13'),
(2, 'Site', 'سایت', 'Keywords', 'زيارت ، تور ، زائر ، مشهد ، گردشگری دینی ، تورهای زیارتی ، سیستم جامع ، سامانه ، ثبت نام ، ثبت نام زائر ، سفر زیارتی ، سفر مشهد ، تور مشهد ، امام رضا ، زیارت امام رضا ، مسافر بهشت ، مسافربهشت ، زیارت مشهد ، سفر های زیارتی ، ثبت نام تور ، کاروان ، کاروان زیارتی ، هیئت ، هیئت مذهبی ، هیئت سینه زنی ، هیئت عزاداری ، عزاداران ، مسجد ، مساجد ، هیئت امنا مساجد ، امور مساجد ، اوقاف', 'کلمات کلیدی', NULL, '1392-03-20 12:12:13'),
(3, 'Site', 'سایت', 'Description', 'زيارت ، تور ، زائر ، مشهد ، گردشگری دینی ، تورهای زیارتی ، سیستم جامع ، سامانه ، ثبت نام ، ثبت نام زائر ، سفر زیارتی ، سفر مشهد ، تور مشهد ، امام رضا ، زیارت امام رضا ، مسافر بهشت ، مسافربهشت ، زیارت مشهد ، سفر های زیارتی ، ثبت نام تور ، کاروان ، کاروان زیارتی ، هیئت ، هیئت مذهبی ، هیئت سینه زنی ، هیئت عزاداری ، عزاداران ، مسجد ، مساجد ، هیئت امنا مساجد ، امور مساجد ، اوقاف', 'توضیحات', NULL, '1392-03-20 12:12:13'),
(4, 'Site', 'سایت', 'FootNote', 'Siahat Shargh', 'پانویس', NULL, '1392-03-20 12:12:13'),
(24, 'System', 'سیستم', 'Debug', '1', 'نمایش خطا', 'a:1:{s:7:"options";a:2:{i:0;s:6:"خیر";i:1;s:6:"بله";}}', '1392-03-20 12:12:13'),
(5, 'Site', 'سایت', 'AdminAddress', 'admin', 'آدرس مدیریت', NULL, '1392-03-20 12:12:13'),
(6, 'Error', 'خطای سیستمی', 'Code-11', 'خطای شماره 11 - امکان ورود به سیستم وجود ندارد!', 'خطای شماره 11', NULL, '1392-03-20 12:12:13'),
(7, 'Error', 'خطای سیستمی', 'Code-12', 'خطای شماره 12 - درخواست شما نا معتبر است و امکان بررسی آن وجود ندارد!', 'خطای شماره 12', NULL, '1392-03-20 12:12:13'),
(8, 'Error', 'خطای سیستمی', 'Code-13', 'خطای شماره 13 - اطلاعات وارد شده معتبر نمی باشد. لطفا به خطاهای سیستم دقت کرده و مجددا تلاش نمایید!', 'خطای شماره 13', NULL, '1392-03-20 12:12:13'),
(9, 'Error', 'خطای سیستمی', 'Code-14', 'خطای شماره 14 – امکان انجام عملیات درخواستی بدلیل ارسال نادرست اطلاعات وجود ندارد!', 'خطای شماره 14', NULL, '1392-03-20 12:12:13'),
(10, 'Error', 'خطای سیستمی', 'Code-15', 'خطای شماره 15 – امکان حذف به علت دارا بودن آیتم های زیر مجموعه وجود ندارد. لطفا ابتدا آیتم های زیر مجموعه را حذف نمایید!', 'خطای شماره 15', NULL, '1392-03-20 12:12:13'),
(11, 'Error', 'خطای سیستمی', 'Code-16', 'خطای شماره 16 - به هر دلیلی امکان حذف وجود ندارد!', 'خطای شماره 16', NULL, '1392-03-20 12:12:13'),
(12, 'Site', 'سایت', 'Email', '', 'ایمیل سایت', NULL, '1392-03-20 12:12:13'),
(13, 'Error', 'خطای سیستمی', 'Code-17', 'خطای شماره 17 - اشکال در انجام تراکنش', 'خطای شماره 17', NULL, '1392-03-20 12:12:13'),
(14, 'Site', 'سایت', 'Template', 'MosaferBehesht', 'قالب سایت', NULL, '1392-03-20 12:12:13'),
(16, 'Error', 'خطای سیستمی', 'Code-18', 'این آیتم به صورت سیستمی تعریف شده است و امکان ویرایش یا حذف آن وجود ندارد', 'خطای شماره 18', NULL, '1392-03-20 12:12:13'),
(17, 'Content', 'مطالب', 'count', '20', 'تعداد مطالب در صفحه اصلی', NULL, '1392-03-19 10:27:49'),
(18, 'Content', 'مطالب', 'comment_for_registers', '0', 'قابلیت نظردهی برای مطالب اعضا', 'a:1:{s:7:"options";a:2:{i:0;s:6:"خیر";i:1;s:6:"بله";}}', '1392-03-19 10:27:49'),
(19, 'Content', 'مطالب', 'register_has_content', '1', 'قابلیت نوشتن مطلب توسط اعضا', 'a:1:{s:7:"options";a:2:{i:0;s:6:"خیر";i:1;s:6:"بله";}}', '1392-03-19 10:27:49'),
(20, 'SMS', 'پیامک', 'username', '4gdfh  df hhjfj56', 'نام کاربری', NULL, '1391-10-29 18:48:56'),
(21, 'SMS', 'پیامک', 'password', '456', 'رمز عبور', NULL, '1391-10-29 18:48:56'),
(22, 'SMS', 'پیامک', 'number', '456', 'شماره پیامک', NULL, '1391-10-29 18:48:56'),
(23, 'SMS', 'پیامک', 'link', '456', 'آدرس صفحه وب', NULL, '1391-10-29 18:48:56'),
(25, 'Content', 'مطالب', 'show_category_in_breadcrumb', '0', 'نمایش مجموعه مطالب در breadcrumb', 'a:1:{s:7:"options";a:2:{i:0;s:6:"خیر";i:1;s:6:"بله";}}', '1392-03-19 10:27:49'),
(26, 'User', 'کاربران', 'showCaptcha', '0', 'نمایش کپچا', 'a:1:{s:7:"options";a:2:{i:0;s:6:"خیر";i:1;s:6:"بله";}}', '1392-03-21 13:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `gl_slider_items`
--

CREATE TABLE IF NOT EXISTS `gl_slider_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'reference link for this slide',
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'image title',
  `description` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'image description for displaying under title!',
  `image_file_name` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'image name for accessing the true image on the slider folder! for example :  app/webroot/images/slider/slide_01.jpg',
  `published` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'By default all images in slider is published!',
  `created` datetime NOT NULL,
  `link_type_id` int(11) NOT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gl_slider_items`
--

INSERT INTO `gl_slider_items` (`id`, `link`, `title`, `description`, `image_file_name`, `published`, `created`, `link_type_id`, `lft`, `rght`, `parent_id`) VALUES
(1, '/Contents/view/17-گرامی_ترین_وارد_شونده_بر_خدا', 'زائرسرای بزرگ امام رضا (ع)', '', 'eghamat.png', 1, '1392-03-04 11:14:54', 1, 3, 4, NULL),
(3, 'http:///', 'زائرسرای بزرگ امام رضا (ع)', '', 'eskan.png', 1, '1392-03-20 13:33:57', 11, 1, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gl_sms`
--

CREATE TABLE IF NOT EXISTS `gl_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` char(14) DEFAULT NULL,
  `to` char(14) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created` char(20) DEFAULT NULL,
  `identifier` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gl_states`
--

CREATE TABLE IF NOT EXISTS `gl_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=303 ;

--
-- Dumping data for table `gl_states`
--

INSERT INTO `gl_states` (`id`, `name`, `parent_id`) VALUES
(1, 'آذربایجان شرقی', 0),
(2, 'آذربایجان غربی', 0),
(3, 'اردبیل', 0),
(4, 'اصفهان', 0),
(5, 'البرز', 0),
(6, 'ایلام', 0),
(7, 'بوشهر', 0),
(8, 'تهران', 0),
(9, 'چهارمحال و بختیاری', 0),
(10, 'خراسان جنوبی', 0),
(11, 'خراسان رضوی', 0),
(12, 'خراسان شمالی', 0),
(13, 'خوزستان', 0),
(14, 'زنجان', 0),
(15, 'سمنان', 0),
(16, 'سیستان و بلوچستان', 0),
(17, 'فارس', 0),
(18, 'قزوین', 0),
(19, 'قم', 0),
(20, 'کردستان', 0),
(21, 'کرمان', 0),
(22, 'کرمانشاه', 0),
(23, 'کهگیلویه و بویراحمد', 0),
(24, 'گلستان', 0),
(25, 'گیلان', 0),
(26, 'لرستان', 0),
(27, 'مازندران', 0),
(28, 'مرکزی', 0),
(29, 'هرمزگان', 0),
(30, 'همدان', 0),
(31, 'یزد', 0),
(32, 'اهر', 1),
(33, 'تیریز', 1),
(34, 'جلفا', 1),
(35, 'سراب', 1),
(36, 'شبستر', 1),
(37, 'عجب شیر', 1),
(38, 'کلیبر', 1),
(39, 'مراغه', 1),
(40, 'مرند', 1),
(41, 'میانه', 1),
(42, 'هشترود', 1),
(43, 'ورزقان', 1),
(44, 'ارومیه', 2),
(45, 'اشنویه', 2),
(46, 'بوکان', 2),
(47, 'تکاب', 2),
(48, 'چالدران', 2),
(49, 'خوی', 2),
(50, 'سردشت', 2),
(51, 'ماکو', 2),
(52, 'مهاباد', 2),
(53, 'نقده', 2),
(58, 'کوثر', 3),
(57, 'شهر نمین', 3),
(56, 'سرعین', 3),
(55, 'پارس آباد', 3),
(54, 'اردبیل', 3),
(60, 'مشکین شهر', 3),
(59, 'گرمی', 3),
(61, 'اردستان ', 4),
(62, 'اصفهان', 4),
(63, 'آران وبیدگل', 4),
(64, 'تیران و کرون', 4),
(65, 'خوانسار', 4),
(66, 'سمیرم', 4),
(67, 'شاهین شهر', 4),
(68, 'شهررضا', 4),
(69, 'قمصر', 4),
(70, 'کاشان', 4),
(71, 'گلپایگان', 4),
(72, 'نایین', 4),
(73, 'نجف آباد', 4),
(74, 'نطنز', 4),
(75, 'نیاسر', 4),
(76, 'ساوجبلاغ', 5),
(77, 'طالقان', 5),
(78, 'کرج', 5),
(79, 'نظرآباد', 5),
(80, 'ایلام', 6),
(81, 'ایوان', 6),
(82, 'آبدانان', 6),
(83, 'دره شهر', 6),
(84, 'دهلران', 6),
(85, 'شیروان و چرداول', 6),
(86, 'اشتهارد', 5),
(87, 'برازجان', 7),
(88, 'بوشهر', 7),
(89, 'تنگستان ', 7),
(90, 'جم', 7),
(91, 'خورموج', 7),
(92, 'دشتی', 7),
(93, 'کنگان', 7),
(94, 'تهران', 8),
(95, 'دماوند', 8),
(96, 'ری', 8),
(97, 'شهریار', 8),
(98, 'فیروزکوه', 8),
(99, 'ورامین', 8),
(100, 'اردل', 9),
(101, 'بروجن', 9),
(102, 'چلگرد', 9),
(103, 'شهرکرد', 9),
(104, 'کوهرنگ', 9),
(105, 'لردگان', 9),
(106, 'بیرجند', 10),
(107, 'درمیان', 10),
(108, 'سرایان', 10),
(109, 'سربیشه', 10),
(110, 'فردوس', 10),
(111, 'قائنات', 10),
(112, 'نهبندان', 10),
(113, 'تربت جام', 11),
(114, 'تربت حیدریه', 11),
(115, 'خواف', 11),
(116, 'درگز', 11),
(117, 'سبزوار', 11),
(118, 'سرخس', 11),
(119, 'شیروان', 11),
(120, 'فردوس', 11),
(121, 'قوچان', 11),
(122, 'کاشمر', 11),
(123, 'گناباد', 11),
(124, 'مشهد', 11),
(125, 'نیشابور', 11),
(126, 'فارسان', 9),
(127, 'اسفراین', 12),
(128, 'آشخانه', 12),
(129, 'بجنورد', 12),
(130, 'پیش فلعه', 12),
(131, 'حصار گرم خان', 12),
(132, 'درق', 12),
(133, 'راز', 12),
(134, 'فاروج', 12),
(135, 'قاضی', 12),
(136, 'گرمه', 12),
(137, 'لوجلی', 12),
(138, 'اندیمشک', 13),
(139, 'اهواز', 13),
(140, 'ایذه', 13),
(141, 'آبادان', 13),
(142, 'بهبهان', 13),
(143, 'خرمشهر', 13),
(144, 'دزفول', 13),
(145, 'دشت آزادگان', 13),
(146, 'رامهرمز', 13),
(147, 'شادگان', 13),
(148, 'شوش', 13),
(149, 'شوشتر', 13),
(150, 'ماهشهر', 13),
(151, 'مسجدسلیمان', 13),
(152, 'ابهر', 14),
(153, 'خدابنده', 14),
(154, 'زنجان', 14),
(155, 'ماهنشان', 14),
(156, 'دامغان', 15),
(157, 'سمنان', 15),
(158, 'شاهرود', 15),
(159, 'گرمسار', 15),
(160, 'ایرانشهر', 16),
(161, 'چابهار', 16),
(162, 'خاش', 16),
(163, 'زابل', 16),
(164, 'زاهدان', 16),
(165, 'سروان', 16),
(166, 'نیکشهر', 16),
(167, 'جهرم', 17),
(168, 'سپیدان', 17),
(169, 'شیراز', 17),
(170, 'فیروزآباد', 17),
(171, 'کازرون', 17),
(172, 'مرودشت', 17),
(173, 'قزوین', 18),
(174, 'تاکستان', 18),
(175, 'بوئین زهرا', 18),
(176, 'جعفریه', 19),
(177, 'دستجرد', 19),
(178, 'قم', 19),
(179, 'کهک', 19),
(180, 'بانه', 20),
(181, 'بیجار', 20),
(182, 'دیواندره', 20),
(183, 'سقز', 20),
(184, 'سنندج', 20),
(185, 'قروه', 20),
(186, 'کامیاران', 20),
(187, 'مریوان', 20),
(188, 'بافت', 21),
(189, 'بم', 21),
(190, 'راین', 21),
(191, 'رفسنجان', 21),
(192, 'شهربابک', 21),
(193, 'کرمان', 21),
(194, 'ماهان', 21),
(195, 'اسلام آباد غرب', 22),
(196, 'پاوه', 22),
(197, 'دالاهو', 22),
(198, 'سرپل ذهاب', 22),
(199, 'صحنه', 22),
(200, 'قصر شیرین', 22),
(201, 'کرمانشاه', 22),
(202, 'کنگاور', 22),
(203, 'گیلان غرب', 22),
(204, 'هرسین', 22),
(205, 'باشت', 23),
(206, 'چرام', 23),
(207, 'دوگنبدان', 23),
(208, 'دهدشت', 23),
(209, 'دیموشک', 23),
(210, 'سی سخت', 23),
(211, 'قلعه رئیسی', 23),
(212, 'گچساران', 23),
(213, 'گراب سفلی', 23),
(214, 'لنده', 23),
(215, 'لیکک', 23),
(216, 'یاسوج', 23),
(217, 'آزادشهر', 24),
(218, 'بندر ترکمن', 24),
(219, 'بندر گز', 24),
(220, 'رامیان', 24),
(221, 'علی آباد', 24),
(222, 'کردکوی', 24),
(223, 'گرگان', 24),
(224, 'گنبدکاووس', 24),
(225, 'مینودشت', 24),
(226, 'نوکده', 24),
(227, 'آستارا', 25),
(228, 'آستانه اشرفیه', 25),
(229, 'بندر انزلی', 25),
(230, 'تالش', 25),
(231, 'رشت', 25),
(232, 'رودبار', 25),
(233, 'رودسر', 25),
(234, 'سیاهکل', 25),
(235, 'فومن', 25),
(236, 'لاهیجان', 25),
(237, 'لنگرود', 25),
(238, 'ماسوله', 25),
(239, 'منجیل', 25),
(240, 'ازنا', 26),
(241, 'الیگودرز', 26),
(242, 'بروجرد', 26),
(243, 'پل دختر', 26),
(244, 'خرم آباد', 26),
(245, 'دلفان', 26),
(246, 'دورود', 26),
(247, 'سلسله', 26),
(248, 'کوهدشت', 26),
(249, 'آمل ', 27),
(250, 'بابل ', 27),
(251, 'بابلسرد', 27),
(252, 'بهشهر', 27),
(253, 'تنکابن ', 27),
(254, 'جویبار', 27),
(255, 'چالوس', 27),
(256, 'رامسر', 27),
(257, 'ساری', 27),
(258, 'سوادکوه', 27),
(259, 'قائم شهر', 27),
(260, 'محمود آباد', 27),
(261, 'نکا', 27),
(262, 'نور', 27),
(263, 'نور ', 27),
(264, 'نوشهر', 27),
(265, 'اراک', 28),
(266, 'آشتیان', 28),
(267, 'خمین', 28),
(268, 'دلیجان', 28),
(269, 'ساوه', 28),
(270, 'شازند', 28),
(271, 'کمیجان', 28),
(272, 'محلات', 28),
(273, 'بستک', 29),
(274, 'بندر کنگ', 29),
(275, 'بندر لنگه', 29),
(276, 'بندر عباس', 29),
(277, 'جزیره قشم', 29),
(278, 'جزیره کیش', 29),
(279, 'جزیره هرمز', 29),
(280, 'رودان', 29),
(281, 'میناب', 29),
(282, 'اسد آباد', 30),
(283, 'بهار', 30),
(284, 'تویسرکان', 30),
(285, 'رزن', 30),
(286, 'کبودر آهنگ', 30),
(287, 'ملایر', 30),
(288, 'نهاوند', 30),
(289, 'همدان', 30),
(290, 'ابرکوه', 31),
(291, 'اردکان', 31),
(292, 'اشکذر', 31),
(293, 'بافق', 31),
(294, 'تفت', 31),
(295, 'زارچ', 31),
(296, 'صدوق', 31),
(297, 'طبس', 31),
(298, 'مهریز', 31),
(299, 'میبد', 31),
(300, 'یزد', 31),
(301, 'استهبان', 17),
(302, 'سلماس', 2);

-- --------------------------------------------------------

--
-- Table structure for table `gl_users`
--

CREATE TABLE IF NOT EXISTS `gl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_persian_ci NOT NULL COMMENT 'username must be unique',
  `password` varchar(40) COLLATE utf8_persian_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'Both Of first name and last name',
  `email` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'activation status of users By default all users is deactivated',
  `role_id` int(11) NOT NULL,
  `registered_date` datetime NOT NULL,
  `last_logged_in` datetime NOT NULL COMMENT 'latest login of user to the web site',
  `last_ip_logged_in` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_gl_users_username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `gl_users`
--

INSERT INTO `gl_users` (`id`, `username`, `password`, `name`, `email`, `active`, `role_id`, `registered_date`, `last_logged_in`, `last_ip_logged_in`) VALUES
(1, 'admin', '9ee2c9367485427679bd7a0ec1c7f3263869b387', 'جمال طوسی', 'jamal4533@yahoo.com', 1, 3, '0000-00-00 00:00:00', '1392-03-20 13:17:07', '127.0.0.1'),
(2, 'hamid', 'ddd20c26354abe5caefbdce42621716d09dcbe3f', 'حمید ممدوحی', 'hamid.mamdoohi@gmail.com', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '127.0.0.1'),
(3, 'razzaghi', '6017b1c16ab39a4f14f2a579fa9aa629936c78b6', 'محمد رزاقی', '1razzaghi@gmail.com', 1, 2, '0000-00-00 00:00:00', '1392-09-01 14:44:35', '127.0.0.1'),
(15, '0945981961', 'daf0b857884e8f26b40e14ced40ebd29039503ed', 'مصطفی مهتر', 'mostafa.mehtar@gmail.com', 1, 3, '1391-11-15 16:39:02', '1391-11-30 10:20:12', '127.0.0.1'),
(16, 'hamid1', 'ddd20c26354abe5caefbdce42621716d09dcbe3f', 'hamid', NULL, 0, 2, '1392-07-25 12:12:08', '0000-00-00 00:00:00', ''),
(17, 'hamid2', 'ddd20c26354abe5caefbdce42621716d09dcbe3f', 'hamid', NULL, 1, 2, '1392-07-25 12:13:12', '0000-00-00 00:00:00', ''),
(18, 'hamid12', 'ddd20c26354abe5caefbdce42621716d09dcbe3f', 'حمید ممدوحی', NULL, 1, 18, '1392-08-16 08:43:45', '1392-09-01 16:56:32', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `gl_weblink_categories`
--

CREATE TABLE IF NOT EXISTS `gl_weblink_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gl_weblink_categories`
--

INSERT INTO `gl_weblink_categories` (`id`, `name`) VALUES
(1, 'لینک خارجی');

-- --------------------------------------------------------

--
-- Table structure for table `gl_weblinks`
--

CREATE TABLE IF NOT EXISTS `gl_weblinks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weblink_category_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'links title',
  `description` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'links description',
  `address` varchar(100) COLLATE utf8_persian_ci NOT NULL COMMENT 'link address',
  `hits` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'number of link hits after each click on link hits +1',
  `published` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'By default all link is published',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `weblink_category_id` (`weblink_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gl_weblinks`
--

INSERT INTO `gl_weblinks` (`id`, `weblink_category_id`, `title`, `description`, `address`, `hits`, `published`, `created`) VALUES
(1, 1, '546', '54', 'http://dfg.com', 0, 1, '1392-03-04 14:18:43');

-- --------------------------------------------------------

--
-- Table structure for table `shop_categories`
--

CREATE TABLE IF NOT EXISTS `shop_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `desc` text,
  `thumbnail_file_name` varchar(255) DEFAULT NULL,
  `created` char(19) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `shop_categories`
--

INSERT INTO `shop_categories` (`id`, `name`, `published`, `desc`, `thumbnail_file_name`, `created`, `lft`, `rght`, `parent_id`, `level`) VALUES
(1, 'ورزشی', 1, '<p>sd</p>', 'fetr.jpg', '1392-07-16 13:36:49', 3, 10, NULL, 0),
(2, 'فوتبال', 1, '<p>xzcv</p>', '1267519294.jpg', '1392-07-16 13:42:41', 6, 9, 1, 1),
(3, 'لیگ برتر', 1, '<p>tyu</p>', NULL, '1392-07-16 13:46:54', 7, 8, 2, 2),
(4, 'والیبال', 1, '<p>sda</p>', NULL, '1392-07-16 13:56:37', 4, 5, 1, 1),
(5, 'سیاسی', 1, '<p>hghg</p>', NULL, '1392-07-16 14:07:11', 1, 2, NULL, 0),
(6, 'اجتماعی', 1, '<p>123123123</p>', NULL, '1392-07-16 14:15:25', 11, 12, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `shop_comments`
--

CREATE TABLE IF NOT EXISTS `shop_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stuff_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `comment` varchar(255) NOT NULL,
  `reply_to` int(11) DEFAULT NULL,
  `created` varchar(19) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shop_coupons`
--

CREATE TABLE IF NOT EXISTS `shop_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) DEFAULT '1' COMMENT 'یک بار مصرف (1) یا چندبار مصرف (2)',
  `serial` varchar(50) DEFAULT NULL,
  `discount_type` int(1) DEFAULT '1' COMMENT 'درصدی (1) یا ارزشی (2)',
  `discount_value` int(11) DEFAULT NULL,
  `is_used` int(1) DEFAULT NULL,
  `created` varchar(19) DEFAULT NULL,
  `used_date` varchar(19) DEFAULT NULL,
  `factor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `serial` (`serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `shop_coupons`
--

INSERT INTO `shop_coupons` (`id`, `type`, `serial`, `discount_type`, `discount_value`, `is_used`, `created`, `used_date`, `factor_id`) VALUES
(1, 1, '123456', 2, 140000, 1, '1392-08-22 20:30:32', '1392-08-30 00:32:45', 19),
(2, 1, 'EID6302281', 1, 30, 1, '1392-08-30 00:54:18', '1392-09-01 13:23:39', 20),
(3, 1, 'EID5654552', 1, 30, 1, '1392-08-30 00:54:18', '1392-09-01 16:56:32', 24),
(4, 1, 'EID7714388', 1, 30, 1, '1392-08-30 00:54:18', '1392-09-01 17:37:39', 25),
(5, 1, 'EID3910483', 1, 30, NULL, '1392-08-30 00:54:18', NULL, NULL),
(6, 1, 'EID1549429', 1, 30, NULL, '1392-08-30 00:54:18', NULL, NULL),
(7, 1, 'EID5016474', 1, 30, NULL, '1392-08-30 00:54:18', NULL, NULL),
(8, 1, 'EID8819153', 1, 30, NULL, '1392-08-30 00:54:18', NULL, NULL),
(9, 1, 'EID2766271', 1, 30, NULL, '1392-08-30 00:54:18', NULL, NULL),
(10, 1, 'EID2555376', 1, 30, NULL, '1392-08-30 00:54:18', NULL, NULL),
(11, 1, 'EID5465198', 1, 30, NULL, '1392-08-30 00:54:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shop_deports`
--

CREATE TABLE IF NOT EXISTS `shop_deports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `shop_deports`
--

INSERT INTO `shop_deports` (`id`, `name`, `price`) VALUES
(1, 'پست', 150000);

-- --------------------------------------------------------

--
-- Table structure for table `shop_factor_heads`
--

CREATE TABLE IF NOT EXISTS `shop_factor_heads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT 'خریدار یا فروشنده',
  `type` int(11) DEFAULT NULL COMMENT 'فاکتور خرید (1) یا فاکتور فروش (2) می باشد',
  `date` varchar(19) DEFAULT NULL COMMENT 'تاریخ صدور فاکتور',
  `number` varchar(50) DEFAULT NULL COMMENT 'شماره فاکتور',
  `coupon_id` int(11) DEFAULT NULL COMMENT 'کوپن تخفیف',
  `total_price` int(11) DEFAULT NULL COMMENT 'جمع کل',
  `tax_id` int(11) DEFAULT NULL COMMENT 'مالیات',
  `deport_id` int(11) DEFAULT NULL COMMENT 'روش حمل کالا',
  `final_price` int(11) DEFAULT NULL COMMENT 'قیمت نهایی',
  `created` varchar(19) DEFAULT NULL COMMENT 'تاریخ ایجاد فاکتور',
  PRIMARY KEY (`id`),
  KEY `frn_tax_factor` (`tax_id`),
  KEY `frn_deport_factor` (`deport_id`),
  KEY `frn_user_factor` (`user_id`),
  KEY `frn_coupon_factor` (`coupon_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `shop_factor_heads`
--

INSERT INTO `shop_factor_heads` (`id`, `user_id`, `type`, `date`, `number`, `coupon_id`, `total_price`, `tax_id`, `deport_id`, `final_price`, `created`) VALUES
(1, 1, 1, '1392/07/15', '', NULL, NULL, NULL, NULL, NULL, '1392-07-23 12:13:41'),
(2, 1, 1, '1392/07/25', '985421', NULL, 6036000, NULL, NULL, 6036000, '1392-07-25 14:22:01'),
(3, 1, 1, '1392/07/27', '98554', NULL, 36000, NULL, NULL, 6036000, '1392-07-25 14:28:58'),
(4, 1, 1, '1392/07/27', '98554', NULL, 6036000, NULL, NULL, 6036000, '1392-07-25 14:29:20'),
(5, 1, 1, '', '', NULL, 6036000, NULL, NULL, 6036000, '1392-07-25 16:00:20'),
(6, 1, 1, '1392/07/23', '789', NULL, 100000000, NULL, NULL, 100000000, '1392-07-25 17:45:34'),
(7, 1, 1, '1392/07/23', '789', NULL, 100000000, NULL, NULL, 100000000, '1392-07-25 17:46:30'),
(8, 1, 1, '1392/07/08', '456', NULL, 6816000, NULL, NULL, 6816000, '1392-07-25 17:49:10'),
(9, 1, 1, '1392/07/16', '789', NULL, 36000, NULL, NULL, 36000, '1392-07-25 17:50:04'),
(10, 1, 1, '1392/07/22', '789', NULL, 200000, NULL, NULL, 200000, '1392-07-26 19:42:43'),
(11, 2, 2, '1392/08/16', '920816', 1, 828000, NULL, 1, 703000, '1392-08-16 09:48:33'),
(12, 2, 2, '1392/08/16', '92081612', NULL, 780000, NULL, NULL, 780000, '1392-08-16 09:50:39'),
(13, 2, 2, '1392/08/16', '92081613', NULL, 780000, NULL, NULL, 780000, '1392-08-16 09:59:09'),
(14, 2, 2, '1392/08/16', '92081614', NULL, 780000, NULL, NULL, 780000, '1392-08-16 10:35:54'),
(15, 2, 2, '1392/08/16', '92081615', 1, 216000, NULL, 1, 91000, '1392-08-16 10:38:52'),
(16, 2, 2, '1392/08/16', '92081616', 1, 216000, NULL, 1, 91000, '1392-08-16 10:46:57'),
(17, 2, 2, '1392/08/16', '92081617', NULL, 36000, NULL, NULL, 36000, '1392-08-16 10:55:15'),
(18, 2, 2, '1392/08/23', '92082318', 1, 2000000, 1, 1, 1875000, '1392-08-23 13:27:49'),
(19, 2, 2, '1392/08/30', '92083019', 1, 600000, NULL, 1, 610000, '1392-08-30 00:32:45'),
(20, 2, 2, '1392/09/01', '92090120', 2, 748500, NULL, 1, 898470, '1392-09-01 13:23:39'),
(21, 1, 1, '1392/09/11', '789', NULL, 10000000, NULL, NULL, 10000000, '1392-09-01 15:52:35'),
(22, 1, 1, '1392/09/18', '89789', NULL, 9500000, NULL, NULL, 9500000, '1392-09-01 15:55:51'),
(23, 2, 2, '1392/09/10', '89789', NULL, 6000000, NULL, NULL, 6000000, '1392-09-01 16:09:16'),
(24, 2, 2, '1392/09/01', '92090124', 3, 427500, NULL, 1, 449250, '1392-09-01 16:56:32'),
(25, 2, 2, '1392/09/01', '92090125', 4, 712500, NULL, 1, 648750, '1392-09-01 17:37:39');

-- --------------------------------------------------------

--
-- Table structure for table `shop_factor_items`
--

CREATE TABLE IF NOT EXISTS `shop_factor_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head_id` int(11) DEFAULT NULL,
  `stuff_id` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `shop_factor_items`
--

INSERT INTO `shop_factor_items` (`id`, `head_id`, `stuff_id`, `count`, `price`, `total_price`) VALUES
(1, 4, 2, 30, 200000, 6000000),
(2, 4, 3, 3, 12000, 36000),
(3, 5, 2, 30, 200000, 6000000),
(4, 5, 3, 3, 12000, 36000),
(5, 6, 2, 500, 200000, 100000000),
(6, 6, NULL, 1, NULL, 0),
(7, 7, 2, 500, 200000, 100000000),
(8, 7, 4, 1, 0, 0),
(9, 8, 3, 568, 12000, 6816000),
(10, 9, 3, 3, 12000, 36000),
(11, 10, 2, 1, 200000, 200000),
(12, 11, 3, 69, 12000, 828000),
(13, 12, 3, 65, 12000, 780000),
(14, 13, 3, 65, 12000, 780000),
(15, 14, 3, 65, 12000, 780000),
(16, 15, 3, 18, 12000, 216000),
(17, 16, 3, 18, 12000, 216000),
(18, 17, 3, 3, 12000, 36000),
(19, 18, 2, 10, 200000, 2000000),
(20, 19, 2, 3, 200000, 600000),
(21, 20, 3, 3, 12000, 36000),
(22, 20, 4, 5, 142500, 712500),
(23, 21, 4, 50, 200000, 10000000),
(24, 22, 4, 50, 190000, 9500000),
(25, 23, 4, 40, 150000, 6000000),
(26, 24, 4, 3, 142500, 427500),
(27, 25, 4, 5, 142500, 712500);

-- --------------------------------------------------------

--
-- Table structure for table `shop_galleries`
--

CREATE TABLE IF NOT EXISTS `shop_galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stuff_id` int(11) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `image_file_name` varchar(255) DEFAULT NULL,
  `published` int(1) DEFAULT NULL,
  `created` varchar(19) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shop_groups`
--

CREATE TABLE IF NOT EXISTS `shop_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `created` varchar(19) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `shop_groups`
--

INSERT INTO `shop_groups` (`id`, `name`, `discount`, `created`) VALUES
(1, 'عادی', 0, NULL),
(6, 'برنزی', 10, '1392-09-01 11:15:30'),
(7, 'نقره ای', 15, '1392-09-01 11:25:17'),
(8, 'طلایی', 20, '1392-09-01 11:26:05');

-- --------------------------------------------------------

--
-- Table structure for table `shop_shop_users`
--

CREATE TABLE IF NOT EXISTS `shop_shop_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `frn_group_user` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `shop_shop_users`
--

INSERT INTO `shop_shop_users` (`id`, `user_id`, `type`, `address`, `phone`, `mobile`, `group_id`) VALUES
(1, 3, 1, 'sd', '32', '32', 1),
(2, 18, 2, 'مشهد', '09159922885', '09159922885', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shop_stuffs`
--

CREATE TABLE IF NOT EXISTS `shop_stuffs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `thumbnail_file_name` varchar(255) DEFAULT NULL,
  `count` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(3) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `dimension` varchar(100) DEFAULT NULL,
  `download_file_file_name` varchar(100) DEFAULT NULL,
  `deport_id` int(11) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `attachments_file_name` varchar(500) DEFAULT NULL,
  `published` int(1) DEFAULT NULL,
  `order` int(1) DEFAULT NULL,
  `desc` text,
  `created` varchar(19) DEFAULT NULL,
  `modified` varchar(19) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `shop_stuffs`
--

INSERT INTO `shop_stuffs` (`id`, `code`, `name`, `category_id`, `thumbnail_file_name`, `count`, `price`, `discount`, `type`, `weight`, `dimension`, `download_file_file_name`, `deport_id`, `tax_id`, `attachments_file_name`, `published`, `order`, `desc`, `created`, `modified`) VALUES
(2, 'C12354', 'sd', 3, '32_copy.jpg', 988, 200000, NULL, 1, NULL, '', NULL, 0, 0, NULL, 1, 1, '<p>jhjhjhds</p>', '1392-07-20 06:19:54', '1392-07-27 03:59:06'),
(3, '1247', 'ماکارونی', 2, NULL, 855, 12000, NULL, 1, NULL, '', NULL, 0, 0, NULL, 1, 1, '', '1392-07-21 11:49:15', '1392-07-26 22:20:42'),
(4, '10056', 'برلیان', 6, 'Hamid_Picture.jpg', 17, 150000, 5, 1, 500, '10×20×30', NULL, 1, 1, 'DSC00062.JPG', 1, 1, '', '1392-09-01 12:02:02', '1392-09-01 16:09:16');

-- --------------------------------------------------------

--
-- Table structure for table `shop_taxes`
--

CREATE TABLE IF NOT EXISTS `shop_taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `percent` int(3) DEFAULT NULL,
  `created` varchar(19) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `shop_taxes`
--

INSERT INTO `shop_taxes` (`id`, `name`, `percent`, `created`) VALUES
(1, 'مالیات بر ارزش افزوده', 7, '1392-08-29 22:49:35');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `shop_factor_heads`
--
ALTER TABLE `shop_factor_heads`
  ADD CONSTRAINT `frn_coupon_factor` FOREIGN KEY (`coupon_id`) REFERENCES `shop_coupons` (`id`),
  ADD CONSTRAINT `frn_deport_factor` FOREIGN KEY (`deport_id`) REFERENCES `shop_deports` (`id`),
  ADD CONSTRAINT `frn_tax_factor` FOREIGN KEY (`tax_id`) REFERENCES `shop_taxes` (`id`),
  ADD CONSTRAINT `frn_user_factor` FOREIGN KEY (`user_id`) REFERENCES `shop_shop_users` (`id`);

--
-- Constraints for table `shop_shop_users`
--
ALTER TABLE `shop_shop_users`
  ADD CONSTRAINT `frn_group_user` FOREIGN KEY (`group_id`) REFERENCES `shop_groups` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
