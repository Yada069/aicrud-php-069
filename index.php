<?php
/**
 * หน้าแสดงรายชื่อนักศึกษาทั้งหมด (READ)
 * ดึงข้อมูลจากฐานข้อมูลมาแสดงผลในรูปแบบตาราง Bootstrap
 */

// 1. นำเข้าไฟล์เชื่อมต่อฐานข้อมูล
require_once 'config/db.php';

// 2. ดึงข้อมูลนักศึกษาทั้งหมด โดยเรียงจากรายการล่าสุดก่อน (ใช้ Prepared Statement)
$sql = "SELECT * FROM students ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll();

// กำหนดหัวข้อหน้าเว็บ
$pageTitle = 'รายชื่อนักศึกษาทั้งหมด';
require_once 'includes/header.php';
?>

<!-- ส่วนแสดงการแจ้งเตือน (Flash Messages) -->
<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'created'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> เพิ่มข้อมูลนักศึกษาเรียบร้อยแล้ว!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['msg'] === 'updated'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> แก้ไขข้อมูลนักศึกษาเรียบร้อยแล้ว!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-trash-fill me-2"></i> ลบข้อมูลนักศึกษาเรียบร้อยแล้ว!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['msg'] === 'not_found'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> ไม่พบข้อมูลนักศึกษาที่ต้องการ
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['msg'] === 'error'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i> เกิดข้อผิดพลาดในการทำรายการ กรุณาลองใหม่อีกครั้ง
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- หัวข้อและปุ่มเพิ่มข้อมูล -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-people-fill text-primary me-2"></i>รายชื่อนักศึกษา
        </h2>
        <p class="text-muted mb-0">ระบบแสดงรายชื่อนักศึกษาทั้งหมดในระบบ (จำนวนทั้งหมด <?= count($students) ?> คน)</p>
    </div>
    <a href="create.php" class="btn btn-success d-inline-flex align-items-center gap-1 shadow-sm">
        <i class="bi bi-person-plus-fill"></i> เพิ่มนักศึกษาใหม่
    </a>
</div>

<!-- ตารางแสดงข้อมูลนักศึกษา -->
<div class="card shadow-sm">
    <div class="card-body p-0">
        <?php if (!empty($students)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-3 py-3" style="width: 5%;">#</th>
                            <th scope="col" style="width: 15%;">รหัสนักศึกษา</th>
                            <th scope="col" style="width: 25%;">ชื่อ - นามสกุล</th>
                            <th scope="col" style="width: 20%;">สาขาวิชา</th>
                            <th scope="col" class="text-center" style="width: 10%;">ชั้นปี</th>
                            <th scope="col" style="width: 13%;">วันที่บันทึก</th>
                            <th scope="col" class="text-end pe-3" style="width: 12%;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $index => $student): ?>
                            <tr>
                                <td class="ps-3 fw-semibold text-muted"><?= $index + 1 ?></td>
                                <td>
                                    <span class="badge bg-secondary font-monospace fs-6">
                                        <?= htmlspecialchars($student['student_id']) ?>
                                    </span>
                                </td>
                                <td class="fw-semibold text-dark">
                                    <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                                </td>
                                <td>
                                    <span class="text-secondary">
                                        <?= htmlspecialchars($student['major']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-info text-dark">
                                        ปี <?= htmlspecialchars($student['year']) ?>
                                    </span>
                                </td>
                                <td class="small text-muted">
                                    <?= date('d/m/Y H:i', strtotime($student['created_at'])) ?>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="edit.php?id=<?= (int)$student['id'] ?>" class="btn btn-outline-warning" title="แก้ไขข้อมูล">
                                            <i class="bi bi-pencil-square"></i> แก้ไข
                                        </a>
                                        <a href="delete.php?id=<?= (int)$student['id'] ?>" 
                                           class="btn btn-outline-danger" 
                                           title="ลบข้อมูล"
                                           onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลของ <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?> (รหัส <?= htmlspecialchars($student['student_id']) ?>)?');">
                                            <i class="bi bi-trash"></i> ลบ
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted display-4 d-block mb-3"></i>
                <h5 class="text-muted">ยังไม่มีข้อมูลนักศึกษาในระบบ</h5>
                <p class="text-secondary small mb-3">คุณสามารถเริ่มต้นด้วยการเพิ่มข้อมูลนักศึกษาคนแรก</p>
                <a href="create.php" class="btn btn-primary">
                    <i class="bi bi-person-plus-fill me-1"></i> เพิ่มนักศึกษาเดี๋ยวนี้
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
// นำเข้าไฟล์ส่วนท้าย
require_once 'includes/footer.php';
?>
