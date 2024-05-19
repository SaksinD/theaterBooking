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

$fullname = $_POST['fullname'];
$nic = $_POST['nic'];
$phonenumber = $_POST['phonenumber'];
$selectedSeats = $_POST['selectedSeats'];

$sql = "INSERT INTO BookingDetails (FullName, NIC, PhoneNumber, Seats) VALUES ('$fullname', '$nic', '$phonenumber', '$selectedSeats')";

if ($conn->query($sql) === TRUE) {
    echo "Booking successful";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
