CREATE DATABASE IF NOT EXISTS personal_gallery;
USE personal_gallery;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2026 at 08:34 PM
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
-- Database: `personal_gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `artworks`
--

CREATE TABLE `artworks` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artworks`
--

INSERT INTO `artworks` (`id`, `category_id`, `title`, `image_path`, `description`, `created_at`) VALUES
(3, NULL, 'Sepasang Merpati Putih', 'ART-6a20b98c646324.41561623.jpeg', 'Sepasang Merpati Putih adalah sebuah karya pertama yang mengikuti pameran di jogja, sebuah petualangan besar, di sejejarkan dengan lukisan lukisan indah yang di buat seniman seniman senior. Sepasang Merpati Putih bukan lahir untuk sebuah pameran. Ia lahir dari sebuah mimpi yang ingin kutitipkan pada masa depan.', '2026-06-03 23:32:28'),
(4, NULL, 'The King', 'ART-6a20c825324195.21591064.jpeg', 'The king adalah simbol tentang jiwa dan raga mahluk hidupThe King merupakan karya kedua yang mengikuti pameran di Yogyakarta. Karya ini menggabungkan wajah singa dan harimau sebagai simbol keseimbangan antara jiwa dan raga dalam setiap makhluk hidup.\r\n\r\nSinga melambangkan keberanian dan kewibawaan, sementara harimau melambangkan kekuatan dan keteguhan. Keduanya dipadukan menjadi satu untuk menggambarkan bahwa kehidupan tidak hanya tentang kekuatan fisik, tetapi juga tentang kekuatan batin yang membimbing setiap langkah.\r\n\r\nMelalui karya ini, saya ingin menyampaikan bahwa seorang \"raja\" sejati bukanlah yang mampu menguasai orang lain, melainkan yang mampu mengenali dan mengendalikan dirinya sendiri.', '2026-06-04 00:34:45'),
(5, NULL, 'Laskar Cinta', 'ART-6a20d0aee98936.67541941.jpeg', 'Laskar cinta tentang cinda dengan ornamen tulisLaskar Cinta adalah simbol tentang dua jiwa yang memilih berjalan bersama dalam setiap musim kehidupan. Sepasang bangau yang berdiri di bawah bunga sakura melambangkan kesetiaan, kebersamaan, dan keindahan cinta yang tumbuh melalui waktu. Melalui karya ini, saya ingin menggambarkan bahwa cinta sejati bukan hanya tentang perasaan, tetapi juga tentang ketulusan untuk tetap hadir dan saling menjaga dalam setiap langkah perjalanan hidup.an aksawra jawa', '2026-06-04 01:11:10'),
(6, NULL, 'Sunyi', 'ART-6a20d2dbc040e3.05982404.jpeg', 'Sunyi adalah gambaran tentang keindahan yang lahir dari kesendirian. Sosok merak putih yang berdiri sendiri melambangkan ketenangan, perenungan, dan proses mengenal diri di tengah hiruk-pikuk kehidupan. Melalui karya ini, saya ingin menunjukkan bahwa sunyi bukanlah sesuatu yang harus ditakuti, melainkan ruang untuk bertumbuh dan menemukan makna dalam diri sendiri.', '2026-06-04 01:20:27'),
(7, NULL, 'Di Ambang', 'ART-6a20d34b393592.47251062.jpeg', 'Di Ambang menggambarkan seseorang yang berada di antara dua ruang: kejujuran dan kepura-puraan, kenyataan dan harapan, diri yang terlihat dan diri yang tersembunyi. Topeng yang dipegang menjadi simbol berbagai peran yang sering dikenakan manusia untuk menyesuaikan diri dengan lingkungan dan tuntutan kehidupan.\r\n\r\nMelalui karya ini, saya ingin menggambarkan momen ketika seseorang berdiri di ambang sebuah keputusan: tetap bersembunyi di balik topeng atau berani memperlihatkan jati dirinya yang sesungguhnya. Sebab dalam perjalanan hidup, setiap orang pernah berada pada titik di mana mereka harus memilih antara menjadi apa yang diharapkan orang lain atau menjadi dirinya sendiri.\r\n\r\nDi Ambang adalah refleksi tentang pencarian identitas, keberanian menerima diri, dan langkah kecil menuju kejujuran yang paling dalam.', '2026-06-04 01:22:19'),
(8, NULL, 'Apa yang tersisa dari manusia selain perasaan?', 'ART-6a20d3a6e82880.73484773.jpeg', '', '2026-06-04 01:23:50'),
(9, NULL, 'Sebuah Gumaman', 'ART-6a20d3d2c098b9.98866819.jpeg', '', '2026-06-04 01:24:34');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` enum('art','writing') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_type` enum('art','writing') NOT NULL,
  `visitor_name` varchar(50) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `item_id`, `item_type`, `visitor_name`, `comment_text`, `created_at`) VALUES
(2, 1, 'art', 'aku', 'picaso keren', '2026-06-03 02:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Dicky Dermawan', 'dylandmwn@gmail.com', 'keren banget', '2026-06-03 02:03:25'),
(2, 'Dicky Dermawan', 'dylandmwn@gmail.com', 'keren banget', '2026-06-03 02:07:36'),
(3, 'Dicky Dermawan', 'dylandmwn@gmail.com', 'keren banget', '2026-06-03 02:11:17'),
(4, 'Dicky Dermawan', 'dylandmwn@gmail.com', 'haiii', '2026-06-03 02:11:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$CCIXxFOBP6G2qlb3eZ.jwOQK6XlpUFH3khabHI6vdM0Bg4omhvQRS');

-- --------------------------------------------------------

--
-- Table structure for table `writings`
--

CREATE TABLE `writings` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `mood` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `layout_mode` enum('single','book') DEFAULT 'single',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `writings`
--

INSERT INTO `writings` (`id`, `category_id`, `title`, `content`, `mood`, `created_at`, `layout_mode`, `image`) VALUES
(1, NULL, 'siapa aku', 'Aku adalah jelmaan dari raga seorang Ayah dan jiwa seorang Ibu', 'melankonis', '2026-06-03 00:57:16', 'single', NULL),
(4, NULL, 'Berikan Aku Kasihmu', 'Wahai puan, aku tergila dengan parasmu\r\nBagaimana bisa engkau tidak mengetahui itu-\r\nSedangakan aku selalu memandangi mu...', 'melankonis', '2026-06-03 02:29:06', 'single', NULL),
(5, NULL, 'Bandung  yang  Masih  Tinggal', 'Ada beberapa perjalanan yang tidak pernah benar-benar selesai. Tubuh kita memang pulang, waktu terus berjalan, tetapi sebagian dari diri kita tetap tertinggal di sana.\r\n\r\nBandung adalah salah satunya.\r\n\r\nSaat itu aku sedang mengejar sebuah mimpi. Aku ingin menjadi mahasiswa ISBI Bandung. Tidak ada waktu yang panjang untuk mempersiapkan semuanya. Hanya satu minggu. Tujuh hari yang terasa seperti perlombaan dengan waktu.\r\n\r\nDi ruang kecil tempatku bekerja, hari-hariku dipenuhi aroma cat dan tangan yang tak pernah benar-benar bersih. Aku menghabiskan waktu dari pagi hingga larut malam di depan sebuah kanvas, berusaha menyelesaikan portofolio yang akan kubawa ke Bandung. Sedikit demi sedikit, lukisan itu mulai menemukan bentuknya: sepasang merpati putih.\r\n\r\nAku memilih merpati bukan tanpa alasan. Bagiku, mereka adalah lambang ketenangan, kesetiaan, dan kebersamaan. Dua makhluk yang selalu tampak saling menemani dalam perjalanan hidupnya. Mungkin tanpa kusadari, saat itu aku sedang melukis sesuatu yang juga sedang kucari dalam hidupku sendiri.\r\n\r\nSetiap sapuan kuas terasa seperti harapan yang perlahan menemukan wujudnya. Kadang aku merasa yakin dengan hasilnya, kadang aku justru ingin mengulang semuanya dari awal. Namun waktu terus berjalan. Tenggat semakin dekat, sementara masih banyak bagian yang belum selesai.\r\n\r\nMalam terakhir sebelum keberangkatan menjadi malam yang panjang. Ketika kuletakkan kuas untuk terakhir kalinya, lukisan itu memang selesai, tetapi catnya masih basah.\r\n\r\nKeesokan harinya aku dan kakakku berangkat menuju Bandung menggunakan sepeda motor. Ia duduk di depan, aku di belakang, sementara lukisan yang dibalut plastik dan koran ikut menempuh perjalanan bersama kami.\r\n\r\nSepanjang jalan aku lebih sering memikirkan keadaan lukisan itu daripada diriku sendiri. Aku takut catnya rusak. Aku takut kanvasnya terlipat. Aku takut semua usaha selama seminggu berakhir sia-sia sebelum sampai tujuan.\r\n\r\nNamun lebih dari itu, ada satu ketakutan yang diam-diam kusimpan.\r\n\r\nBagaimana jika aku tidak cukup baik?\r\n\r\nMeski begitu, perjalanan terasa ringan. Mungkin karena aku membawa lebih dari sekadar lukisan. Aku membawa restu Mama. Aku membawa keyakinan Ayah. Aku membawa doa-doa yang diam-diam diselipkan oleh keluargaku sebelum keberangkatan. Dukungan mereka adalah bahan bakar yang membuatku terus percaya bahwa mimpi ini layak diperjuangkan.\r\n\r\nSesampainya di Bandung, lukisan itu akhirnya kuvernish. Aku masih ingat bagaimana rasanya berdiri di hadapannya saat itu. Untuk pertama kalinya aku melihatnya benar-benar selesai. Ada rasa bangga yang sulit dijelaskan. Bukan karena hasilnya sempurna, tetapi karena aku berhasil sampai sejauh itu.\r\n\r\nLalu hari pengumuman datang.\r\n\r\nAku tidak lolos.\r\n\r\nSederhana. Hanya beberapa kata yang cukup untuk meruntuhkan begitu banyak harapan yang kubangun selama berbulan-bulan.\r\n\r\nAku kecewa. Tentu saja. Siapa yang tidak kecewa ketika mimpi yang dikejar ternyata berhenti tepat di depan pintu?\r\n\r\nNamun hidup sering kali menulis ceritanya sendiri.\r\n\r\nSemakin bertambah usia, semakin aku menyadari bahwa perjalanan itu tidak pernah sia-sia. Ketika mengingat Bandung hari ini, yang muncul bukan rasa gagal.\r\n\r\nYang kuingat justru perjalanan itu.\r\n\r\nAku ingat jalanan panjang yang kami lewati bersama. Aku ingat lukisan yang masih basah di balik plastik dan koran. Aku ingat kakakku yang dengan sabar menemaniku. Aku ingat doa-doa yang mengiringi keberangkatan dari rumah. Aku ingat perasaan gugup, semangat, takut, dan bahagia yang bercampur menjadi satu.\r\n\r\nAku mulai mengerti bahwa tidak semua perjalanan diciptakan untuk mengantarkan kita pada tujuan yang kita inginkan.\r\n\r\nAda perjalanan yang diciptakan untuk mengajarkan keberanian.\r\n\r\nDan mungkin itulah yang diberikan Bandung kepadaku.\r\n\r\nAku memang tidak menjadi mahasiswa ISBI. Namun kota itu memberiku sesuatu yang lain: kenangan tentang bagaimana rasanya memperjuangkan mimpi dengan sungguh-sungguh.\r\n\r\nHari ini, ketika melihat ke belakang, aku tidak melihat kegagalan. Aku melihat seorang anak yang pernah begitu percaya pada mimpinya hingga berani membawa sebuah lukisan yang masih basah menembus ratusan kilometer jalan.\r\n\r\nDan mungkin, itulah alasan mengapa Bandung masih tinggal.\r\n\r\nKarena sebagian mimpi memang tidak ditakdirkan untuk menjadi kenyataan, tetapi tetap layak dikenang sebagai perjalanan yang indah.', 'romantic', '2026-06-03 23:37:10', 'single', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artworks`
--
ALTER TABLE `artworks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `writings`
--
ALTER TABLE `writings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artworks`
--
ALTER TABLE `artworks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `writings`
--
ALTER TABLE `writings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artworks`
--
ALTER TABLE `artworks`
  ADD CONSTRAINT `artworks_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `writings`
--
ALTER TABLE `writings`
  ADD CONSTRAINT `writings_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
