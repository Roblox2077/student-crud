<?php
/**
 * delete.php — ลบข้อมูลนักศึกษา (DELETE)
 * 
 * รับ id ผ่าน GET แล้วลบข้อมูลจากตาราง students
 * การยืนยันก่อนลบทำผ่าน JavaScript confirm() ที่หน้า index.php
 * หลังลบเสร็จจะ redirect กลับ index.php พร้อมข้อความแจ้ง
 */

// เชื่อมต่อฐานข้อมูล
require_once 'config/db.php';

// รับ id จาก URL — ถ้าไม่มีหรือไม่ใช่ตัวเลขให้กลับหน้าหลัก
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: index.php');
    exit;
}

// ตรวจสอบว่ามีนักศึกษา id นี้อยู่จริงหรือไม่
$check = $pdo->prepare("SELECT COUNT(*) FROM students WHERE id = :id");
$check->execute([':id' => (int) $id]);

if ($check->fetchColumn() == 0) {
    // ไม่พบข้อมูล — กลับหน้าหลัก
    header('Location: index.php');
    exit;
}

// ลบข้อมูลด้วย Prepared Statement
$stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
$stmt->execute([':id' => (int) $id]);

// ลบสำเร็จ — redirect กลับหน้าหลักพร้อมข้อความแจ้ง
header('Location: index.php?msg=deleted');
exit;
