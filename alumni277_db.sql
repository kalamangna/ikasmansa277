-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 02, 2025 at 07:33 AM
-- Server version: 10.11.8-MariaDB-0ubuntu0.24.04.1
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alumni277_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id_alumni` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat_domisili` text DEFAULT NULL,
  `provinsi_id` int(11) DEFAULT NULL,
  `kabupaten_id` int(11) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `referred_by` varchar(20) DEFAULT NULL,
  `referral` varchar(20) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL DEFAULT 'Laki-laki',
  `nama_panggilan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id_alumni`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `alamat_domisili`, `provinsi_id`, `kabupaten_id`, `no_telepon`, `email`, `referred_by`, `referral`, `jenis_kelamin`, `nama_panggilan`) VALUES
(1, 'Muhammad Rusyaid', 'Sinjai', '1977-08-26', 'Jl. Baso Kalaka Sinjai ', 73, 7307, '081130289393', 'uttibatu@gmail.com', NULL, '3FB52B93', 'Laki-laki', NULL),
(3, 's.fkjnewlkj lkjs ed', 'jashdbasjh', '1975-08-25', 'ewfjbhhj', 21, 2171, '09879896', 'ksjdnhasjkh@hhj.com', NULL, NULL, 'Laki-laki', NULL),
(9, 'werkhbg', 'iugfewiuyg', '2001-08-08', 'ajwhdg wduyg uy', 31, 3173, '081340289393', 'hghwsdf@uhgd.com', NULL, 'AC4C4859', 'Laki-laki', NULL),
(10, 'werkhbg', 'iugfewiuyg', '2001-08-08', 'ajwhdg wduyg uy', 11, 1114, '081340289393', 'hghwsdf@uhgd.com', NULL, NULL, 'Laki-laki', NULL),
(14, 'sdjkhg uyedg uow', 'wlkefjb', '1977-07-07', 'Jl. Baso Kalaka Sinjai', 73, 7307, '081130289393', 'alumnismansa277@gmail.com', '0', NULL, 'Laki-laki', NULL),
(15, 'wekfuih weiufh eiouf g', '6567', '1978-06-08', 'swekfjh gf', 14, 1403, '768767876', 'uttibatu1@gmail.com', '3FB52B93', 'FB4AD9AD', 'Laki-laki', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kabupaten`
--

CREATE TABLE `kabupaten` (
  `id_kabupaten` int(11) NOT NULL,
  `id_provinsi` int(11) DEFAULT NULL,
  `nama_kabupaten` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kabupaten`
--

INSERT INTO `kabupaten` (`id_kabupaten`, `id_provinsi`, `nama_kabupaten`) VALUES
(1101, 11, 'KAB. ACEH SELATAN'),
(1102, 11, 'KAB. ACEH TENGGARA'),
(1103, 11, 'KAB. ACEH TIMUR'),
(1104, 11, 'KAB. ACEH TENGAH'),
(1105, 11, 'KAB. ACEH BARAT'),
(1106, 11, 'KAB. ACEH BESAR'),
(1107, 11, 'KAB. PIDIE'),
(1108, 11, 'KAB. ACEH UTARA'),
(1109, 11, 'KAB. SIMEULUE'),
(1110, 11, 'KAB. ACEH SINGKIL'),
(1111, 11, 'KAB. BIREUEN'),
(1112, 11, 'KAB. ACEH BARAT DAYA'),
(1113, 11, 'KAB. GAYO LUES'),
(1114, 11, 'KAB. ACEH JAYA'),
(1115, 11, 'KAB. NAGAN RAYA'),
(1116, 11, 'KAB. ACEH TAMIANG'),
(1117, 11, 'KAB. BENER MERIAH'),
(1118, 11, 'KAB. PIDIE JAYA'),
(1171, 11, 'KOTA BANDA ACEH'),
(1172, 11, 'KOTA SABANG'),
(1173, 11, 'KOTA LHOKSEUMAWE'),
(1174, 11, 'KOTA LANGSA'),
(1175, 11, 'KOTA SUBULUSSALAM'),
(1201, 12, 'KAB. TAPANULI TENGAH'),
(1202, 12, 'KAB. TAPANULI UTARA'),
(1203, 12, 'KAB. TAPANULI SELATAN'),
(1204, 12, 'KAB. NIAS'),
(1205, 12, 'KAB. LANGKAT'),
(1206, 12, 'KAB. KARO'),
(1207, 12, 'KAB. DELI SERDANG'),
(1208, 12, 'KAB. SIMALUNGUN'),
(1209, 12, 'KAB. ASAHAN'),
(1210, 12, 'KAB. LABUHANBATU'),
(1211, 12, 'KAB. DAIRI'),
(1212, 12, 'KAB. TOBA'),
(1213, 12, 'KAB. MANDAILING NATAL'),
(1214, 12, 'KAB. NIAS SELATAN'),
(1215, 12, 'KAB. PAKPAK BHARAT'),
(1216, 12, 'KAB. HUMBANG HASUNDUTAN'),
(1217, 12, 'KAB. SAMOSIR'),
(1218, 12, 'KAB. SERDANG BEDAGAI'),
(1219, 12, 'KAB. BATU BARA'),
(1220, 12, 'KAB. PADANG LAWAS UTARA'),
(1221, 12, 'KAB. PADANG LAWAS'),
(1222, 12, 'KAB. LABUHANBATU SELATAN'),
(1223, 12, 'KAB. LABUHANBATU UTARA'),
(1224, 12, 'KAB. NIAS UTARA'),
(1225, 12, 'KAB. NIAS BARAT'),
(1271, 12, 'KOTA MEDAN'),
(1272, 12, 'KOTA PEMATANGSIANTAR'),
(1273, 12, 'KOTA SIBOLGA'),
(1274, 12, 'KOTA TANJUNG BALAI'),
(1275, 12, 'KOTA BINJAI'),
(1276, 12, 'KOTA TEBING TINGGI'),
(1277, 12, 'KOTA PADANGSIDIMPUAN'),
(1278, 12, 'KOTA GUNUNGSITOLI'),
(1301, 13, 'KAB. PESISIR SELATAN'),
(1302, 13, 'KAB. SOLOK'),
(1303, 13, 'KAB. SIJUNJUNG'),
(1304, 13, 'KAB. TANAH DATAR'),
(1305, 13, 'KAB. PADANG PARIAMAN'),
(1306, 13, 'KAB. AGAM'),
(1307, 13, 'KAB. LIMA PULUH KOTA'),
(1308, 13, 'KAB. PASAMAN'),
(1309, 13, 'KAB. KEPULAUAN MENTAWAI'),
(1310, 13, 'KAB. DHARMASRAYA'),
(1311, 13, 'KAB. SOLOK SELATAN'),
(1312, 13, 'KAB. PASAMAN BARAT'),
(1371, 13, 'KOTA PADANG'),
(1372, 13, 'KOTA SOLOK'),
(1373, 13, 'KOTA SAWAHLUNTO'),
(1374, 13, 'KOTA PADANG PANJANG'),
(1375, 13, 'KOTA BUKITTINGGI'),
(1376, 13, 'KOTA PAYAKUMBUH'),
(1377, 13, 'KOTA PARIAMAN'),
(1401, 14, 'KAB. KAMPAR'),
(1402, 14, 'KAB. INDRAGIRI HULU'),
(1403, 14, 'KAB. BENGKALIS'),
(1404, 14, 'KAB. INDRAGIRI HILIR'),
(1405, 14, 'KAB. PELALAWAN'),
(1406, 14, 'KAB. ROKAN HULU'),
(1407, 14, 'KAB. ROKAN HILIR'),
(1408, 14, 'KAB. SIAK'),
(1409, 14, 'KAB. KUANTAN SINGINGI'),
(1410, 14, 'KAB. KEPULAUAN MERANTI'),
(1471, 14, 'KOTA PEKANBARU'),
(1472, 14, 'KOTA DUMAI'),
(1501, 15, 'KAB. KERINCI'),
(1502, 15, 'KAB. MERANGIN'),
(1503, 15, 'KAB. SAROLANGUN'),
(1504, 15, 'KAB. BATANGHARI'),
(1505, 15, 'KAB. MUARO JAMBI'),
(1506, 15, 'KAB. TANJUNG JABUNG BARAT'),
(1507, 15, 'KAB. TANJUNG JABUNG TIMUR'),
(1508, 15, 'KAB. BUNGO'),
(1509, 15, 'KAB. TEBO'),
(1571, 15, 'KOTA JAMBI'),
(1572, 15, 'KOTA SUNGAI PENUH'),
(1601, 16, 'KAB. OGAN KOMERING ULU'),
(1602, 16, 'KAB. OGAN KOMERING ILIR'),
(1603, 16, 'KAB. MUARA ENIM'),
(1604, 16, 'KAB. LAHAT'),
(1605, 16, 'KAB. MUSI RAWAS'),
(1606, 16, 'KAB. MUSI BANYUASIN'),
(1607, 16, 'KAB. BANYUASIN'),
(1608, 16, 'KAB. OGAN KOMERING ULU TIMUR'),
(1609, 16, 'KAB. OGAN KOMERING ULU SELATAN'),
(1610, 16, 'KAB. OGAN ILIR'),
(1611, 16, 'KAB. EMPAT LAWANG'),
(1612, 16, 'KAB. PENUKAL ABAB LEMATANG ILIR'),
(1613, 16, 'KAB. MUSI RAWAS UTARA'),
(1671, 16, 'KOTA PALEMBANG'),
(1672, 16, 'KOTA PAGAR ALAM'),
(1673, 16, 'KOTA LUBUK LINGGAU'),
(1674, 16, 'KOTA PRABUMULIH'),
(1701, 17, 'KAB. BENGKULU SELATAN'),
(1702, 17, 'KAB. REJANG LEBONG'),
(1703, 17, 'KAB. BENGKULU UTARA'),
(1704, 17, 'KAB. KAUR'),
(1705, 17, 'KAB. SELUMA'),
(1706, 17, 'KAB. MUKO MUKO'),
(1707, 17, 'KAB. LEBONG'),
(1708, 17, 'KAB. KEPAHIANG'),
(1709, 17, 'KAB. BENGKULU TENGAH'),
(1771, 17, 'KOTA BENGKULU'),
(1801, 18, 'KAB. LAMPUNG SELATAN'),
(1802, 18, 'KAB. LAMPUNG TENGAH'),
(1803, 18, 'KAB. LAMPUNG UTARA'),
(1804, 18, 'KAB. LAMPUNG BARAT'),
(1805, 18, 'KAB. TULANG BAWANG'),
(1806, 18, 'KAB. TANGGAMUS'),
(1807, 18, 'KAB. LAMPUNG TIMUR'),
(1808, 18, 'KAB. WAY KANAN'),
(1809, 18, 'KAB. PESAWARAN'),
(1810, 18, 'KAB. PRINGSEWU'),
(1811, 18, 'KAB. MESUJI'),
(1812, 18, 'KAB. TULANG BAWANG BARAT'),
(1813, 18, 'KAB. PESISIR BARAT'),
(1871, 18, 'KOTA BANDAR LAMPUNG'),
(1872, 18, 'KOTA METRO'),
(1901, 19, 'KAB. BANGKA'),
(1902, 19, 'KAB. BELITUNG'),
(1903, 19, 'KAB. BANGKA SELATAN'),
(1904, 19, 'KAB. BANGKA TENGAH'),
(1905, 19, 'KAB. BANGKA BARAT'),
(1906, 19, 'KAB. BELITUNG TIMUR'),
(1971, 19, 'KOTA PANGKAL PINANG'),
(2101, 21, 'KAB. BINTAN'),
(2102, 21, 'KAB. KARIMUN'),
(2103, 21, 'KAB. NATUNA'),
(2104, 21, 'KAB. LINGGA'),
(2105, 21, 'KAB. KEPULAUAN ANAMBAS'),
(2171, 21, 'KOTA BATAM'),
(2172, 21, 'KOTA TANJUNG PINANG'),
(3101, 31, 'KAB. ADM. KEP. SERIBU'),
(3171, 31, 'KOTA ADM. JAKARTA PUSAT'),
(3172, 31, 'KOTA ADM. JAKARTA UTARA'),
(3173, 31, 'KOTA ADM. JAKARTA BARAT'),
(3174, 31, 'KOTA ADM. JAKARTA SELATAN'),
(3175, 31, 'KOTA ADM. JAKARTA TIMUR'),
(3201, 32, 'KAB. BOGOR'),
(3202, 32, 'KAB. SUKABUMI'),
(3203, 32, 'KAB. CIANJUR'),
(3204, 32, 'KAB. BANDUNG'),
(3205, 32, 'KAB. GARUT'),
(3206, 32, 'KAB. TASIKMALAYA'),
(3207, 32, 'KAB. CIAMIS'),
(3208, 32, 'KAB. KUNINGAN'),
(3209, 32, 'KAB. CIREBON'),
(3210, 32, 'KAB. MAJALENGKA'),
(3211, 32, 'KAB. SUMEDANG'),
(3212, 32, 'KAB. INDRAMAYU'),
(3213, 32, 'KAB. SUBANG'),
(3214, 32, 'KAB. PURWAKARTA'),
(3215, 32, 'KAB. KARAWANG'),
(3216, 32, 'KAB. BEKASI'),
(3217, 32, 'KAB. BANDUNG BARAT'),
(3218, 32, 'KAB. PANGANDARAN'),
(3271, 32, 'KOTA BOGOR'),
(3272, 32, 'KOTA SUKABUMI'),
(3273, 32, 'KOTA BANDUNG'),
(3274, 32, 'KOTA CIREBON'),
(3275, 32, 'KOTA BEKASI'),
(3276, 32, 'KOTA DEPOK'),
(3277, 32, 'KOTA CIMAHI'),
(3278, 32, 'KOTA TASIKMALAYA'),
(3279, 32, 'KOTA BANJAR'),
(3301, 33, 'KAB. CILACAP'),
(3302, 33, 'KAB. BANYUMAS'),
(3303, 33, 'KAB. PURBALINGGA'),
(3304, 33, 'KAB. BANJARNEGARA'),
(3305, 33, 'KAB. KEBUMEN'),
(3306, 33, 'KAB. PURWOREJO'),
(3307, 33, 'KAB. WONOSOBO'),
(3308, 33, 'KAB. MAGELANG'),
(3309, 33, 'KAB. BOYOLALI'),
(3310, 33, 'KAB. KLATEN'),
(3311, 33, 'KAB. SUKOHARJO'),
(3312, 33, 'KAB. WONOGIRI'),
(3313, 33, 'KAB. KARANGANYAR'),
(3314, 33, 'KAB. SRAGEN'),
(3315, 33, 'KAB. GROBOGAN'),
(3316, 33, 'KAB. BLORA'),
(3317, 33, 'KAB. REMBANG'),
(3318, 33, 'KAB. PATI'),
(3319, 33, 'KAB. KUDUS'),
(3320, 33, 'KAB. JEPARA'),
(3321, 33, 'KAB. DEMAK'),
(3322, 33, 'KAB. SEMARANG'),
(3323, 33, 'KAB. TEMANGGUNG'),
(3324, 33, 'KAB. KENDAL'),
(3325, 33, 'KAB. BATANG'),
(3326, 33, 'KAB. PEKALONGAN'),
(3327, 33, 'KAB. PEMALANG'),
(3328, 33, 'KAB. TEGAL'),
(3329, 33, 'KAB. BREBES'),
(3371, 33, 'KOTA MAGELANG'),
(3372, 33, 'KOTA SURAKARTA'),
(3373, 33, 'KOTA SALATIGA'),
(3374, 33, 'KOTA SEMARANG'),
(3375, 33, 'KOTA PEKALONGAN'),
(3376, 33, 'KOTA TEGAL'),
(3401, 34, 'KAB. KULON PROGO'),
(3402, 34, 'KAB. BANTUL'),
(3403, 34, 'KAB. GUNUNGKIDUL'),
(3404, 34, 'KAB. SLEMAN'),
(3471, 34, 'KOTA YOGYAKARTA'),
(3501, 35, 'KAB. PACITAN'),
(3502, 35, 'KAB. PONOROGO'),
(3503, 35, 'KAB. TRENGGALEK'),
(3504, 35, 'KAB. TULUNGAGUNG'),
(3505, 35, 'KAB. BLITAR'),
(3506, 35, 'KAB. KEDIRI'),
(3507, 35, 'KAB. MALANG'),
(3508, 35, 'KAB. LUMAJANG'),
(3509, 35, 'KAB. JEMBER'),
(3510, 35, 'KAB. BANYUWANGI'),
(3511, 35, 'KAB. BONDOWOSO'),
(3512, 35, 'KAB. SITUBONDO'),
(3513, 35, 'KAB. PROBOLINGGO'),
(3514, 35, 'KAB. PASURUAN'),
(3515, 35, 'KAB. SIDOARJO'),
(3516, 35, 'KAB. MOJOKERTO'),
(3517, 35, 'KAB. JOMBANG'),
(3518, 35, 'KAB. NGANJUK'),
(3519, 35, 'KAB. MADIUN'),
(3520, 35, 'KAB. MAGETAN'),
(3521, 35, 'KAB. NGAWI'),
(3522, 35, 'KAB. BOJONEGORO'),
(3523, 35, 'KAB. TUBAN'),
(3524, 35, 'KAB. LAMONGAN'),
(3525, 35, 'KAB. GRESIK'),
(3526, 35, 'KAB. BANGKALAN'),
(3527, 35, 'KAB. SAMPANG'),
(3528, 35, 'KAB. PAMEKASAN'),
(3529, 35, 'KAB. SUMENEP'),
(3571, 35, 'KOTA KEDIRI'),
(3572, 35, 'KOTA BLITAR'),
(3573, 35, 'KOTA MALANG'),
(3574, 35, 'KOTA PROBOLINGGO'),
(3575, 35, 'KOTA PASURUAN'),
(3576, 35, 'KOTA MOJOKERTO'),
(3577, 35, 'KOTA MADIUN'),
(3578, 35, 'KOTA SURABAYA'),
(3579, 35, 'KOTA BATU'),
(3601, 36, 'KAB. PANDEGLANG'),
(3602, 36, 'KAB. LEBAK'),
(3603, 36, 'KAB. TANGERANG'),
(3604, 36, 'KAB. SERANG'),
(3671, 36, 'KOTA TANGERANG'),
(3672, 36, 'KOTA CILEGON'),
(3673, 36, 'KOTA SERANG'),
(3674, 36, 'KOTA TANGERANG SELATAN'),
(5101, 51, 'KAB. JEMBRANA'),
(5102, 51, 'KAB. TABANAN'),
(5103, 51, 'KAB. BADUNG'),
(5104, 51, 'KAB. GIANYAR'),
(5105, 51, 'KAB. KLUNGKUNG'),
(5106, 51, 'KAB. BANGLI'),
(5107, 51, 'KAB. KARANGASEM'),
(5108, 51, 'KAB. BULELENG'),
(5171, 51, 'KOTA DENPASAR'),
(5201, 52, 'KAB. LOMBOK BARAT'),
(5202, 52, 'KAB. LOMBOK TENGAH'),
(5203, 52, 'KAB. LOMBOK TIMUR'),
(5204, 52, 'KAB. SUMBAWA'),
(5205, 52, 'KAB. DOMPU'),
(5206, 52, 'KAB. BIMA'),
(5207, 52, 'KAB. SUMBAWA BARAT'),
(5208, 52, 'KAB. LOMBOK UTARA'),
(5271, 52, 'KOTA MATARAM'),
(5272, 52, 'KOTA BIMA'),
(5301, 53, 'KAB. KUPANG'),
(5302, 53, 'KAB TIMOR TENGAH SELATAN'),
(5303, 53, 'KAB. TIMOR TENGAH UTARA'),
(5304, 53, 'KAB. BELU'),
(5305, 53, 'KAB. ALOR'),
(5306, 53, 'KAB. FLORES TIMUR'),
(5307, 53, 'KAB. SIKKA'),
(5308, 53, 'KAB. ENDE'),
(5309, 53, 'KAB. NGADA'),
(5310, 53, 'KAB. MANGGARAI'),
(5311, 53, 'KAB. SUMBA TIMUR'),
(5312, 53, 'KAB. SUMBA BARAT'),
(5313, 53, 'KAB. LEMBATA'),
(5314, 53, 'KAB. ROTE NDAO'),
(5315, 53, 'KAB. MANGGARAI BARAT'),
(5316, 53, 'KAB. NAGEKEO'),
(5317, 53, 'KAB. SUMBA TENGAH'),
(5318, 53, 'KAB. SUMBA BARAT DAYA'),
(5319, 53, 'KAB. MANGGARAI TIMUR'),
(5320, 53, 'KAB. SABU RAIJUA'),
(5321, 53, 'KAB. MALAKA'),
(5371, 53, 'KOTA KUPANG'),
(6101, 61, 'KAB. SAMBAS'),
(6102, 61, 'KAB. MEMPAWAH'),
(6103, 61, 'KAB. SANGGAU'),
(6104, 61, 'KAB. KETAPANG'),
(6105, 61, 'KAB. SINTANG'),
(6106, 61, 'KAB. KAPUAS HULU'),
(6107, 61, 'KAB. BENGKAYANG'),
(6108, 61, 'KAB. LANDAK'),
(6109, 61, 'KAB. SEKADAU'),
(6110, 61, 'KAB. MELAWI'),
(6111, 61, 'KAB. KAYONG UTARA'),
(6112, 61, 'KAB. KUBU RAYA'),
(6171, 61, 'KOTA PONTIANAK'),
(6172, 61, 'KOTA SINGKAWANG'),
(6201, 62, 'KAB. KOTAWARINGIN BARAT'),
(6202, 62, 'KAB. KOTAWARINGIN TIMUR'),
(6203, 62, 'KAB. KAPUAS'),
(6204, 62, 'KAB. BARITO SELATAN'),
(6205, 62, 'KAB. BARITO UTARA'),
(6206, 62, 'KAB. KATINGAN'),
(6207, 62, 'KAB. SERUYAN'),
(6208, 62, 'KAB. SUKAMARA'),
(6209, 62, 'KAB. LAMANDAU'),
(6210, 62, 'KAB. GUNUNG MAS'),
(6211, 62, 'KAB. PULANG PISAU'),
(6212, 62, 'KAB. MURUNG RAYA'),
(6213, 62, 'KAB. BARITO TIMUR'),
(6271, 62, 'KOTA PALANGKARAYA'),
(6301, 63, 'KAB. TANAH LAUT'),
(6302, 63, 'KAB. KOTABARU'),
(6303, 63, 'KAB. BANJAR'),
(6304, 63, 'KAB. BARITO KUALA'),
(6305, 63, 'KAB. TAPIN'),
(6306, 63, 'KAB. HULU SUNGAI SELATAN'),
(6307, 63, 'KAB. HULU SUNGAI TENGAH'),
(6308, 63, 'KAB. HULU SUNGAI UTARA'),
(6309, 63, 'KAB. TABALONG'),
(6310, 63, 'KAB. TANAH BUMBU'),
(6311, 63, 'KAB. BALANGAN'),
(6371, 63, 'KOTA BANJARMASIN'),
(6372, 63, 'KOTA BANJARBARU'),
(6401, 64, 'KAB. PASER'),
(6402, 64, 'KAB. KUTAI KARTANEGARA'),
(6403, 64, 'KAB. BERAU'),
(6407, 64, 'KAB. KUTAI BARAT'),
(6408, 64, 'KAB. KUTAI TIMUR'),
(6409, 64, 'KAB. PENAJAM PASER UTARA'),
(6411, 64, 'KAB. MAHAKAM ULU'),
(6471, 64, 'KOTA BALIKPAPAN'),
(6472, 64, 'KOTA SAMARINDA'),
(6474, 64, 'KOTA BONTANG'),
(6501, 65, 'KAB. BULUNGAN'),
(6502, 65, 'KAB. MALINAU'),
(6503, 65, 'KAB. NUNUKAN'),
(6504, 65, 'KAB. TANA TIDUNG'),
(6571, 65, 'KOTA TARAKAN'),
(7101, 71, 'KAB. BOLAANG MONGONDOW'),
(7102, 71, 'KAB. MINAHASA'),
(7103, 71, 'KAB. KEPULAUAN SANGIHE'),
(7104, 71, 'KAB. KEPULAUAN TALAUD'),
(7105, 71, 'KAB. MINAHASA SELATAN'),
(7106, 71, 'KAB. MINAHASA UTARA'),
(7107, 71, 'KAB. MINAHASA TENGGARA'),
(7108, 71, 'KAB. BOLAANG MONGONDOW UTARA'),
(7109, 71, 'KAB. KEP. SIAU TAGULANDANG BIARO'),
(7110, 71, 'KAB. BOLAANG MONGONDOW TIMUR'),
(7111, 71, 'KAB. BOLAANG MONGONDOW SELATAN'),
(7171, 71, 'KOTA MANADO'),
(7172, 71, 'KOTA BITUNG'),
(7173, 71, 'KOTA TOMOHON'),
(7174, 71, 'KOTA KOTAMOBAGU'),
(7201, 72, 'KAB. BANGGAI'),
(7202, 72, 'KAB. POSO'),
(7203, 72, 'KAB. DONGGALA'),
(7204, 72, 'KAB. TOLI TOLI'),
(7205, 72, 'KAB. BUOL'),
(7206, 72, 'KAB. MOROWALI'),
(7207, 72, 'KAB. BANGGAI KEPULAUAN'),
(7208, 72, 'KAB. PARIGI MOUTONG'),
(7209, 72, 'KAB. TOJO UNA UNA'),
(7210, 72, 'KAB. SIGI'),
(7211, 72, 'KAB. BANGGAI LAUT'),
(7212, 72, 'KAB. MOROWALI UTARA'),
(7271, 72, 'KOTA PALU'),
(7301, 73, 'KAB. KEPULAUAN SELAYAR'),
(7302, 73, 'KAB. BULUKUMBA'),
(7303, 73, 'KAB. BANTAENG'),
(7304, 73, 'KAB. JENEPONTO'),
(7305, 73, 'KAB. TAKALAR'),
(7306, 73, 'KAB. GOWA'),
(7307, 73, 'KAB. SINJAI'),
(7308, 73, 'KAB. BONE'),
(7309, 73, 'KAB. MAROS'),
(7310, 73, 'KAB. PANGKAJENE KEPULAUAN'),
(7311, 73, 'KAB. BARRU'),
(7312, 73, 'KAB. SOPPENG'),
(7313, 73, 'KAB. WAJO'),
(7314, 73, 'KAB. SIDENRENG RAPPANG'),
(7315, 73, 'KAB. PINRANG'),
(7316, 73, 'KAB. ENREKANG'),
(7317, 73, 'KAB. LUWU'),
(7318, 73, 'KAB. TANA TORAJA'),
(7322, 73, 'KAB. LUWU UTARA'),
(7324, 73, 'KAB. LUWU TIMUR'),
(7326, 73, 'KAB. TORAJA UTARA'),
(7371, 73, 'KOTA MAKASSAR'),
(7372, 73, 'KOTA PARE PARE'),
(7373, 73, 'KOTA PALOPO'),
(7401, 74, 'KAB. KOLAKA'),
(7402, 74, 'KAB. KONAWE'),
(7403, 74, 'KAB. MUNA'),
(7404, 74, 'KAB. BUTON'),
(7405, 74, 'KAB. KONAWE SELATAN'),
(7406, 74, 'KAB. BOMBANA'),
(7407, 74, 'KAB. WAKATOBI'),
(7408, 74, 'KAB. KOLAKA UTARA'),
(7409, 74, 'KAB. KONAWE UTARA'),
(7410, 74, 'KAB. BUTON UTARA'),
(7411, 74, 'KAB. KOLAKA TIMUR'),
(7412, 74, 'KAB. KONAWE KEPULAUAN'),
(7413, 74, 'KAB. MUNA BARAT'),
(7414, 74, 'KAB. BUTON TENGAH'),
(7415, 74, 'KAB. BUTON SELATAN'),
(7471, 74, 'KOTA KENDARI'),
(7472, 74, 'KOTA BAU BAU'),
(7501, 75, 'KAB. GORONTALO'),
(7502, 75, 'KAB. BOALEMO'),
(7503, 75, 'KAB. BONE BOLANGO'),
(7504, 75, 'KAB. POHUWATO'),
(7505, 75, 'KAB. GORONTALO UTARA'),
(7571, 75, 'KOTA GORONTALO'),
(7601, 76, 'KAB. PASANGKAYU'),
(7602, 76, 'KAB. MAMUJU'),
(7603, 76, 'KAB. MAMASA'),
(7604, 76, 'KAB. POLEWALI MANDAR'),
(7605, 76, 'KAB. MAJENE'),
(7606, 76, 'KAB. MAMUJU TENGAH'),
(8101, 81, 'KAB. MALUKU TENGAH'),
(8102, 81, 'KAB. MALUKU TENGGARA'),
(8103, 81, 'KAB. KEPULAUAN TANIMBAR'),
(8104, 81, 'KAB. BURU'),
(8105, 81, 'KAB. SERAM BAGIAN TIMUR'),
(8106, 81, 'KAB. SERAM BAGIAN BARAT'),
(8107, 81, 'KAB. KEPULAUAN ARU'),
(8108, 81, 'KAB. MALUKU BARAT DAYA'),
(8109, 81, 'KAB. BURU SELATAN'),
(8171, 81, 'KOTA AMBON'),
(8172, 81, 'KOTA TUAL'),
(8201, 82, 'KAB. HALMAHERA BARAT'),
(8202, 82, 'KAB. HALMAHERA TENGAH'),
(8203, 82, 'KAB. HALMAHERA UTARA'),
(8204, 82, 'KAB. HALMAHERA SELATAN'),
(8205, 82, 'KAB. KEPULAUAN SULA'),
(8206, 82, 'KAB. HALMAHERA TIMUR'),
(8207, 82, 'KAB. PULAU MOROTAI'),
(8208, 82, 'KAB. PULAU TALIABU'),
(8271, 82, 'KOTA TERNATE'),
(8272, 82, 'KOTA TIDORE KEPULAUAN'),
(9103, 91, 'KAB. JAYAPURA'),
(9105, 91, 'KAB. KEPULAUAN YAPEN'),
(9106, 91, 'KAB. BIAK NUMFOR'),
(9110, 91, 'KAB. SARMI'),
(9111, 91, 'KAB. KEEROM'),
(9115, 91, 'KAB. WAROPEN'),
(9119, 91, 'KAB. SUPIORI'),
(9120, 91, 'KAB. MAMBERAMO RAYA'),
(9171, 91, 'KOTA JAYAPURA'),
(9201, 92, 'KAB. SORONG'),
(9202, 92, 'KAB. MANOKWARI'),
(9203, 92, 'KAB. FAK FAK'),
(9204, 92, 'KAB. SORONG SELATAN'),
(9205, 92, 'KAB. RAJA AMPAT'),
(9206, 92, 'KAB. TELUK BINTUNI'),
(9207, 92, 'KAB. TELUK WONDAMA'),
(9208, 92, 'KAB. KAIMANA'),
(9209, 92, 'KAB. TAMBRAUW'),
(9210, 92, 'KAB. MAYBRAT'),
(9211, 92, 'KAB. MANOKWARI SELATAN'),
(9212, 92, 'KAB. PEGUNUNGAN ARFAK'),
(9271, 92, 'KOTA SORONG'),
(9301, 93, 'KAB. MERAUKE'),
(9302, 93, 'KAB. BOVEN DIGOEL'),
(9303, 93, 'KAB. MAPPI'),
(9304, 93, 'KAB. ASMAT'),
(9401, 94, 'KAB. NABIRE'),
(9402, 94, 'KAB. PUNCAK JAYA'),
(9403, 94, 'KAB. PANIAI'),
(9404, 94, 'KAB. MIMIKA'),
(9405, 94, 'KAB. PUNCAK'),
(9406, 94, 'KAB. DOGIYAI'),
(9407, 94, 'KAB. INTAN JAYA'),
(9408, 94, 'KAB. DEIYAI'),
(9501, 95, 'KAB. JAYAWIJAYA'),
(9502, 95, 'KAB. PEGUNUNGAN BINTANG'),
(9503, 95, 'KAB. YAHUKIMO'),
(9504, 95, 'KAB. TOLIKARA'),
(9505, 95, 'KAB. MAMBERAMO TENGAH'),
(9506, 95, 'KAB. YALIMO'),
(9507, 95, 'KAB. LANNY JAYA'),
(9508, 95, 'KAB. NDUGA');

-- --------------------------------------------------------

--
-- Table structure for table `keterangan_tambahan`
--

CREATE TABLE `keterangan_tambahan` (
  `id_keterangan` int(11) NOT NULL,
  `alumni_id` int(11) DEFAULT NULL,
  `bergabung_komunitas` tinyint(1) DEFAULT NULL,
  `partisipasi_kegiatan` tinyint(1) DEFAULT NULL,
  `saran_masukan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keterangan_tambahan`
--

INSERT INTO `keterangan_tambahan` (`id_keterangan`, `alumni_id`, `bergabung_komunitas`, `partisipasi_kegiatan`, `saran_masukan`) VALUES
(1, 1, 1, 1, 'swefh aoufygqwoufgq '),
(3, 3, 0, 0, 'SDLKFUGEOSW FEFG FU EWGT'),
(4, 9, 1, 0, 'uiywgd'),
(5, 10, 1, 0, 'uiywgd'),
(6, 14, 0, 1, 'wef3et3'),
(7, 15, 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) UNSIGNED NOT NULL,
  `slug` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `slug`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'berita-pertama', 'Berita Pertama', '<p>Ini adalah isi berita pertama.</p>', '2025-04-29 09:44:42', '2025-04-29 09:44:42'),
(2, 'berita-kedua', 'Berita Kedua', '<p>Ini adalah isi berita kedua.</p>', '2025-04-29 09:44:42', '2025-04-29 09:44:42'),
(3, 'berita-ketiga', 'Berita Ketiga', '<p>Ini adalah isi berita ketiga.</p>', '2025-04-29 09:44:42', '2025-04-29 09:44:42'),
(4, 'berita-keempat', 'Berita Keempat', '<p>Ini adalah isi berita keempat.</p>', '2025-04-29 09:44:42', '2025-04-29 09:44:42'),
(5, 'berita-kelima', 'Berita Kelima', '<p>Ini adalah isi berita kelima.</p>', '2025-04-29 09:44:42', '2025-04-29 09:44:42');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) UNSIGNED NOT NULL,
  `slug` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'home', 'Halaman Utama', '<p>Selamat datang di website kami!</p>', '2025-04-29 09:16:07', '2025-04-29 09:16:07'),
(2, 'about', 'Tentang Kami', '<p>Ini adalah halaman tentang kami.</p>', '2025-04-29 09:16:07', '2025-04-29 09:16:07'),
(4, 'qawkdljbhwq-lawgd', 'qawkdljbhwq lawgd ', 'worfhwpieufhweip ufweouyfg weoufygwe oufygwe ou fewuoyg fweu', '2025-04-29 10:35:22', '2025-04-29 10:35:22'),
(5, 'wfuh-weiufg-weoiuf-gewou-g', 'wfuh weiufg weoiuf gewou g', '<p>sefn ebf`&nbsp;</p>\r\n<p>se;foi <strong>ewifuh ewp </strong>fy</p>', '2025-04-29 14:12:07', '2025-04-29 14:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id_pekerjaan` int(11) NOT NULL,
  `id_ref_pekerjaan` int(11) NOT NULL,
  `alumni_id` int(11) DEFAULT NULL,
  `nama_perusahaan` varchar(255) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `alamat_kantor` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pekerjaan`
--

INSERT INTO `pekerjaan` (`id_pekerjaan`, `id_ref_pekerjaan`, `alumni_id`, `nama_perusahaan`, `jabatan`, `alamat_kantor`) VALUES
(1, 0, 1, 'Pemkab Sinjai', 'Pranata komputer', 'Jl. Persatuan raya No. 101 Sinjai'),
(3, 0, 3, 'qwdejqwdjkh', 'ahwdgwuy', 'akjwdqiwu'),
(4, 4, 9, 'eswkfdugu ', 'wefg', 'uywdt qyt'),
(5, 4, 10, 'eswkfdugu ', 'wefg', 'uywdt qyt'),
(6, 1017, 14, 'Pemkab Sinjai', ';fh', ';oiefhpieu pwiuyd '),
(7, 1055, 15, 'jkshbfkweu fg', 'kugduwe duiy', 'skueyfsueygf euy');

-- --------------------------------------------------------

--
-- Table structure for table `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id_pendidikan` int(11) NOT NULL,
  `alumni_id` int(11) DEFAULT NULL,
  `tahun_masuk` year(4) DEFAULT NULL,
  `angkatan` year(4) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendidikan`
--

INSERT INTO `pendidikan` (`id_pendidikan`, `alumni_id`, `tahun_masuk`, `angkatan`, `jurusan`) VALUES
(1, 1, 1993, 1996, 'Fisika'),
(3, 3, 1965, 1977, 'Biologi'),
(4, 9, 1966, 1969, 'IPA'),
(5, 10, 1966, 1969, 'IPS'),
(9, 14, NULL, 1993, 'Biologi'),
(10, 15, NULL, 1981, 'Ilmu Sosial');

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id_provinsi` int(11) NOT NULL,
  `nama_provinsi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`id_provinsi`, `nama_provinsi`) VALUES
(11, 'ACEH'),
(12, 'SUMATERA UTARA'),
(13, 'SUMATERA BARAT'),
(14, 'RIAU'),
(15, 'JAMBI'),
(16, 'SUMATERA SELATAN'),
(17, 'BENGKULU'),
(18, 'LAMPUNG'),
(19, 'KEPULAUAN BANGKA BELITUNG'),
(21, 'KEPULAUAN RIAU'),
(31, 'DKI JAKARTA'),
(32, 'JAWA BARAT'),
(33, 'JAWA TENGAH'),
(34, 'DAERAH ISTIMEWA YOGYAKARTA'),
(35, 'JAWA TIMUR'),
(36, 'BANTEN'),
(51, 'BALI'),
(52, 'NUSA TENGGARA BARAT'),
(53, 'NUSA TENGGARA TIMUR'),
(61, 'KALIMANTAN BARAT'),
(62, 'KALIMANTAN TENGAH'),
(63, 'KALIMANTAN SELATAN'),
(64, 'KALIMANTAN TIMUR'),
(65, 'KALIMANTAN UTARA'),
(71, 'SULAWESI UTARA'),
(72, 'SULAWESI TENGAH'),
(73, 'SULAWESI SELATAN'),
(74, 'SULAWESI TENGGARA'),
(75, 'GORONTALO'),
(76, 'SULAWESI BARAT'),
(81, 'MALUKU'),
(82, 'MALUKU UTARA'),
(91, 'PAPUA'),
(92, 'PAPUA BARAT'),
(93, 'PAPUA SELATAN'),
(94, 'PAPUA TENGAH'),
(95, 'PAPUA PEGUNUNGAN');

-- --------------------------------------------------------

--
-- Table structure for table `ref_pekerjaan`
--

CREATE TABLE `ref_pekerjaan` (
  `id_ref_pekerjaan` int(11) NOT NULL,
  `nama_pekerjaan` varchar(100) NOT NULL,
  `grup_pekerjaan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_pekerjaan`
--

INSERT INTO `ref_pekerjaan` (`id_ref_pekerjaan`, `nama_pekerjaan`, `grup_pekerjaan`) VALUES
(1000, 'Dokter', 'Profesi Kesehatan'),
(1001, 'Dokter Gigi', 'Profesi Kesehatan'),
(1002, 'Perawat', 'Profesi Kesehatan'),
(1003, 'Apoteker', 'Profesi Kesehatan'),
(1004, 'Bidan', 'Profesi Kesehatan'),
(1005, 'Ahli Gizi', 'Profesi Kesehatan'),
(1006, 'Terapis Fisik', 'Profesi Kesehatan'),
(1007, 'Radiografer', 'Profesi Kesehatan'),
(1008, 'Guru', 'Profesi Pendidikan'),
(1009, 'Dosen', 'Profesi Pendidikan'),
(1010, 'Pengawas Sekolah', 'Profesi Pendidikan'),
(1011, 'Konselor Pendidikan', 'Profesi Pendidikan'),
(1012, 'Insinyur Sipil', 'Profesi Teknik'),
(1013, 'Insinyur Elektro', 'Profesi Teknik'),
(1014, 'Teknisi Mesin', 'Profesi Teknik'),
(1015, 'Arsitek', 'Profesi Teknik'),
(1016, 'Staf Administrasi', 'Profesi Administrasi'),
(1017, 'Sekretaris', 'Profesi Administrasi'),
(1018, 'Manajer Proyek', 'Profesi Administrasi'),
(1019, 'HRD', 'Profesi Administrasi'),
(1020, 'Desainer Grafis', 'Profesi Kreatif'),
(1021, 'Penulis', 'Profesi Kreatif'),
(1022, 'Fotografer', 'Profesi Kreatif'),
(1023, 'Animator', 'Profesi Kreatif'),
(1024, 'Programmer', 'Profesi IT'),
(1025, 'Analis Sistem', 'Profesi IT'),
(1026, 'Administrator Jaringan', 'Profesi IT'),
(1027, 'Spesialis Keamanan Siber', 'Profesi IT'),
(1028, 'Akuntan', 'Profesi Keuangan'),
(1029, 'Auditor', 'Profesi Keuangan'),
(1030, 'Analis Keuangan', 'Profesi Keuangan'),
(1031, 'Perencana Keuangan', 'Profesi Keuangan'),
(1032, 'Pengacara', 'Profesi Hukum'),
(1033, 'Notaris', 'Profesi Hukum'),
(1034, 'Paralegal', 'Profesi Hukum'),
(1035, 'Hakim', 'Profesi Hukum'),
(1036, 'PNS', 'Pegawai Pemerintahan'),
(1037, 'Polisi', 'Profesi Kepolisian / TNI'),
(1041, 'TNI', 'Profesi Kepolisian / TNI'),
(1044, 'Bupati / Walikota / Wakil Bupati / Wakil Walikota', 'Pejabat Publik / Politik'),
(1045, 'Gubernur / Wakil Gubernur', 'Pejabat Publik / Politik'),
(1046, 'Anggota DPR', 'Pejabat Publik / Politik'),
(1047, 'Menteri', 'Pejabat Publik / Politik'),
(1048, 'Ibu Rumah Tangga', 'Pekerjaan Rumah Tangga / Informal'),
(1049, 'Pengurus Rumah Tangga', 'Pekerjaan Rumah Tangga / Informal'),
(1050, 'Pekerja Lepas Non-Formal', 'Pekerjaan Rumah Tangga / Informal'),
(1051, 'Petani', 'Profesi Pertanian'),
(1052, 'Peternak', 'Profesi Pertanian'),
(1053, 'Pengusaha', 'Profesi Bisnis'),
(1054, 'Wiraswasta', 'Profesi Bisnis'),
(1055, 'PPPK', 'Pegawai Pemerintahan'),
(1056, 'Non ASN', 'Pegawai Pemerintahan');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `nama_role`) VALUES
(1, 'admin'),
(2, 'admin_angkatan'),
(3, 'guest'),
(5, 'alumni');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `alumni_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `password_hash`, `email`, `role_id`, `created_at`, `updated_at`, `alumni_id`) VALUES
(1, '$2y$10$zAyH/Le6.78rjrXNmwnHKecmqctb.NdHiHx1mFIbZLSQNoGXIVU0K', 'uttibatu@gmail.com', 1, '2025-04-28 13:30:13', '2025-04-29 13:50:26', 1),
(3, '$2y$10$h03xQPyspO7PEfi8y.VwJe9CcCih.Z9lI4IcTdETBXSeB13lNP0RW', 'ksjdnhasjkh@hhj.com', 2, '2025-04-29 05:11:21', '2025-04-29 05:11:21', 3),
(4, '$2y$10$Vp73q8b/hLYAzsUZD57O2OER2DjoRdK4rpL6ZBMwLx584aro5lP26', 'hghwsdf@uhgd.com', 2, '2025-04-29 05:54:22', '2025-04-29 05:54:22', 9),
(5, '$2y$10$BgOSeIoGKMKfRFWqCw62D.eFW4EvC.abGCKPssWg0fcIk0VOKT1rq', 'hghwsdf@uhgd.com', 2, '2025-04-29 05:59:18', '2025-04-29 05:59:18', 10),
(6, '$2y$10$2iV45NxjxSx1F6p2G.kh8eBG/4lbwV61Z1mBWpQmt3Mlog7RhCiMS', 'alumnismansa277@gmail.com', 2, '2025-05-01 13:05:01', '2025-05-01 13:05:01', 14),
(7, '$2y$10$fQboxoDJ/fzo/wegPYw.H.vgyyRpnaSH9nCmhL9ruFDVWa7cHa/bS', 'uttibatu1@gmail.com', 5, '2025-05-01 17:00:44', '2025-05-01 17:00:44', 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id_alumni`),
  ADD UNIQUE KEY `referral` (`referral`),
  ADD KEY `provinsi_id` (`provinsi_id`),
  ADD KEY `kabupaten_id` (`kabupaten_id`);

--
-- Indexes for table `kabupaten`
--
ALTER TABLE `kabupaten`
  ADD PRIMARY KEY (`id_kabupaten`),
  ADD KEY `id_provinsi` (`id_provinsi`);

--
-- Indexes for table `keterangan_tambahan`
--
ALTER TABLE `keterangan_tambahan`
  ADD PRIMARY KEY (`id_keterangan`),
  ADD KEY `alumni_id` (`alumni_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`),
  ADD KEY `alumni_id` (`alumni_id`);

--
-- Indexes for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`),
  ADD KEY `alumni_id` (`alumni_id`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id_provinsi`);

--
-- Indexes for table `ref_pekerjaan`
--
ALTER TABLE `ref_pekerjaan`
  ADD PRIMARY KEY (`id_ref_pekerjaan`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `fk_alumni_user` (`alumni_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id_alumni` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `keterangan_tambahan`
--
ALTER TABLE `keterangan_tambahan`
  MODIFY `id_keterangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `id_pekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `id_pendidikan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ref_pekerjaan`
--
ALTER TABLE `ref_pekerjaan`
  MODIFY `id_ref_pekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1057;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni`
--
ALTER TABLE `alumni`
  ADD CONSTRAINT `alumni_ibfk_1` FOREIGN KEY (`provinsi_id`) REFERENCES `provinsi` (`id_provinsi`),
  ADD CONSTRAINT `alumni_ibfk_2` FOREIGN KEY (`kabupaten_id`) REFERENCES `kabupaten` (`id_kabupaten`);

--
-- Constraints for table `kabupaten`
--
ALTER TABLE `kabupaten`
  ADD CONSTRAINT `kabupaten_ibfk_1` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id_provinsi`);

--
-- Constraints for table `keterangan_tambahan`
--
ALTER TABLE `keterangan_tambahan`
  ADD CONSTRAINT `keterangan_tambahan_ibfk_1` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id_alumni`);

--
-- Constraints for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD CONSTRAINT `pekerjaan_ibfk_1` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id_alumni`);

--
-- Constraints for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD CONSTRAINT `pendidikan_ibfk_1` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id_alumni`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_alumni_user` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id_alumni`),
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
