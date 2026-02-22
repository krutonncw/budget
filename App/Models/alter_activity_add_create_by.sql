-- เพิ่มคอลัมน์ create_by ในตาราง activity เพื่อเก็บ person_id ของผู้สร้าง
ALTER TABLE activity ADD COLUMN create_by VARCHAR(20) DEFAULT NULL;
