# 📚 ระบบจัดการนักศึกษา (Student CRUD System)

ระบบ CRUD สำหรับจัดการข้อมูลนักศึกษา พัฒนาด้วย PHP + MySQL (PDO) + Bootstrap 5  
เป็นโปรเจกต์ตัวอย่างสำหรับเรียนรู้การพัฒนาเว็บแอปพลิเคชันเบื้องต้น

## ✨ ฟีเจอร์

- **เพิ่ม (Create)** — เพิ่มข้อมูลนักศึกษาใหม่พร้อม validation
- **ดู (Read)** — แสดงรายชื่อนักศึกษาทั้งหมดเป็นตาราง
- **แก้ไข (Update)** — แก้ไขข้อมูลนักศึกษาที่มีอยู่
- **ลบ (Delete)** — ลบข้อมูลนักศึกษา (มีการยืนยันก่อนลบ)

## 🛠️ เทคโนโลยีที่ใช้

| เทคโนโลยี   | รายละเอียด                        |
|-------------|-----------------------------------|
| PHP 8.x     | ภาษาหลักฝั่ง server               |
| MySQL/MariaDB | ฐานข้อมูล                        |
| PDO         | เชื่อมต่อ DB (Prepared Statement) |
| Bootstrap 5 | CSS Framework (CDN)              |
| XAMPP/Laragon | สภาพแวดล้อมการพัฒนา              |

## 📁 โครงสร้างโปรเจกต์

```
student-crud/
├── config/
│   └── db.php              # เชื่อมต่อฐานข้อมูลด้วย PDO
├── database/
│   └── schema.sql           # คำสั่งสร้างตาราง + ข้อมูลตัวอย่าง
├── includes/
│   ├── header.php           # ส่วนหัว + navbar (Bootstrap)
│   └── footer.php           # ส่วนท้าย
├── index.php                # แสดงรายชื่อนักศึกษาทั้งหมด
├── create.php               # ฟอร์มเพิ่มนักศึกษาใหม่
├── edit.php                 # ฟอร์มแก้ไขข้อมูล
├── delete.php               # ลบข้อมูลนักศึกษา
├── .gitignore
└── README.md
```

## 🚀 วิธีติดตั้งและใช้งาน

### 1. ติดตั้ง XAMPP
ดาวน์โหลดและติดตั้ง [XAMPP](https://www.apachefriends.org/) แล้วเปิด **Apache** และ **MySQL**

### 2. คัดลอกโปรเจกต์
คัดลอกโฟลเดอร์โปรเจกต์นี้ไปไว้ที่ `C:\xampp\htdocs\student-crud\`

### 3. สร้างฐานข้อมูล
1. เปิด phpMyAdmin ที่ [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. คลิกแท็บ **Import**
3. เลือกไฟล์ `database/schema.sql`
4. คลิก **Go** เพื่อ import

หรือใช้คำสั่ง MySQL CLI:
```bash
mysql -u root < database/schema.sql
```

### 4. ตั้งค่าการเชื่อมต่อฐานข้อมูล
เปิดไฟล์ `config/db.php` แล้วแก้ไขค่าให้ตรงกับเครื่องของคุณ:
```php
$host     = 'localhost';
$dbname   = 'student_crud';
$username = 'root';        // แก้ตามเครื่อง
$password = '';            // แก้ตามเครื่อง
```

### 5. เปิดใช้งาน
เปิดเว็บเบราว์เซอร์แล้วไปที่:
```
http://localhost/student-crud/
```

## 🔒 ความปลอดภัย

- ใช้ **Prepared Statement (PDO)** ทุกจุดที่ query ฐานข้อมูล เพื่อป้องกัน SQL Injection
- ใช้ **htmlspecialchars()** ในการแสดงผลข้อมูล เพื่อป้องกัน XSS
- **Validate** ข้อมูลจากฟอร์มทุกครั้งก่อนบันทึก

## 👨‍🎓 สำหรับนักศึกษา

โปรเจกต์นี้เหมาะสำหรับเรียนรู้:
- พื้นฐาน PHP (ตัวแปร, เงื่อนไข, ลูป, ฟอร์ม)
- การเชื่อมต่อฐานข้อมูลด้วย PDO
- CRUD Operations (Create, Read, Update, Delete)
- การใช้ Bootstrap สร้าง UI
- ความปลอดภัยเบื้องต้น (SQL Injection, XSS)
