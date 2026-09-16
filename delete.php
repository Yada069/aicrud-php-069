<?php
/**
 * หน้าลบข้อมูลนักศึกษา (DELETE)
 * รับ id ผ่าน GET/POST แล้วทำการลบข้อมูลจากฐานข้อมูลด้วย Prepared Statement
 */

// 1. นำเข้าไฟล์เชื่อมต่อฐานข้อมูล
require_once 'config/db.php';

// 2. รับค่า id ของนักศึกษาที่ต้องการลบ
$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);

// ตรวจสอบว่า id ถูกต้องหรือไม่
if ($id <= 0) {
    header('Location: index.php?msg=not_found');
    exit();
}

try {
    // 3. ตรวจสอบว่ามีข้อมูลนักศึกษาคนนี้อยู่จริงหรือไม่ (ใช้ Prepared Statement)
    $checkSql = "SELECT id FROM students WHERE id = ? LIMIT 1";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([$id]);
    $student = $checkStmt->fetch();

    if (!$student) {
        // หากไม่พบข้อมูล ให้กลับไปหน้าแรกพร้อมแจ้งเตือนว่าไม่พบ
        header('Location: index.php?msg=not_found');
        exit();
    }

    // 4. ทำการลบข้อมูลโดยใช้ Prepared Statement เพื่อป้องกัน SQL Injection
    $deleteSql = "DELETE FROM students WHERE id = ?";
    $deleteStmt = $pdo->prepare($deleteSql);
    $deleteStmt->execute([$id]);

    // 5. ลบสำเร็จ ส่งกลับไปหน้า index.php พร้อมข้อความแจ้งเตือนว่าลบแล้ว
    header('Location: index.php?msg=deleted');
    exit();

} catch (PDOException $e) {
    // หากเกิดข้อผิดพลาด ให้กลับไปหน้าแรกพร้อมแจ้งเตือน error
    header('Location: index.php?msg=error');
    exit();
}
