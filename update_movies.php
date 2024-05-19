<?php
// Assuming you have already defined your database connection parameters
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

// Process form submission and update movie details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['editMovieId'];
    $movieName = $_POST['editMovieName'];
    $date1 = $_POST['editDate1'];
    $date2 = $_POST['editDate2'];
    $date3 = $_POST['editDate3'];
    $time1 = $_POST['editTime1'];
    $time2 = $_POST['editTime2'];
    $time3 = $_POST['editTime3'];
    $time4 = $_POST['editTime4'];
    $battiCinema = $_POST['editBattiCinema'];
    $yalCinema = $_POST['editYalCinema'];
    $colomboCinema = $_POST['editColomboCinema'];

    // Update the movie details in the database using prepared statements
    $stmt = $conn->prepare("UPDATE movies SET 
        movie_name=?, 
        date1=?, 
        date2=?, 
        date3=?, 
        time1=?, 
        time2=?, 
        time3=?, 
        time4=?, 
        `Batti Cinima`=?, 
        `Yal Cinima`=?, 
        `Colombo Cinima`=? 
        WHERE id=?");

    $stmt->bind_param("sssssssssssi", 
        $movieName, 
        $date1, 
        $date2, 
        $date3, 
        $time1, 
        $time2, 
        $time3, 
        $time4, 
        $battiCinema, 
        $yalCinema, 
        $colomboCinema, 
        $id);

        if ($stmt->execute()) {
            // Updated successfully, redirect to posterManagement.php
            header("Location: posterManagement.php");
            exit(); // Stop further execution
        } else {
            // Error occurred, handle accordingly
            echo "Error updating movie: " . $conn->error;
        }
}

// Close the database connection
$conn->close();
?>
