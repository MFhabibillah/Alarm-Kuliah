<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update'])) {
    $id_tugas = $_POST['id_tugas'];
    $id_matkul = $_POST['id_matkul'];
    $deskripsi = $_POST['deskripsi'];
    $deadline = $_POST['deadline'];
    $tugas = $_POST['tugas'];

    $sql = "UPDATE tugas SET id_matkul='$id_matkul', deskripsi='$deskripsi', deadline='$deadline', tugas='$tugas' WHERE id_tugas='$id_tugas'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$id_user = $_SESSION['id_user'];
$sql = "SELECT * FROM mata_kuliah WHERE id_user='$id_user'";
$matkul = $conn->query($sql);

$id_tugas = $_GET['id'];
$sql = "SELECT * FROM tugas WHERE id_tugas='$id_tugas'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Task</h2>
    <form action="edit_task.php" method="post">
        <input type="hidden" name="id_tugas" value="<?php echo $row['id_tugas']; ?>">
        <div class="form-group">
        <label for="id_matkul">Mata Kuliah:</label>
            <select class="form-control" id="id_matkul" name="id_matkul" required>
                <?php while ($data = $matkul->fetch_assoc()) { ?>
                    <option value="<?php echo $data['id_matkul']; ?>" <?php if($row['id_matkul'] == $data['id_matkul']) echo "selected"; ?>><?php echo $data['matkul']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="deskripsi">Description</label>
            <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="<?php echo $row['deskripsi']; ?>" required>
        </div>
        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="datetime-local" name="deadline" id="deadline" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($row['deadline'])); ?>" required>
        </div>
        <div class="form-group">
            <label for="tugas">Task</label>
            <input type="text" name="tugas" id="tugas" class="form-control" value="<?php echo $row['tugas']; ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-secondary">Back to Index</a>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
