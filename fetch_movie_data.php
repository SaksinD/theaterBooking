<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_theater";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$movieId = $_GET['movieId'];

$sql = "SELECT * FROM movies WHERE id = $movieId";
$result = $conn->query($sql);

$response = array(
    'dates' => array(),
    'times' => array(),
    'locations' => array()
);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Populate dates array
    if (!empty($row['date1'])) {
        $response['dates'][] = $row['date1'];
    }
    if (!empty($row['date2'])) {
        $response['dates'][] = $row['date2'];
    }
    if (!empty($row['date3'])) {
        $response['dates'][] = $row['date3'];
    }

    // Populate times array
    $times = array($row['time1'], $row['time2'], $row['time3'], $row['time4']);
    foreach ($times as $time) {
        if ($time != 'no') {
            $response['times'][] = $time;
        }
    }

    // Populate locations array
    $locations = array('Batti Cinima', 'Yal Cinima', 'Colombo Cinima');
    foreach ($locations as $location) {
        if ($row[$location] == 'yes') {
            $response['locations'][] = $location;
        }
    }
}

$conn->close();

echo json_encode($response);
?>
