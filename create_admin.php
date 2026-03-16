<?php
require_once 'conn.php'; // الاتصال بقاعدة البيانات

// البيانات الافتراضية
$firstname = "ali";
$lastname = "hamid";
$username = "admin";
$password = "123"; // كلمة المرور التي سيسجل بها
$hashed_password = md5($password);
$picture = "default.png";
$usertype = "admin";

$sql = "INSERT INTO admin_accounts (firstname, lastname, username, password, picture, usertype, created_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $firstname, $lastname, $username, $hashed_password, $picture, $usertype);

if ($stmt->execute()) {
    echo "✅ Admin created successfully.<br>";
    echo "👉 Username: <b>$username</b><br>";
    echo "🔑 Password: <b>$password</b>";
} else {
    echo "❌ Error creating admin: " . $stmt->error;
}
?>
