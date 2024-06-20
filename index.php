<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

date_default_timezone_set('Asia/Jakarta'); // Set your timezone
$id_user = $_SESSION['id_user'];
$current_day = date("l"); // 'l' (lowercase 'L') returns the full textual representation of the day of the week
$current_date = date("Y-m-d"); // Get the current date in the format YYYY-MM-DD

// Fetch user's courses
$sql_courses = "SELECT * FROM mata_kuliah WHERE id_user='$id_user'";
$result_courses = $conn->query($sql_courses);

// Fetch user's tasks
$sql_tasks = "SELECT t.*, m.matkul FROM tugas t JOIN mata_kuliah m ON t.id_matkul = m.id_matkul WHERE m.id_user='$id_user'";
$result_tasks = $conn->query($sql_tasks);

// Fetch notifications for today's courses
$sql_course_notifications = "SELECT * FROM mata_kuliah WHERE id_user='$id_user' AND hari='$current_day'";
$result_course_notifications = $conn->query($sql_course_notifications);

// Fetch notifications for today's tasks
$sql_task_notifications = "SELECT t.*, m.matkul FROM tugas t JOIN mata_kuliah m ON t.id_matkul = m.id_matkul WHERE m.id_user='$id_user' AND DATE(deadline) = '$current_date'";
$result_task_notifications = $conn->query($sql_task_notifications);

$notifications = [];

if ($result_course_notifications->num_rows > 0) {
    while ($row = $result_course_notifications->fetch_assoc()) {
        $notifications[] = "Today's course: " . $row['matkul'] . " at " . $row['jam'];
    }
}

if ($result_task_notifications->num_rows > 0) {
    while ($row = $result_task_notifications->fetch_assoc()) {
        $notifications[] = "Task due today: " . $row['tugas'] . " for course " . $row['matkul'] . " due at " . $row['deadline'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Welcome to College Alarm System</h2>
    <div class="mb-4">
        <a href="add_course.php" class="btn btn-primary">Add Course</a>
        <a href="add_task.php" class="btn btn-primary">Add Task</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <h3>Notifications</h3>
    <?php if (count($notifications) > 0) { ?>
        <ul class="list-group mb-4">
            <?php foreach ($notifications as $notification) { ?>
                <li class="list-group-item list-group-item-warning"><?php echo $notification; ?></li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <div class="alert alert-info" role="alert">No notifications at this time.</div>
    <?php } ?>

    <h3>Your Courses</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Course</th>
                <th>Day</th>
                <th>Time</th>
                <th>Room</th>
                <th>Lecturer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_courses->num_rows > 0) {
                while ($row = $result_courses->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['matkul']; ?></td>
                        <td><?php echo $row['hari']; ?></td>
                        <td><?php echo $row['jam']; ?></td>
                        <td><?php echo $row['ruangan']; ?></td>
                        <td><?php echo $row['dosen']; ?></td>
                        <td>
                            <a href="edit_course.php?id=<?php echo $row['id_matkul']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_course.php?id=<?php echo $row['id_matkul']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="6" class="text-center">No courses available.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h3>Your Tasks</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Course</th>
                <th>Description</th>
                <th>Deadline</th>
                <th>Task</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_tasks->num_rows > 0) {
                while ($row = $result_tasks->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['matkul']; ?></td>
                        <td><?php echo $row['deskripsi']; ?></td>
                        <td><?php echo $row['deadline']; ?></td>
                        <td><?php echo $row['tugas']; ?></td>
                        <td>
                            <a href="edit_task.php?id=<?php echo $row['id_tugas']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_task.php?id=<?php echo $row['id_tugas']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="5" class="text-center">No tasks available.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
