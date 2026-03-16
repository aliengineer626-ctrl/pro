<?php
$host = 'localhost';      // اسم المضيف
$user = 'root';           // اسم المستخدم
$pass = '';               // كلمة المرور (فارغة في XAMPP)
$db   = 'student';     // اسم قاعدة البيانات

$conn = new mysqli($host, $user, $pass, $db);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
