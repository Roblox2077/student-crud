-- =====================================================
-- schema.sql — สร้างตาราง students พร้อมข้อมูลตัวอย่าง
-- ใช้สำหรับ import เข้า MySQL/MariaDB ผ่าน phpMyAdmin หรือ CLI
-- =====================================================

-- สร้างฐานข้อมูล (ถ้ายังไม่มี)
CREATE DATABASE IF NOT EXISTS student_crud
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

-- เลือกใช้ฐานข้อมูล
USE student_crud;

-- ลบตารางเก่า (ถ้ามี) แล้วสร้างใหม่
DROP TABLE IF EXISTS students;

-- สร้างตาราง students
CREATE TABLE students (
    id          INT AUTO_INCREMENT PRIMARY KEY   COMMENT 'รหัสอัตโนมัติ',
    student_id  VARCHAR(10)  NOT NULL UNIQUE     COMMENT 'รหัสนักศึกษา',
    first_name  VARCHAR(100) NOT NULL            COMMENT 'ชื่อ',
    last_name   VARCHAR(100) NOT NULL            COMMENT 'นามสกุล',
    major       VARCHAR(100) NOT NULL            COMMENT 'สาขาวิชา',
    year        INT          NOT NULL            COMMENT 'ชั้นปี (1-4)',
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP COMMENT 'วันเวลาที่สร้างรายการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- ข้อมูลตัวอย่าง 5 รายการ
-- =====================================================
INSERT INTO students (student_id, first_name, last_name, major, year) VALUES
('6501001', 'สมชาย',   'ใจดี',       'เทคโนโลยีสารสนเทศ',        3),
('6501002', 'สมหญิง',  'รักเรียน',    'เทคโนโลยีสารสนเทศ',        3),
('6501003', 'วิชัย',    'เก่งกาจ',    'วิทยาการคอมพิวเตอร์',       2),
('6501004', 'พรทิพย์',  'สว่างวงศ์',   'เทคโนโลยีสารสนเทศ',        3),
('6501005', 'อนุชา',   'มั่นคง',     'วิศวกรรมซอฟต์แวร์',         4);
