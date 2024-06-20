<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_matkul = $_GET['id'];
$sql = "DELETE FROM tugas WHERE id_matkul='$id_matkul'";
$conn->query($sql);
$sql = "DELETE FROM mata_kuliah WHERE id_matkul='$id_matkul'";
if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
