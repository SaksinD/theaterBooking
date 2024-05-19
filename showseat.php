<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    // Connect to database
    $servername = "localhost";
    $username = "root";
    $password = ""; // Change this to your database password if it's set
    $dbname = "movie_theater";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user's name from the database using their email
    $email = $_SESSION['email'];
    $userSql = "SELECT * FROM users WHERE email = '$email'";
    $userResult = $conn->query($userSql);

    if ($userResult->num_rows == 1) {
        $row = $userResult->fetch_assoc();
        $userName = $row['username']; // Assuming the column name in the database is 'username'
    } else {
        // If user not found (this should not happen if the email is properly set in the session)
        $userName = "Guest";
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $fullName = $_POST['fullname'] ?? '';
        $nic = $_POST['nic'] ?? '';
        $phoneNumber = $_POST['phonenumber'] ?? '';
        $selectedSeats = $_POST['selectedSeats'] ?? '';

        // Validate form data (add your validation logic here)

        // Calculate total fare
        $selectedSeatIds = explode(',', $selectedSeats);
        $groundFloorPrice = 400;
        $balconyPrice = 600;
        $groundFloorSeatsCount = 0;
        $balconySeatsCount = 0;

        foreach ($selectedSeatIds as $seatId) {
            if ($seatId <= 80) {
                $groundFloorSeatsCount++;
            } else {
                $balconySeatsCount++;
            }
        }

        $totalFare = ($groundFloorSeatsCount * $groundFloorPrice) + ($balconySeatsCount * $balconyPrice);

        // Insert booking details into database
        $sql = "INSERT INTO BookingDetails (FullName, NIC, PhoneNumber, Seats, SeatFare, BookingStatus) 
                VALUES ('$fullName', '$nic', '$phoneNumber', '$selectedSeats', '$totalFare', 'No')";

        if ($conn->query($sql) === TRUE) {
            // Store form data in session for use in summary page
            $_SESSION['booking_data'] = [
                'fullName' => $fullName,
                'nic' => $nic,
                'phoneNumber' => $phoneNumber,
                'selectedSeats' => $selectedSeats,
                'totalFare' => $totalFare
            ];

            // Redirect to summary page if insertion is successful
            header("Location: summaryofpayment.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
} else {
    // If user is not logged in
    $userName = "Guest";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Movie Theater Booking</title>
<link rel="stylesheet" href="styles.css">
<style>

.topBar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: black;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 40px;
            z-index: 1000;
            height: 90px;
        }



        #logo {
            padding-bottom: 20px;
            width: 100px;
            height: 75px;
        }

        #logo img {
            width: 100%;
            /* Make sure the image fills the container */
            height: auto;
            /* Maintain aspect ratio */
        }

        .sign-log {
            padding-bottom: 25px;
            display: inline-flex;
        }

        #admin-login {
            text-decoration: none;
            color: #0CE7EB;
            border-color: #0CE7EB;
            font-weight: bold;
            display: inline-block;
            padding: 5px 20px;
            margin-top: 40px;
            text-align: center;
        }

        #admin-signup {
            margin-right: 10px;
            background-color: #0CE7EB;
            color: #FC3066;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            padding: 5px 20px;
            margin-top: 40px;
            text-align: center;
            
        }

        #admin-signup :hover {
            color: #0CE7EB;
        }

        #admin-login:hover {
            color: #FC3066;
            background-color: #0CE7EB;
            border-color: #FC3066;
        }

.header {
    padding-bottom: 25px;
}

.selected {
    background-color: green;
}

.booked {
    background-color: red;
}

#booking-form {
    display: none; /* Initially hide the form */
}
</style>
</head>
<body>

<header>
<div class="topBar">
        <a href="#" id="logo"><img src="./images/logo.png" /> </a>
        <div class="sign-log">
            <a href="signUp.php" id="admin-signup" class="btn btn-outline">Sign Up</a>
            <a href="admin-login.php" id="admin-login" class="btn btn-outline" target="_blank">Login</a>
        </div>
    </div>

</header>


<div id="seat-selection">
    <div class="floor-seats">
        <h2>Ground Floor Seats</h2>
        <?php
        // PHP code to fetch seat status from database and generate HTML
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

        $sql = "SELECT SeatID, BookingStatus FROM SeatStatus WHERE ID BETWEEN 1 AND 80";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $seatID = $row["SeatID"];
                $status = $row["BookingStatus"];
                $class = $status == 'booked' ? 'booked' : '';
                echo "<div class='seat floor-seats $class' data-seat-id='$seatID'>$seatID</div>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </div>
    <div class="balcony-seats">
        <h2>Balcony Seats</h2>
        <?php
        // PHP code to fetch seat status from database and generate HTML
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT SeatID, BookingStatus FROM SeatStatus WHERE ID BETWEEN 81 AND 100";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $seatID = $row["SeatID"];
                $status = $row["BookingStatus"];
                $class = $status == 'booked' ? 'booked' : '';
                echo "<div class='seat balcony-seats $class' data-seat-id='$seatID'>$seatID</div>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
        <div id="booking-form">
            <h2>Give your booking details</h2>
            <form id="booking-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="text" id="fullname" name="fullname" placeholder="Full Name" required>
                <input type="text" id="nic" name="nic" placeholder="NIC" required>
                <input type="text" id="phonenumber" name="phonenumber" placeholder="Phone Number" required>
                <input type="hidden" id="selected-seats" name="selectedSeats">
                <!-- Add hidden input fields for selected date, time, and location -->
        <input type="hidden" id="selected-date" name="selectedDate">
        <input type="hidden" id="selected-time" name="selectedTime">
        <input type="hidden" id="selected-location" name="selectedLocation">
                <button type="submit">Pay Now</button>
            </form>
        </div>
    </div>
</div>


<script>
    const seats = document.querySelectorAll('.seat');
    const bookingForm = document.getElementById('booking-form');

    seats.forEach(seat => {
        seat.addEventListener('click', () => {
            if (!seat.classList.contains('booked')) {
                seat.classList.toggle('selected');
                updateSelectedSeats();
                toggleBookingForm();
            }
        });
    });

    function updateSelectedSeats() {
        const selectedSeats = [];
        document.querySelectorAll('.selected').forEach(seat => {
            selectedSeats.push(seat.dataset.seatId);
        });
        document.getElementById('selected-seats').value = selectedSeats.join(',');
    }

    function toggleBookingForm() {
        const selectedSeatsCount = document.querySelectorAll('.selected').length;
        if (selectedSeatsCount > 0) {
            bookingForm.style.display = 'block';
        } else {
            bookingForm.style.display = 'none';
        }
    }
</script>

</body>
</html>
