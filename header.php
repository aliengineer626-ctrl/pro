
<?php
// بداية الجلسة بأمان لجميع الإصدارات
if (!isset($_SESSION)) {
    session_start();
}

require_once 'conn.php';
include_once 'header.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding-top: 70px;
    }
  
body {
  background-image: url('https://images.unsplash.com/photo-1522199710521-72d69614c702?auto=format&fit=crop&w=1500&q=80');
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  min-height: 100vh;
  font-family: 'Segoe UI', sans-serif;
  color: #333;
}

.container, .card {
  background-color: rgba(255, 255, 255, 0.85); /* خلفية شفافة للصناديق */
  border-radius: 10px;
  padding: 15px;
}


  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">SMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="students.php">Students</a></li>
        <li class="nav-item"><a class="nav-link" href="teachers.php">Teachers</a></li>
        <li class="nav-item"><a class="nav-link" href="subjects.php">Subjects</a></li>
        <li class="nav-item"><a class="nav-link" href="classes.php">Classes</a></li>
        <li class="nav-item"><a class="nav-link" href="grades.php">Grades</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
