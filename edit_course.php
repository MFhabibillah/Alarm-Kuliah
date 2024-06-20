<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update'])) {
    $id_matkul = $_POST['id_matkul'];
    $matkul = $_POST['matkul'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $ruangan = $_POST['ruangan'];
    $dosen = $_POST['dosen'];

    $sql = "UPDATE mata_kuliah SET matkul='$matkul', hari='$hari', jam='$jam', ruangan='$ruangan', dosen='$dosen' WHERE id_matkul='$id_matkul'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$id_matkul = $_GET['id'];
$sql = "SELECT * FROM mata_kuliah WHERE id_matkul='$id_matkul'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Course</h2>
    <form action="edit_course.php" method="post">
        <input type="hidden" name="id_matkul" value="<?php echo $row['id_matkul']; ?>">
        <div class="form-group">
            <label for="matkul">Course</label>
            <input type="text" name="matkul" id="matkul" class="form-control" value="<?php echo $row['matkul']; ?>" required>
        </div>
        <div class="form-group">
            <label for="hari">Hari:</label>
            <select class="form-control" id="hari" name="hari" required>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
        </div>
        <div class="form-group">
            <label for="jam">Time</label>
            <input type="time" name="jam" id="jam" class="form-control" value="<?php echo $row['jam']; ?>" required>
        </div>
        <div class="form-group">
            <label for="ruangan">Room</label>
            <input type="text" name="ruangan" id="ruangan" class="form-control" value="<?php echo $row['ruangan']; ?>" required>
        </div>
        <div class="form-group">
            <label for="dosen">Lecturer</label>
            <input type="text" name="dosen" id="dosen" class="form-control" value="<?php echo $row['dosen']; ?>" required>
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
