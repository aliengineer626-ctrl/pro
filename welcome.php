<?php
session_start();
include 'conn.php';
include_once 'header.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['id'];
$sql = "SELECT firstname, lastname, picture, usertype FROM admin_accounts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($firstname, $lastname, $picture, $usertype);
$stmt->fetch();
$stmt->close();

$user = array(
    'firstname' => $firstname,
    'lastname' => $lastname,
    'picture' => $picture,
    'usertype' => $usertype
);

function getCount($conn, $table) {
    $sql = "SELECT COUNT(*) as count FROM `$table`";
    $res = $conn->query($sql);
    if (!$res) {
        die("Query error in getCount() for table `$table`: " . $conn->error);
    }
    $row = $res->fetch_assoc();
    return $row['count'];
}

$studentCount = getCount($conn, 'students');
$teacherCount = getCount($conn, 'teachers');
$subjectCount = getCount($conn, 'subjects');
$classCount = getCount($conn, 'classes');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Charts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
        background: linear-gradient(to right, #f9f9f9, #e3f2fd);
        font-family: 'Segoe UI', sans-serif;
    }
    .card {
        border-radius: 15px;
        transition: 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
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
<div class="container mt-5">
    
  <div class="text-center mb-4">
    <img src="images/<?php echo $user['picture']; ?>" width="100" class="rounded-circle shadow">
    <h3 class="mt-2"><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h3>
    <small class="text-muted"><?php echo ucfirst($user['usertype']); ?></small>
  </div>

  <div class="row text-center">
    <div class="col-md-3 mb-3">
      <div class="card bg-primary text-white shadow">
        <div class="card-body">
          <i class="fas fa-user-graduate fa-2x mb-2"></i>
          <h5>Students</h5>
          <h3><?php echo $studentCount; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card bg-success text-white shadow">
        <div class="card-body">
          <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i>
          <h5>Teachers</h5>
          <h3><?php echo $teacherCount; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card bg-warning text-dark shadow">
        <div class="card-body">
          <i class="fas fa-book fa-2x mb-2"></i>
          <h5>Subjects</h5>
          <h3><?php echo $subjectCount; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card bg-info text-white shadow">
        <div class="card-body">
          <i class="fas fa-school fa-2x mb-2"></i>
          <h5>Classes</h5>
          <h3><?php echo $classCount; ?></h3>
        </div>
      </div>
    </div>
  </div>

  <a href="login.php" class="btn btn-primary mt-3"><i class="fas fa-tools"></i> الذهاب إلى لوحة الإدارة</a>

  <a href="logins.php" class="btn btn-success mt-3"><i class="fas fa-graduation-cap"></i> عرض الدرجات</a>


  <div class="row mt-5">
    <div class="col-md-6">
      <h5 class="text-center mb-3">Statistics Overview (Bar & Line)</h5>
      <canvas id="barLineChart"></canvas>
    </div>
    <div class="col-md-6">
      <h5 class="text-center mb-3">Distribution (Pie Chart)</h5>
      <canvas id="pieChart"></canvas>
    </div>
  </div>
</div>

<script>
const labels = ['Students', 'Teachers', 'Subjects', 'Classes'];
const dataCounts = [<?php echo "$studentCount, $teacherCount, $subjectCount, $classCount"; ?>];

// Bar + Line Chart
new Chart(document.getElementById('barLineChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                type: 'bar',
                label: 'Total',
                data: dataCounts,
                backgroundColor: [
                    'rgba(13, 110, 253, 0.7)',
                    'rgba(25, 135, 84, 0.7)',
                    'rgba(255, 193, 7, 0.7)',
                    'rgba(13, 202, 240, 0.7)'
                ],
                borderColor: [
                    'rgba(13, 110, 253, 1)',
                    'rgba(25, 135, 84, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(13, 202, 240, 1)'
                ],
                borderWidth: 2
            },
            {
                type: 'line',
                label: 'Trend',
                data: dataCounts,
                fill: false,
                borderColor: 'rgba(100,100,255,0.8)',
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});

// Pie Chart
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: labels,
        datasets: [{
            label: 'Distribution',
            data: dataCounts,
            backgroundColor: [
                'rgba(13, 110, 253, 0.6)',
                'rgba(25, 135, 84, 0.6)',
                'rgba(255, 193, 7, 0.6)',
                'rgba(13, 202, 240, 0.6)'
            ],
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>
<div class="row mt-5">
  <div class="col-12">
    <div class="card shadow p-4">
      <h4 class="mb-3"><i class="fas fa-info-circle text-primary"></i> نبذة عن النظام</h4>
      <p>
        هذا النظام يهدف إلى تسهيل إدارة معلومات الطلاب والمعلمين والصفوف والمقررات الدراسية، بالإضافة إلى عرض تقارير شاملة حول الأداء والإحصائيات.
        يمكن للمدير إدارة كل الكيانات داخل النظام، بينما يمكن للطالب الاطلاع على درجاته ومعلوماته.
      </p>
      <p>
      </p>
    </div>
  </div>
</div>

</body>
</html>
