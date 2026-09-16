<?php
/**
 * ไฟล์: index.php
 * คำอธิบาย: หน้าหลัก — แสดงรายชื่อนักศึกษาทั้งหมดเป็นตาราง (READ)
 *           มีปุ่มเพิ่ม แก้ไข และลบ
 */

// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
require_once 'config/db.php';

// ดึงข้อมูลนักศึกษาทั้งหมด เรียงตาม id
$stmt = $pdo->query("SELECT * FROM students ORDER BY id ASC");
$students = $stmt->fetchAll();

// เรียกส่วนหัว
include 'includes/header.php';
?>

<!-- หัวข้อหน้า -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>📋 รายชื่อนักศึกษาทั้งหมด</h2>
    <a href="create.php" class="btn btn-success">➕ เพิ่มนักศึกษาใหม่</a>
</div>

<?php
// แสดงข้อความแจ้งเตือนจาก session (ถ้ามี) เช่น หลังเพิ่ม/แก้ไข/ลบ สำเร็จ
if (isset($_GET['msg'])) {
    // ป้องกัน XSS ด้วย htmlspecialchars
    $msg = htmlspecialchars($_GET['msg'], ENT_QUOTES, 'UTF-8');
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo $msg;
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
    echo '</div>';
}
?>

<?php if (count($students) > 0): ?>
    <!-- ตารางแสดงข้อมูลนักศึกษา -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>รหัสนักศึกษา</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>สาขาวิชา</th>
                    <th>ชั้นปี</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $index => $student): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['major']); ?></td>
                        <td><?php echo htmlspecialchars($student['year']); ?></td>
                        <td>
                            <!-- ปุ่มแก้ไข -->
                            <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-warning btn-sm">✏️ แก้ไข</a>
                            <!-- ปุ่มลบ (ยืนยันก่อนลบด้วย JavaScript confirm) -->
                            <a href="delete.php?id=<?php echo $student['id']; ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบนักศึกษาคนนี้?');">
                                🗑️ ลบ
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <!-- กรณีไม่มีข้อมูลนักศึกษา -->
    <div class="alert alert-info">
        ยังไม่มีข้อมูลนักศึกษา — <a href="create.php" class="alert-link">เพิ่มนักศึกษาคนแรก</a>
    </div>
<?php endif; ?>

<?php
// เรียกส่วนท้าย
include 'includes/footer.php';
?>
