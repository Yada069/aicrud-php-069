# ระบบจัดการข้อมูลนักศึกษา (Student CRUD System)

ระบบจัดการข้อมูลนักศึกษาขนาดเล็ก พัฒนาด้วย **PHP 8 (Native)** และ **MySQL/MariaDB** ผ่าน **PDO (PHP Data Objects)** ออกแบบมาเพื่อเป็นสื่อการเรียนรู้สำหรับนักศึกษาชั้นปีที่ 3 สาขาเทคโนโลยีสารสนเทศ

---

## 🌟 คุณสมบัติเด่นของระบบ (Features)

- **Create (เพิ่มข้อมูล)**: ฟอร์มเพิ่มข้อมูลนักศึกษา พร้อมระบบตรวจสอบความถูกต้อง (Validation) ฝั่ง Server และป้องกันรหัสนักศึกษาซ้ำ
- **Read (แสดงข้อมูล)**: แสดงรายชื่อนักศึกษาทั้งหมดในรูปแบบตารางที่สวยงาม พร้อม Badge บอกสถานะชั้นปี
- **Update (แก้ไขข้อมูล)**: แก้ไขข้อมูลนักศึกษาเดิม พร้อมโหลดข้อมูลเดิมอัตโนมัติ และตรวจสอบรหัสซ้ำกับนักศึกษาคนอื่น
- **Delete (ลบข้อมูล)**: ลบข้อมูลนักศึกษา พร้อมหน้าต่างยืนยันความปลอดภัย (JavaScript Confirm Dialog) ก่อนลบจริง
- **Security (ความปลอดภัย)**: ใช้ **Prepared Statements** 100% ทุกจุดเพื่อป้องกัน SQL Injection อย่างสมบูรณ์
- **Responsive UI**: ตกแต่งด้วย **Bootstrap 5 (CDN)** และ **Bootstrap Icons** ใช้งานได้บนทุกอุปกรณ์โดยไม่ต้องติดตั้ง dependencies เพิ่มเติม

---

## 🛠 เทคโนโลยีที่ใช้ (Tech Stack)

- **ภาษาหลัก**: PHP 8.x (Native ไม่ใช้ Framework)
- **ฐานข้อมูล**: MySQL / MariaDB เชื่อมต่อผ่าน **PDO**
- **ส่วนติดต่อผู้ใช้ (Frontend)**: HTML5, CSS3, Bootstrap 5.3 (CDN), Bootstrap Icons
- **สภาพแวดล้อมที่รองรับ**: XAMPP, Laragon, WampServer หรือ PHP Built-in Server

---

## 📁 โครงสร้างโปรเจกต์ (Project Structure)

```text
student-crud/
├── config/
│   └── db.php              # ไฟล์เชื่อมต่อฐานข้อมูล MySQL ด้วย PDO
├── database/
│   └── schema.sql          # สคริปต์ SQL สร้างฐานข้อมูล ตาราง students และข้อมูลตัวอย่าง
├── includes/
│   ├── header.php          # ส่วนหัว HTML + Bootstrap 5 + เมนูนำทาง (Navbar)
│   └── footer.php          # ส่วนท้าย HTML + Bootstrap JS Bundle
├── index.php               # READ: หน้ารายการนักศึกษาทั้งหมด
├── create.php              # CREATE: หน้าฟอร์มเพิ่มข้อมูลนักศึกษาใหม่
├── edit.php                # UPDATE: หน้าฟอร์มแก้ไขข้อมูลนักศึกษา
├── delete.php              # DELETE: ประมวลผลการลบข้อมูลตามรหัส id
├── .gitignore              # กำหนดไฟล์ที่ไม่ต้องการให้ Git ติดตาม (เช่น รหัสผ่าน)
├── agents.md               # กติกาและข้อกำหนดสำหรับ AI Agent
├── implementation_plan.md  # แผนการพัฒนาและโครงสร้างระบบ
├── task.md                 # เช็กลิสต์รายการงานแต่ละ Phase
└── README.md               # คู่มือการติดตั้งและใช้งานระบบ
```

---

## 🚀 ขั้นตอนการติดตั้งและเริ่มต้นใช้งาน (Installation Guide)

### 1. การติดตั้งฐานข้อมูล (Database Setup)
1. เปิดโปรแกรม **XAMPP Control Panel** แล้วกด **Start** ที่โมดูล **Apache** และ **MySQL**
2. เปิดเว็บเบราว์เซอร์ไปที่ [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
3. ไปที่แท็บ **Import (นำเข้า)** แล้วเลือกไฟล์ `database/schema.sql` หรือไปที่แท็บ **SQL** แล้วคัดลอกคำสั่งในไฟล์ไปวางแล้วกด **Go (ดำเนินการ)**
4. ระบบจะสร้างฐานข้อมูลชื่อ `student_db` พร้อมตาราง `students` และข้อมูลตัวอย่าง 5 รายการให้โดยอัตโนมัติ

### 2. การตั้งค่าการเชื่อมต่อฐานข้อมูล (Database Configuration)
เปิดไฟล์ `config/db.php` แล้วตรวจสอบการตั้งค่าให้ตรงกับเครื่องของคุณ:
```php
$host     = 'localhost';
$dbname   = 'student_db';
$username = 'root';
$password = '';             // สำหรับ XAMPP รหัสผ่านเริ่มต้นมักเป็นค่าว่าง
$charset  = 'utf8mb4';
```

### 3. การเปิดใช้งานโปรเจกต์ (Running the Project)
- นำโฟลเดอร์โปรเจกต์ไปวางไว้ที่ `htdocs` ของ XAMPP (เช่น `C:\xampp\htdocs\student-crud`)
- หรือเปิด Built-in Server ด้วยคำสั่ง PHP ในโฟลเดอร์โปรเจกต์:
  ```bash
  php -S localhost:8000
  ```
- เปิดเว็บเบราว์เซอร์ไปที่:
  - ผ่าน XAMPP: [http://localhost/student-crud](http://localhost/student-crud)
  - ผ่าน PHP Built-in Server: [http://localhost:8000](http://localhost:8000)

---

## 📊 โครงสร้างตารางฐานข้อมูล `students`

| ชื่อฟิลด์ | ชนิดข้อมูล | คุณลักษณะ | คำอธิบาย |
|-----------|-----------|-----------|----------|
| `id` | INT | Primary Key, Auto Increment | รหัสลำดับอัตโนมัติ |
| `student_id` | VARCHAR(10) | UNIQUE, NOT NULL | รหัสนักศึกษา (ไม่ซ้ำกัน) |
| `first_name` | VARCHAR(100) | NOT NULL | ชื่อจริง |
| `last_name` | VARCHAR(100) | NOT NULL | นามสกุล |
| `major` | VARCHAR(100) | NOT NULL | สาขาวิชา |
| `year` | INT | NOT NULL (1-4) | ชั้นปีที่ศึกษา |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | วันที่และเวลาที่บันทึก |

---

## 🔒 แนวปฏิบัติความปลอดภัย (Security Best Practices)

1. **ป้องกัน SQL Injection**: โค้ดทั้งหมดใช้ `$pdo->prepare()` ร่วมกับ `$stmt->execute([...])` ห้ามนำค่าตัวแปรจากผู้ใช้ไปต่อในคำสั่ง SQL โดยตรง
2. **Server-Side Validation**: มีการตรวจจับค่าว่าง ความยาวตัวอักษร และรูปแบบข้อมูลก่อนสั่ง INSERT / UPDATE ลงฐานข้อมูลเสมอ
3. **XSS Protection**: มีการครอบ `htmlspecialchars()` สำหรับทุกข้อมูลที่นำออกมาแสดงผลทางหน้าเว็บ
