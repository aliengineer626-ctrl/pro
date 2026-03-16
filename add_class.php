<?php
require_once 'conn.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $section = $_POST['section'];

    $sql = "INSERT INTO classes (name, section) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $section);
    $stmt->execute();

    header("Location: classes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Class</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<link rel="stylesheet" href="style.css">
<style>body{
background-image: url("images/bb.jpg");

}</style>
<body>
<div class="container mt-5">
  <h2>Add New Class</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Class Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Section</label>
      <input type="text" name="section" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Add Class</button>
  </form>
</div>
</body>
</html>