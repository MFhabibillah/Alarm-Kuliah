// add_course.php
<?php
include 'config.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matkul = $_POST['matkul'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $ruangan = $_POST['ruangan'];
    $dosen = $_POST['dosen'];
    $id_user = $_SESSION['id_user'];

    $sql = "INSERT INTO mata_kuliah (matkul, hari, jam, ruangan, dosen, id_user) VALUES ('$matkul', '$hari', '$jam', '$ruangan', '$dosen', '$id_user')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success' role='alert'>Course added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add Course</h2>
    <form method="post">
        <div class="form-group">
            <label for="matkul">Mata Kuliah:</label>
            <input type="text" class="form-control" id="matkul" name="matkul" required>
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
            <label for="jam">Jam:</label>
            <input type="time" class="form-control" id="jam" name="jam" required>
        </div>
        <div class="form-group">
            <label for="ruangan">Ruangan:</label>
            <input type="text" class="form-control" id="ruangan" name="ruangan" required>
        </div>
        <div class="form-group">
            <label for="dosen">Dosen:</label>
            <input type="text" class="form-control" id="dosen" name="dosen" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Course</button>
        <a href="index.php" class="btn btn-secondary">Back to Index</a>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>