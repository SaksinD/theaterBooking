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

// If the form is submitted to add a new poster
if(isset($_POST['submit'])) {
    $name = $_POST['name'];

    // File upload
    $target_dir = "./images/movieImages/";
    $target_file = $target_dir . basename($_FILES["poster"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["poster"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        exit;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        exit;
    }

    // Check file size
    if ($_FILES["poster"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        exit;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        exit;
    }

    // If everything is ok, try to upload file
    if (move_uploaded_file($_FILES["poster"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["poster"]["name"])) . " has been uploaded.";

        $poster = file_get_contents($target_file);

        // Prepare an insert statement
        $sql = "INSERT INTO movieImages (name, poster) VALUES (?, ?)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $poster);

        // Insert
        $stmt->execute();

        echo "<br><br><a href='admin_upload.php'>Back to Upload Page</a>";

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
// If the form is submitted to edit an existing poster
elseif(isset($_POST['edit'])) {
    $name = $_POST['name'];
    $posterId = $_POST['posterId'];

    // File upload
    $target_dir = "./images/movieImages/";
    $target_file = $target_dir . basename($_FILES["poster"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["poster"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        exit;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        exit;
    }

    // Check file size
    if ($_FILES["poster"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        exit;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        exit;
    }

    // If everything is ok, try to upload file
    if (move_uploaded_file($_FILES["poster"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["poster"]["name"])) . " has been uploaded.";

        $poster = file_get_contents($target_file);

        // Prepare an update statement
        $sql = "UPDATE movieImages SET name=?, poster=? WHERE id=?";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $poster, $posterId);

        // Update
        $stmt->execute();

        echo "<br><br><a href='posterManagement.php'>Back to Poster Management Page</a>";

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

header("Location: posterManagement.php");

$conn->close();
?>
