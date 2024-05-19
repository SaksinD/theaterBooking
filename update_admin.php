<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_theater";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$adminId = $_POST['adminId'];
$fullName = $_POST['fullName'];
$adminEmail = $_POST['adminEmail'];
$userName = $_POST['userName'];
$password = $_POST['password'];

// Update admin record in the database
$sql = "UPDATE admin SET FullName='$fullName', AdminEmail='$adminEmail', UserName='$userName', Password='$password' WHERE id=$adminId";

if ($conn->query($sql) === TRUE) {
    header("Location: posterManagement.php");
    exit();
} else {
    echo "Error updating admin record: " . $conn->error;
}

$conn->close();
?>
