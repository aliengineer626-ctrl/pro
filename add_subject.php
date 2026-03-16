<?php
require_once 'conn.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$classes = $conn->query("SELECT * FROM classes");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $class_id = $_POST['class_id'];

    $sql = "INSERT INTO subjects (name, class_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $class_id);
    $stmt->execute();

    header("Location: subjects.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Subject</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<link rel="stylesheet" href="style.css">


<body>
<div class="container mt-5">
  <h2>Add New Subject</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Subject Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Class</label>
      <select name="class_id" class="form-control" required>
        <option value="">Select Class</option>
        <?php while($c = $classes->fetch_assoc()): ?>
          <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Add Subject</button>
  </form>
</div>
</body>
</html>