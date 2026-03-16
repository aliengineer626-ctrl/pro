<?php
require_once 'conn.php';
session_start();

if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$subject = $conn->query("SELECT * FROM subjects WHERE id = $id")->fetch_assoc();
$classes = $conn->query("SELECT * FROM classes");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $class_id = $_POST['class_id'];

    $sql = "UPDATE subjects SET name=?, class_id=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $name, $class_id, $id);
    $stmt->execute();

    header("Location: subjects.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Subject</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Edit Subject</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Subject Name</label>
      <input type="text" name="name" class="form-control" value="<?php echo $subject['name']; ?>" required>
    </div>
    <div class="mb-3">
      <label>Class</label>
      <select name="class_id" class="form-control" required>
        <?php while($c = $classes->fetch_assoc()): ?>
          <option value="<?php echo $c['id']; ?>" <?php if ($subject['class_id'] == $c['id']) echo 'selected'; ?>>
            <?php echo $c['name']; ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-warning">Update Subject</button>
  </form>
</div>
</body>
</html>