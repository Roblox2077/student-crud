<?php
/**
 * edit.php — หน้าแก้ไขข้อมูลนักศึกษา (UPDATE)
 * 
 * รับ id ผ่าน GET เพื่อโหลดข้อมูลเดิมมาแสดงในฟอร์ม
 * เมื่อกด submit จะ validate แล้วอัปเดตด้วย Prepared Statement
 */

// เชื่อมต่อฐานข้อมูล
require_once 'config/db.php';

// รับ id จาก URL — ถ้าไม่มีให้กลับหน้าหลัก
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: index.php');
    exit;
}

// ดึงข้อมูลนักศึกษาตาม id
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
$stmt->execute([':id' => (int) $id]);
$student = $stmt->fetch();

// ถ้าไม่พบข้อมูล ให้กลับหน้าหลัก
if (!$student) {
    header('Location: index.php');
    exit;
}

// ตัวแปรเก็บข้อผิดพลาดและข้อมูลจากฟอร์ม (ใช้ค่าจาก DB เป็นค่าเริ่มต้น)
$errors = [];
$student_id = $student['student_id'];
$first_name = $student['first_name'];
$last_name  = $student['last_name'];
$major      = $student['major'];
$year       = $student['year'];

// ตรวจสอบว่ามีการส่งฟอร์มมาหรือไม่ (POST method)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // รับค่าจากฟอร์มและตัดช่องว่างหัวท้าย
    $student_id = trim($_POST['student_id'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name']  ?? '');
    $major      = trim($_POST['major']      ?? '');
    $year       = trim($_POST['year']       ?? '');

    // ===== Validation (ตรวจสอบข้อมูล) =====

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

    // ตรวจว่ารหัสนักศึกษาไม่ซ้ำกับคนอื่น (ยกเว้นตัวเอง)
    if (empty($errors)) {
        $check = $pdo->prepare("SELECT COUNT(*) FROM students WHERE student_id = :student_id AND id != :id");
        $check->execute([':student_id' => $student_id, ':id' => (int) $id]);
        if ($check->fetchColumn() > 0) {
            $errors[] = 'รหัสนักศึกษานี้มีคนอื่นใช้อยู่แล้ว';
        }
    }

    // ===== ถ้าไม่มี error ให้อัปเดตข้อมูล =====
    if (empty($errors)) {
        $sql = "UPDATE students 
                SET student_id = :student_id, 
                    first_name = :first_name, 
                    last_name  = :last_name, 
                    major      = :major, 
                    year       = :year 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':student_id' => $student_id,
            ':first_name' => $first_name,
            ':last_name'  => $last_name,
            ':major'      => $major,
            ':year'       => (int) $year,
            ':id'         => (int) $id,
        ]);

        // อัปเดตสำเร็จ — redirect กลับหน้าหลักพร้อมข้อความแจ้ง
        header('Location: index.php?msg=updated');
        exit;
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2 class="mb-3">✏️ แก้ไขข้อมูลนักศึกษา</h2>

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

<!-- ฟอร์มแก้ไขข้อมูล -->
<form method="POST" action="edit.php?id=<?= htmlspecialchars($id) ?>">
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
        <button type="submit" class="btn btn-primary">💾 บันทึกการแก้ไข</button>
        <a href="index.php" class="btn btn-secondary">↩️ ยกเลิก</a>
    </div>
</form>

<?php include 'includes/footer.php'; ?>
