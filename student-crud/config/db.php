<?php
/**
 * db.php — ไฟล์เชื่อมต่อฐานข้อมูล MySQL ด้วย PDO
 * 
 * วิธีใช้: ใส่ require_once 'config/db.php'; ในทุกไฟล์ที่ต้องการเชื่อมต่อ DB
 * ตัวแปร $pdo จะพร้อมใช้งานทันทีหลัง include
 */

// ตั้งค่าการเชื่อมต่อ — แก้ไขให้ตรงกับเครื่องของนักศึกษา
$host     = 'localhost';      // ชื่อ host (ปกติคือ localhost)
$dbname   = 'student_crud';   // ชื่อฐานข้อมูลที่สร้างจาก schema.sql
$username = 'root';           // username ของ MySQL (XAMPP ค่าเริ่มต้นคือ root)
$password = '';               // password ของ MySQL (XAMPP ค่าเริ่มต้นคือเว้นว่าง)
$charset  = 'utf8mb4';        // รองรับภาษาไทยและ emoji

// สร้าง DSN (Data Source Name) สำหรับ PDO
$dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";

// ตัวเลือก PDO — ตั้งค่าให้ปลอดภัยและใช้งานง่าย
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,    // แสดง error แบบ exception (ง่ายต่อการ debug)
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,          // ดึงข้อมูลเป็น associative array
    PDO::ATTR_EMULATE_PREPARES   => false,                     // ใช้ prepared statement จริง (ป้องกัน SQL Injection)
];

// พยายามเชื่อมต่อฐานข้อมูล
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // ถ้าเชื่อมต่อไม่ได้ ให้แสดงข้อความ error แล้วหยุดทำงาน
    die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . $e->getMessage());
}
