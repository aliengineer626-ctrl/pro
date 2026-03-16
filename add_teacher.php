<?php
require_once 'conn.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$subjects = $conn->query("SELECT * FROM subjects");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $subject_id = $_POST['subject_id'];

    $sql = "INSERT INTO teachers (firstname, lastname, subject_id, username, password)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $firstname, $lastname, $subject_id, $username, $password);
    $stmt->execute();

    header("Location: teachers.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Teacher</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>
<div class="container mt-5">
  <h2>Add New Teacher</h2>
  <form method="POST">
    <div class="mb-3">
      <label>First Name</label>
      <input type="text" name="firstname" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Last Name</label>
      <input type="text" name="lastname" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Subject</label>
      <select name="subject_id" class="form-control" required>
        <option value="">Select Subject</option>
        <?php while($s = $subjects->fetch_assoc()): ?>
          <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Add Teacher</button>
  </form>
</div>
</body>
</html>