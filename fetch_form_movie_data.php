<?php
// Database connection parameters
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

// Get movie ID from the AJAX request
$movieId = $_GET['movie_id'];

// Fetch data for the selected movie from the movies table
$sql = "SELECT date1, date2, date3, time1, time2, time3, time4, `Batti Cinima`, `Yal Cinima`, `Colombo Cinima` FROM movies WHERE id = $movieId";
$result = $conn->query($sql);

$response = array(
    'dates' => array(),
    'times' => array(),
    'locations' => array()
);

if ($result->num_rows > 0) {
    // Output data as JSON response
    $row = $result->fetch_assoc();

    // Populate dates
    if (!empty($row['date1'])) {
        $response['dates'][] = $row['date1'];
    }
    if (!empty($row['date2'])) {
        $response['dates'][] = $row['date2'];
    }
    if (!empty($row['date3'])) {
        $response['dates'][] = $row['date3'];
    }

    // Populate times
    $times = array($row['time1'], $row['time2'], $row['time3'], $row['time4']);
    foreach ($times as $time) {
        if ($time != 'no') {
            $response['times'][] = $time;
        }
    }

    // Populate locations
    $locations = array('Batti Cinima', 'Yal Cinima', 'Colombo Cinima');
    foreach ($locations as $location) {
        if ($row[$location] == 'yes') {
            $response['locations'][] = $location;
        }
    }
}

// Close connection
$conn->close();

// Output JSON response
echo json_encode($response);
?>
