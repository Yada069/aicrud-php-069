<?php
/**
 * ไฟล์เชื่อมต่อฐานข้อมูล (Database Connection)
 * ใช้ PDO (PHP Data Objects) ในการเชื่อมต่อ MySQL/MariaDB
 */

// กำหนดค่าการเชื่อมต่อฐานข้อมูล
$host     = 'localhost';
$dbname   = 'student_db';
$username = 'root';
$password = '';
$charset  = 'utf8mb4';

// สร้าง Data Source Name (DSN)
$dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";

// ตัวเลือกเพิ่มเติมสำหรับ PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // ให้โยน Exception เมื่อเกิด Error
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // คืนค่าผลลัพธ์เป็น Associative Array
    PDO::ATTR_EMULATE_PREPARES   => false,                  // ใช้ Native Prepared Statements เพื่อความปลอดภัย
];

try {
    // สร้าง Instance ของ PDO สำหรับนำไปใช้งานต่อในไฟล์อื่นๆ
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // หากเชื่อมต่อไม่สำเร็จ ให้แสดงข้อความแจ้งเตือนและหยุดการทำงาน
    die("เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล: " . $e->getMessage());
}
