<?php
require_once 'conn.php';
session_start();

if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM students WHERE id = $id");
$student = $result->fetch_assoc();
$class_result = $conn->query("SELECT * FROM classes");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $class_id = $_POST['class_id'];
    $image = $student['image'];

    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $image);
    }

    $sql = "UPDATE students SET firstname=?, lastname=?, gender=?, dob=?, class_id=?, image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisi", $firstname, $lastname, $gender, $dob, $class_id, $image, $id);
    $stmt->execute();

    header("Location: students.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
 <link rel="stylesheet" href="style.css">
  <style>body{
    background-image: url("logo/cc.jpg");
  }</style>
<body>
<div class="container mt-5">
  <h2>Edit Student</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>First Name</label>
      <input type="text" name="firstname" class="form-control" value="<?php echo $student['firstname']; ?>" required>
    </div>
    <div class="mb-3">
      <label>Last Name</label>
      <input type="text" name="lastname" class="form-control" value="<?php echo $student['lastname']; ?>" required>
    </div>
    <div class="mb-3">
      <label>Gender</label>
      <select name="gender" class="form-control" required>
        <option value="male" <?php if ($student['gender'] == 'male') echo 'selected'; ?>>Male</option>
        <option value="female" <?php if ($student['gender'] == 'female') echo 'selected'; ?>>Female</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Date of Birth</label>
      <input type="date" name="dob" class="form-control" value="<?php echo $student['dob']; ?>">
    </div>
    <div class="mb-3">
      <label>Class</label>
      <select name="class_id" class="form-control" required>
        <?php while($class = $class_result->fetch_assoc()): ?>
          <option value="<?php echo $class['id']; ?>" <?php if ($student['class_id'] == $class['id']) echo 'selected'; ?>>
            <?php echo $class['name']; ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Photo</label><br>
      <img src="images/<?php echo $student['image']; ?>" width="60"><br><br>
      <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-warning">Update Student</button>
  </form>
</div>
</body>
</html>