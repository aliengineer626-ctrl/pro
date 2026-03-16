<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT teachers.*, subjects.name AS subject_name FROM teachers
        LEFT JOIN subjects ON teachers.subject_id = subjects.id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Teachers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
body {
  background-image: url('logo/cc.jpg');
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  min-height: 100vh;
  font-family: 'Segoe UI', sans-serif;
  color: #333;
}
h2{
  color: aliceblue;
font: optional;
font-style: italic;
font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
tr td{
color: #b10606;
padding: 9px 33px 9px 59px;
margin: 20px;
   border-radius: 8px;
    background: rgba(255,255,255,0.9);
    color: #fff;
    outline: none;
    font-size: 15px;
    box-shadow: inset 0 0 9px rgba(255,255,255,0.4);
    color: #000;
}
</style>
<body>
<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Teachers</h2>
    <a href="add_teacher.php" class="btn btn-primary">+ Add Teacher</a>
  </div>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Name</th>
        <th>Subject</th>
        <th>Username</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
          <td><?php echo $row['subject_name']; ?></td>
          <td><?php echo $row['username']; ?></td>
          <td>
            <a href="edit_teacher.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="delete_teacher.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this teacher?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>