<?php
require_once 'conn.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$class_result = $conn->query("SELECT * FROM classes");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $class_id = $_POST['class_id'];
    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $image);
    }

    $sql = "INSERT INTO students (firstname, lastname, gender, dob, class_id, image, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssis", $firstname, $lastname, $gender, $dob, $class_id, $image);
    $stmt->execute();

    header("Location: students.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url('images/aa.jpg');
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .form-container {
      max-width: 600px;
      margin: 50px auto;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .card-header {
      background-color: #0d6efd;
      color: #fff;
      font-size: 1.3rem;
      font-weight: bold;
      text-align: center;
      border-radius: 15px 15px 0 0;
    }
    
  </style>
</head>
<body>
  <div class="container form-container">
    <div class="card">
      <div class="card-header">➕ Add New Student</div>
      <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="firstname" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="lastname" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select" required>
              <option value="">Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Class</label>
            <select name="class_id" class="form-select" required>
              <option value="">Select Class</option>
              <?php while($class = $class_result->fetch_assoc()): ?>
                <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="image" class="form-control">
          </div>
          <button type="submit" class="btn btn-primary w-100">Add Student</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
