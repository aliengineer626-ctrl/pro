<?php
require_once 'conn.php';
session_start();

if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$class = $conn->query("SELECT * FROM classes WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $section = $_POST['section'];

    $sql = "UPDATE classes SET name=?, section=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $section, $id);
    $stmt->execute();

    header("Location: classes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Class</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<link rel="stylesheet" href="style.css">
<style>body{
background-image: url("images/dd.jpg");

}</style>
<body>
<div class="container mt-5">
  <h2>Edit Class</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Class Name</label>
      <input type="text" name="name" class="form-control" value="<?php echo $class['name']; ?>" required>
    </div>
    <div class="mb-3">
      <label>Section</label>
      <input type="text" name="section" class="form-control" value="<?php echo $class['section']; ?>">
    </div>
    <center><button type="submit" class="btn btn-warning">Update</button></center>
    
  </form>
</div>
</body>
</html>