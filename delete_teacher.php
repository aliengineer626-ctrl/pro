<?php
require_once 'conn.php';
session_start();

if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$conn->query("DELETE FROM teachers WHERE id = $id");
header("Location: teachers.php");
exit();
?>