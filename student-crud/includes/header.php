<?php
/**
 * ไฟล์: includes/header.php
 * คำอธิบาย: ส่วนหัวของทุกหน้า — มี HTML head, Bootstrap 5 CDN, และ navbar
 * วิธีใช้: include ไฟล์นี้ที่ด้านบนสุดของทุกหน้า
 */
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการนักศึกษา</title>
    <!-- Bootstrap 5 CSS จาก CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- แถบนำทาง (Navbar) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">📚 ระบบจัดการนักศึกษา</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">🏠 หน้าหลัก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create.php">➕ เพิ่มนักศึกษา</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- เนื้อหาหลัก -->
    <div class="container">
