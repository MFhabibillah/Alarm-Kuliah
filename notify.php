<?php
include 'config.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
date_default_timezone_set('Asia/Jakarta');
$current_time = date("Y-m-d H:i:s");

// Check for current courses
$sql = "SELECT * FROM mata_kuliah WHERE id_user='$id_user' AND hari_jam <= '$current_time' AND hari_jam >= DATE_SUB('$current_time', INTERVAL 1 HOUR)";
$result = $conn->query($sql);

$notifications = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = "You have a course: " . $row['matkul'] . " at " . $row['hari_jam'];
    }
}

// Check for current tasks
$sql = "SELECT * FROM tugas WHERE deadline <= '$current_time' AND deadline >= DATE_SUB('$current_time', INTERVAL 1 HOUR)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = "You have a task: " . $row['tugas'] . " due at " . $row['deadline'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Notifications</h2>
    <?php if (count($notifications) > 0) { ?>
        <ul class="list-group">
            <?php foreach ($notifications as $notification) { ?>
                <li class="list-group-item"><?php echo $notification; ?></li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <div class="alert alert-info" role="alert">No notifications at this time.</div>
    <?php } ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
