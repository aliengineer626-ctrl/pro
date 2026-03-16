<?php
require_once 'conn.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// إضافة بيانات افتراضية
$conn->query("INSERT INTO classes (name, section) VALUES 
    ('Class 1', 'A'),
    ('Class 2', 'B'),
    ('Class 3', 'C')");

$conn->query("INSERT INTO subjects (name, class_id) VALUES 
    ('Math', 1),
    ('Science', 2),
    ('History', 3)");

$conn->query("INSERT INTO students (firstname, lastname, gender, dob, class_id, image, created_at) VALUES 
    ('Ali', 'Ahmed', 'male', '2010-05-10', 1, '', NOW()),
    ('Sara', 'Hassan', 'female', '2011-08-15', 2, '', NOW())");

$conn->query("INSERT INTO teachers (firstname, lastname, subject_id, username, password) VALUES 
    ('Mr.', 'Khaled', 1, 'khaled', MD5('123')),
    ('Ms.', 'Mona', 2, 'mona', MD5('123'))");

echo '✅ بيانات تجريبية تمت إضافتها بنجاح.';
?>
