<?php
include 'config.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_matkul = $_POST['id_matkul'];
    $deskripsi = $_POST['deskripsi'];
    $deadline = $_POST['deadline'];
    $tugas = $_POST['tugas'];

    $sql = "INSERT INTO tugas (id_matkul, deskripsi, deadline, tugas) VALUES ('$id_matkul', '$deskripsi', '$deadline', '$tugas')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success' role='alert'>Task added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

$id_user = $_SESSION['id_user'];
$sql = "SELECT * FROM mata_kuliah WHERE id_user='$id_user'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add Task</h2>
    <form method="post">
        <div class="form-group">
            <label for="id_matkul">Mata Kuliah:</label>
            <select class="form-control" id="id_matkul" name="id_matkul" required>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id_matkul']; ?>"><?php echo $row['matkul']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi:</label>
            <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
        </div>
        <div class="form-group">
            <label for="deadline">Deadline:</label>
            <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
        </div>
        <div class="form-group">
            <label for="tugas">Tugas:</label>
            <input type="text" class="form-control" id="tugas" name="tugas" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Task</button>
        <a href="index.php" class="btn btn-secondary">Back to Index</a>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
