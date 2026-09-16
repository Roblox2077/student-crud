<?php
/**
 * create.php — หน้าเพิ่มข้อมูลนักศึกษาใหม่ (CREATE)
 * 
 * แสดงฟอร์มสำหรับกรอกข้อมูล และ validate ข้อมูลฝั่ง server
 * ก่อนบันทึกลงฐานข้อมูลด้วย Prepared Statement
 */

// เชื่อมต่อฐานข้อมูล
require_once 'config/db.php';

// ตัวแปรเก็บข้อผิดพลาดและข้อมูลจากฟอร์ม
$errors = [];
$student_id = '';
$first_name = '';
$last_name  = '';
$major      = '';
$year       = '';

// ตรวจสอบว่ามีการส่งฟอร์มมาหรือไม่ (POST method)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // รับค่าจากฟอร์มและตัดช่องว่างหัวท้าย
    $student_id = trim($_POST['student_id'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name']  ?? '');
    $major      = trim($_POST['major']      ?? '');
    $year       = trim($_POST['year']       ?? '');

    // ===== Validation (ตรวจสอบข้อมูล) =====

    // ตรวจว่าไม่เว้นว่าง
    if ($student_id === '') {
        $errors[] = 'กรุณากรอกรหัสนักศึกษา';
    }
    if ($first_name === '') {
        $errors[] = 'กรุณากรอกชื่อ';
    }
    if ($last_name === '') {
        $errors[] = 'กรุณากรอกนามสกุล';
    }
    if ($major === '') {
        $errors[] = 'กรุณากรอกสาขาวิชา';
    }
    if ($year === '') {
        $errors[] = 'กรุณากรอกชั้นปี';
    }

    // ตรวจว่าชั้นปีเป็นตัวเลข 1-4
    if ($year !== '' && (!is_numeric($year) || $year < 1 || $year > 4)) {
        $errors[] = 'ชั้นปีต้องเป็นตัวเลข 1-4 เท่านั้น';
    }

    // ตรวจว่ารหัสนักศึกษาไม่ซ้ำ
    if (empty($errors)) {
        $check = $pdo->prepare("SELECT COUNT(*) FROM students WHERE student_id = :student_id");
        $check->execute([':student_id' => $student_id]);
        if ($check->fetchColumn() > 0) {
            $errors[] = 'รหัสนักศึกษานี้มีอยู่ในระบบแล้ว';
        }
    }

    // ===== ถ้าไม่มี error ให้บันทึกข้อมูล =====
    if (empty($errors)) {
        $sql = "INSERT INTO students (student_id, first_name, last_name, major, year) 
                VALUES (:student_id, :first_name, :last_name, :major, :year)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':student_id' => $student_id,
            ':first_name' => $first_name,
            ':last_name'  => $last_name,
            ':major'      => $major,
            ':year'       => (int) $year,
        ]);

        // บันทึกสำเร็จ — redirect กลับหน้าหลักพร้อมข้อความแจ้ง
        header('Location: index.php?msg=created');
        exit;
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2 class="mb-3">➕ เพิ่มนักศึกษาใหม่</h2>

<!-- แสดงข้อผิดพลาด (ถ้ามี) -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <strong>⚠️ พบข้อผิดพลาด:</strong>
        <ul class="mb-0 mt-2">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- ฟอร์มเพิ่มข้อมูล -->
<form method="POST" action="create.php">
    <div class="mb-3">
        <label for="student_id" class="form-label">รหัสนักศึกษา</label>
        <input type="text" class="form-control" id="student_id" name="student_id" 
               value="<?= htmlspecialchars($student_id) ?>" 
               placeholder="เช่น 6501001" maxlength="10" required>
    </div>

    <div class="mb-3">
        <label for="first_name" class="form-label">ชื่อ</label>
        <input type="text" class="form-control" id="first_name" name="first_name" 
               value="<?= htmlspecialchars($first_name) ?>" 
               placeholder="เช่น สมชาย" required>
    </div>

    <div class="mb-3">
        <label for="last_name" class="form-label">นามสกุล</label>
        <input type="text" class="form-control" id="last_name" name="last_name" 
               value="<?= htmlspecialchars($last_name) ?>" 
               placeholder="เช่น ใจดี" required>
    </div>

    <div class="mb-3">
        <label for="major" class="form-label">สาขาวิชา</label>
        <input type="text" class="form-control" id="major" name="major" 
               value="<?= htmlspecialchars($major) ?>" 
               placeholder="เช่น เทคโนโลยีสารสนเทศ" required>
    </div>

    <div class="mb-3">
        <label for="year" class="form-label">ชั้นปี</label>
        <select class="form-select" id="year" name="year" required>
            <option value="">-- เลือกชั้นปี --</option>
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <option value="<?= $i ?>" <?= ($year == $i) ? 'selected' : '' ?>>
                    ปี <?= $i ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">💾 บันทึก</button>
        <a href="index.php" class="btn btn-secondary">↩️ ยกเลิก</a>
    </div>
</form>

<?php include 'includes/footer.php'; ?>
