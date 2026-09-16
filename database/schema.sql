-- =======================================================
-- สคริปต์สร้างฐานข้อมูลและตารางสำหรับระบบจัดการข้อมูลนักศึกษา
-- Student Management System (Educational CRUD Project)
-- =======================================================

-- 1. สร้างฐานข้อมูล student_db (หากยังไม่มี)
CREATE DATABASE IF NOT EXISTS `student_db` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `student_db`;

-- 2. สร้างตาราง students
DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
    `id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'รหัสลำดับอัตโนมัติ (Primary Key)',
    `student_id` VARCHAR(10) NOT NULL UNIQUE COMMENT 'รหัสนักศึกษา เช่น 65010001 (ห้ามซ้ำ)',
    `first_name` VARCHAR(100) NOT NULL COMMENT 'ชื่อจริง',
    `last_name` VARCHAR(100) NOT NULL COMMENT 'นามสกุล',
    `major` VARCHAR(100) NOT NULL COMMENT 'สาขาวิชา',
    `year` INT NOT NULL COMMENT 'ชั้นปีที่ศึกษา (1-4)',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'วันเวลาที่เพิ่มข้อมูล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. เพิ่มข้อมูลตัวอย่าง 5 รายการ
INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `major`, `year`) VALUES
('65010001', 'สมชาย', 'สายเรียนดี', 'เทคโนโลยีสารสนเทศ', 3),
('65010002', 'สมหญิง', 'จริงใจ', 'วิทยาการคอมพิวเตอร์', 3),
('66010003', 'ธนากร', 'พัฒนา', 'เทคโนโลยีสารสนเทศ', 2),
('64010004', 'กานดา', 'สุขสมบูรณ์', 'วิศวกรรมซอฟต์แวร์', 4),
('67010005', 'วีระ', 'ขยันยิ่ง', 'เทคโนโลยีสารสนเทศ', 1);
