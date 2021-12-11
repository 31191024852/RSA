-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 11, 2021 lúc 04:54 PM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `rsa`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_users`
--

CREATE TABLE `tbl_users` (
  `Id` int(11) NOT NULL,
  `HoTen` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Private` text NOT NULL,
  `Public` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tbl_users`
--

INSERT INTO `tbl_users` (`Id`, `HoTen`, `Email`, `Password`, `Private`, `Public`) VALUES
(29, 'Lâm Anh Tuấn', 'lamanhtuan@gmail.com', '202cb962ac59075b964b07152d234b70', '781e5e245d69b566979b86e28d23f2c7', 'a567d260dcce27322dc9403161f8ab91'),
(30, 'Phan Duy Tân', 'phanduytan@gmail.com', '202cb962ac59075b964b07152d234b70', '8c3f19d9a36bab315cea7830f6a2ebf0', '66854ca5769479268131dd1fd7fc2bf9'),
(31, 'Dương Kha Toàn', 'duongkhatoan@gmail.com', '202cb962ac59075b964b07152d234b70', 'f5bb0c8de146c67b44babbf4e6584cc0', '894c925e9616baf4484f6fccbf9013c0'),
(32, 'Hà Văn Tiến', 'havantien@gmail.com', '202cb962ac59075b964b07152d234b70', 'bb2d91d0fbbebe8719509ed0f865c63f', '730de40339fd44e1fd6fb08fbb37bfe8'),
(33, 'Đào Duy Tân', 'daoduythanh@gmail.com', '202cb962ac59075b964b07152d234b70', 'ed2b1f468c5f915f3f1cf75d7068baae', '1b2b1c1b9a4f61971e9332ba3772cdd8');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
