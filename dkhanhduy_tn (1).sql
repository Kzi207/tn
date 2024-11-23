-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th10 23, 2024 lúc 05:43 AM
-- Phiên bản máy phục vụ: 10.3.39-MariaDB-cll-lve
-- Phiên bản PHP: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `dkhanhduy_tn`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$23EaQQ0yiQ5TVWBN8JhKIu4ull6HcOf1zWYu1aGrYjYnOcDRpnXuW', 'admin'),
(2, 'kzi207', '$2y$10$5KQjeO8ErFBBnfd1NsHsiOcX6TzIN49p1.DUB8e9j9XcpVESOA2Xa', 'user'),
(5, 'khanhduy', '$2y$10$BdGClOD/g/.zaDzg7Ix8sufcfWw5FH4FSsj7im3KsonlDPclziKK.', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ykien`
--

CREATE TABLE `ykien` (
  `id` int(11) NOT NULL,
  `ma_ykien` varchar(10) NOT NULL,
  `noi_dung` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `ykien`
--

INSERT INTO `ykien` (`id`, `ma_ykien`, `noi_dung`, `created_at`) VALUES
(20, '#tl1', '#tl1 kzi', '2024-11-21 05:55:28'),
(25, '#tl25', '#tl25 kzi', '2024-11-21 06:19:13'),
(27, '#tl27', '#tl27 Kzi ', '2024-11-21 10:08:42'),
(28, '#tl28', '#tl28 Source code by kzi', '2024-11-21 13:55:09'),
(29, '#tl29', '#tl29 kziii', '2024-11-22 11:48:22'),
(30, '#tl30', '#tl30 fdsfdsf', '2024-11-22 11:53:40'),
(31, '#tl31', '#tl31 sÃ¢sasas', '2024-11-22 12:03:44'),
(32, '#tl32', '#tl32 Ã¢sasasas', '2024-11-22 12:04:12'),
(33, '#tl33', '#tl33 khanhduy', '2024-11-22 12:07:23'),
(34, '#tl34', '#tl34 dfsdfdsfds', '2024-11-22 12:25:09'),
(35, '#tl35', '#tl35 ffffffff', '2024-11-22 12:25:22'),
(36, '#tl36', '#tl36 kzidzkooooo', '2024-11-22 13:08:10'),
(37, '#tl37', '#tl37 iuuuu', '2024-11-22 13:21:59'),
(38, '#tl38', '#tl38 Kzii', '2024-11-23 02:56:37'),
(39, '#tl39', '#tl39 iu bÃ© HoÃ ng Oanh', '2024-11-23 05:39:38');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `ykien`
--
ALTER TABLE `ykien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_ykien` (`ma_ykien`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `ykien`
--
ALTER TABLE `ykien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
