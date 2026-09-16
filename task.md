# Task Checklist — Student CRUD (PHP)

> Agent: ทำทีละข้อตามลำดับ แล้วติ๊ก [x] เมื่อเสร็จ พร้อมสรุปสั้นๆ ว่าทำอะไรไปหลังแต่ละข้อ

## Phase 1: Database
- [x] สร้าง `database/schema.sql`
- [x] เพิ่มข้อมูลตัวอย่าง 5 รายการใน schema.sql

## Phase 2: Backend Connection
- [x] สร้าง `config/db.php` (PDO + try/catch)

## Phase 3: UI Components
- [x] สร้าง `includes/header.php`
- [x] สร้าง `includes/footer.php`

## Phase 4: CRUD Pages
- [x] `index.php` — READ (แสดงตาราง)
- [x] `create.php` — CREATE (ฟอร์ม + validate)
- [x] `edit.php` — UPDATE (โหลดข้อมูลเดิม + บันทึก)
- [x] `delete.php` — DELETE (ยืนยันก่อนลบ)

## Phase 5: เอกสารประกอบ
- [x] `.gitignore`
- [x] `README.md` (วิธี setup, screenshot ถ้ามี)

## Phase 6: ทดสอบก่อนส่งงาน
- [ ] ตรวจ syntax ทุกไฟล์ (`php -l filename.php`)
- [ ] ทดสอบ เพิ่ม/แก้ไข/ลบ ครบทุกฟังก์ชันจริงบน localhost

## Phase 7: Git (ผู้ใช้เป็นคนสั่งเองทุกคำสั่ง — Agent ห้าม push เอง)
- [ ] `git init`
- [ ] `git add .`
- [ ] `git commit -m "Initial commit: Student CRUD system with PHP and MySQL"`
- [ ] สร้าง repository เปล่าบน GitHub (ผ่านเว็บ)
- [ ] `git remote add origin <URL_REPO_ของนักศึกษา>`
- [ ] `git branch -M main`
- [ ] `git push -u origin main`

## หมายเหตุสำหรับผู้สอน
ใช้ Phase 7 เป็นจุดเชื่อมกลับไปสอนเรื่อง Git/GitHub ที่อบรมไปก่อนหน้า —
ให้นักศึกษารันคำสั่งเองทีละบรรทัด ไม่ปล่อยให้ AI agent รันให้ เพื่อฝึกความเข้าใจจริง
