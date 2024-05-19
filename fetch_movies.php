<?php
// Database connection parameters
$servername = "localhost"; // Change this to your MySQL server's hostname or IP address
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "movie_theater";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the movies table
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);

// Prepare an array to store the fetched data
$movies = array();

if ($result->num_rows > 0) {
    // Fetch each row of the result set
    while ($row = $result->fetch_assoc()) {
        // Add each row to the movies array
        $movies[] = $row;
    }
}

// Close the database connection
$conn->close();

// Send the data as JSON
header('Content-Type: application/json');
echo json_encode($movies);
?>
