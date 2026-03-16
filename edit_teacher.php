<?php
require_once 'conn.php';
session_start();

if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$teacher = $conn->query("SELECT * FROM teachers WHERE id = $id")->fetch_assoc();
$subjects = $conn->query("SELECT * FROM subjects");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $subject_id = $_POST['subject_id'];

    $sql = "UPDATE teachers SET firstname=?, lastname=?, subject_id=?, username=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $firstname, $lastname, $subject_id, $username, $id);
    $stmt->execute();

    header("Location: teachers.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Teacher</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Edit Teacher</h2>
  <form method="POST">
    <div class="mb-3">
      <label>First Name</label>
      <input type="text" name="firstname" class="form-control" value="<?php echo $teacher['firstname']; ?>" required>
    </div>
    <div class="mb-3">
      <label>Last Name</label>
      <input type="text" name="lastname" class="form-control" value="<?php echo $teacher['lastname']; ?>" required>
    </div>
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" value="<?php echo $teacher['username']; ?>" required>
    </div>
    <div class="mb-3">
      <label>Subject</label>
      <select name="subject_id" class="form-control" required>
        <?php while($s = $subjects->fetch_assoc()): ?>
          <option value="<?php echo $s['id']; ?>" <?php if ($teacher['subject_id'] == $s['id']) echo 'selected'; ?>>
            <?php echo $s['name']; ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
  </form>
</div>
</body>
</html>