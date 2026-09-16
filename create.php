<?php
/**
 * หน้าเพิ่มข้อมูลนักศึกษาใหม่ (CREATE)
 * มีฟอร์มรับข้อมูล และระบบตรวจสอบความถูกต้อง (Validation) ฝั่ง Server
 */

// 1. นำเข้าไฟล์เชื่อมต่อฐานข้อมูล
require_once 'config/db.php';

// กำหนดตัวแปรเริ่มต้นสำหรับเก็บค่าและข้อความแจ้งเตือนข้อผิดพลาด
$student_id = '';
$first_name = '';
$last_name  = '';
$major       = '';
$year        = '';
$errors      = [];

// 2. ตรวจสอบเมื่อมีการกดส่งฟอร์ม (Method POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าและตัดช่องว่างส่วนเกิน
    $student_id = trim($_POST['student_id'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $major       = trim($_POST['major'] ?? '');
    $year        = trim($_POST['year'] ?? '');

    // --- ตรวจสอบความถูกต้องของข้อมูล (Validation) ---
    // ก) ตรวจสอบว่ากรอกข้อมูลครบทุกช่องหรือไม่
    if (empty($student_id)) {
        $errors[] = 'กรุณากรอกรหัสนักศึกษา';
    } elseif (mb_strlen($student_id) > 10) {
        $errors[] = 'รหัสนักศึกษาต้องมีความยาวไม่เกิน 10 ตัวอักษร';
    } else {
        // ตรวจสอบว่ารหัสนักศึกษาซ้ำในระบบหรือไม่ โดยใช้ Prepared Statement
        $checkSql = "SELECT id FROM students WHERE student_id = ? LIMIT 1";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([$student_id]);
        if ($checkStmt->fetch()) {
            $errors[] = "รหัสนักศึกษา '{$student_id}' มีอยู่ในระบบแล้ว กรุณาใช้รหัสอื่น";
        }
    }

    if (empty($first_name)) {
        $errors[] = 'กรุณากรอกชื่อจริง';
    }

    if (empty($last_name)) {
        $errors[] = 'กรุณากรอกนามสกุล';
    }

    if (empty($major)) {
        $errors[] = 'กรุณากรอกสาขาวิชา';
    }

    if (empty($year) || !in_array((int)$year, [1, 2, 3, 4], true)) {
        $errors[] = 'กรุณาเลือกชั้นปีที่ถูกต้อง (ปี 1 - 4)';
    }

    // ข) หากไม่มีข้อผิดพลาด ให้บันทึกลงฐานข้อมูล
    if (empty($errors)) {
        try {
            $sql = "INSERT INTO students (student_id, first_name, last_name, major, year) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $student_id,
                $first_name,
                $last_name,
                $major,
                (int)$year
            ]);

            // บันทึกสำเร็จ ให้เปลี่ยนเส้นทางกลับหน้าแรกพร้อมส่งข้อความแจ้งเตือน
            header('Location: index.php?msg=created');
            exit();
        } catch (PDOException $e) {
            $errors[] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage();
        }
    }
}

// กำหนดหัวข้อหน้าเว็บ
$pageTitle = 'เพิ่มข้อมูลนักศึกษาใหม่';
require_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <!-- การ์ดฟอร์มเพิ่มข้อมูล -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="card-title mb-0 fw-semibold">
                    <i class="bi bi-person-plus-fill me-2"></i>เพิ่มข้อมูลนักศึกษาใหม่
                </h5>
            </div>
            <div class="card-body p-4">
                
                <!-- แสดงข้อความแจ้งเตือนข้อผิดพลาด (ถ้ามี) -->
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="fw-semibold mb-1">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> กรุณาตรวจสอบข้อมูลต่อไปนี้:
                        </div>
                        <ul class="mb-0 ps-3">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- แบบฟอร์มเพิ่มข้อมูล -->
                <form action="create.php" method="POST" novalidate>
                    <div class="mb-3">
                        <label for="student_id" class="form-label fw-semibold">
                            รหัสนักศึกษา <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="student_id" 
                               id="student_id" 
                               class="form-control font-monospace <?= (!empty($errors) && empty($student_id)) ? 'is-invalid' : '' ?>" 
                               placeholder="เช่น 65010001 (สูงสุด 10 หลัก)" 
                               maxlength="10" 
                               value="<?= htmlspecialchars($student_id) ?>" 
                               required>
                        <div class="form-text">รหัสนักศึกษาต้องไม่ซ้ำกับที่มีอยู่ในระบบ</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label fw-semibold">
                                ชื่อจริง <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="first_name" 
                                   id="first_name" 
                                   class="form-control" 
                                   placeholder="เช่น สมชาย" 
                                   maxlength="100" 
                                   value="<?= htmlspecialchars($first_name) ?>" 
                                   required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label fw-semibold">
                                นามสกุล <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="last_name" 
                                   id="last_name" 
                                   class="form-control" 
                                   placeholder="เช่น สายเรียนดี" 
                                   maxlength="100" 
                                   value="<?= htmlspecialchars($last_name) ?>" 
                                   required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="major" class="form-label fw-semibold">
                            สาขาวิชา <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="major" 
                               id="major" 
                               class="form-control" 
                               placeholder="เช่น เทคโนโลยีสารสนเทศ" 
                               maxlength="100" 
                               value="<?= htmlspecialchars($major) ?>" 
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="year" class="form-label fw-semibold">
                            ชั้นปี <span class="text-danger">*</span>
                        </label>
                        <select name="year" id="year" class="form-select" required>
                            <option value="">-- กรุณาเลือกชั้นปี --</option>
                            <option value="1" <?= $year === '1' ? 'selected' : '' ?>>ปี 1 (Freshman)</option>
                            <option value="2" <?= $year === '2' ? 'selected' : '' ?>>ปี 2 (Sophomore)</option>
                            <option value="3" <?= $year === '3' ? 'selected' : '' ?>>ปี 3 (Junior)</option>
                            <option value="4" <?= $year === '4' ? 'selected' : '' ?>>ปี 4 (Senior)</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> ย้อนกลับ
                        </a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-save me-1"></i> บันทึกข้อมูล
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php
// นำเข้าไฟล์ส่วนท้าย
require_once 'includes/footer.php';
?>
