# Implementation Plan — Student CRUD System

## เป้าหมาย
สร้างระบบจัดการข้อมูลนักศึกษาแบบ CRUD (Create, Read, Update, Delete)
ด้วย PHP + MySQL (PDO) ให้เสร็จสมบูรณ์และรันได้จริงบน localhost

## โครงสร้างไฟล์ที่ต้องการ (Target File Structure)
```
student-crud/
├── config/
│   └── db.php              # เชื่อมต่อฐานข้อมูลด้วย PDO
├── database/
│   └── schema.sql           # คำสั่งสร้างตาราง students + ข้อมูลตัวอย่าง
├── includes/
│   ├── header.php           # ส่วนหัว + navbar (Bootstrap)
│   └── footer.php           # ส่วนท้าย
├── index.php                # READ: แสดงรายชื่อนักศึกษาทั้งหมด (ตาราง)
├── create.php                # CREATE: ฟอร์มเพิ่มนักศึกษาใหม่
├── edit.php                  # UPDATE: ฟอร์มแก้ไขข้อมูล (รับ id ผ่าน GET)
├── delete.php                # DELETE: ลบข้อมูล (ยืนยันก่อนลบด้วย JS confirm)
├── .gitignore                 # ไม่ commit ไฟล์ config ที่มี password จริง
└── README.md                  # วิธีติดตั้งและใช้งาน
```

## โครงสร้างตาราง students (schema.sql)
| Field       | Type         | หมายเหตุ            |
|-------------|--------------|----------------------|
| id          | INT PK AI    | รหัสอัตโนมัติ         |
| student_id  | VARCHAR(10)  | รหัสนักศึกษา (unique) |
| first_name  | VARCHAR(100) |                      |
| last_name   | VARCHAR(100) |                      |
| major       | VARCHAR(100) | สาขาวิชา              |
| year        | INT          | ชั้นปี (1-4)           |
| created_at  | TIMESTAMP    | default current time |

## ลำดับขั้นตอนการสร้าง (ทำตามลำดับนี้)
1. สร้าง `database/schema.sql` พร้อม `INSERT` ข้อมูลตัวอย่าง 5 แถว
2. สร้าง `config/db.php` เชื่อมต่อด้วย PDO และเปิด error mode เป็น exception
3. สร้าง `includes/header.php` และ `includes/footer.php` (Bootstrap 5 CDN, navbar ชื่อ "ระบบจัดการนักศึกษา")
4. สร้าง `index.php` — ดึงข้อมูลทั้งหมดแสดงเป็นตาราง พร้อมปุ่ม แก้ไข/ลบ/เพิ่มใหม่
5. สร้าง `create.php` — ฟอร์มเพิ่มข้อมูล พร้อม validate ฝั่ง server (ห้ามเว้นว่าง)
6. สร้าง `edit.php` — โหลดข้อมูลเดิมมาแสดงในฟอร์ม แล้วอัปเดตเมื่อ submit
7. สร้าง `delete.php` — ลบตาม id พร้อม redirect กลับ index.php
8. สร้าง `.gitignore` (ใส่ `config/db_local.php`, `.env` ถ้ามี)
9. สร้าง `README.md` อธิบายวิธี import schema.sql และตั้งค่า config/db.php
10. รอคำสั่งจากผู้ใช้ก่อนทำขั้นตอน Git (ดูใน task.md ข้อสุดท้าย)

## Definition of Done
- [ ] รันบน localhost แล้วเห็นตารางรายชื่อนักศึกษา
- [ ] เพิ่ม/แก้ไข/ลบ ได้จริงโดยไม่ error
- [ ] ไม่มีช่องโหว่ SQL Injection (ใช้ prepared statement ทุกจุด)
- [ ] มี README.md อธิบายวิธีรัน
