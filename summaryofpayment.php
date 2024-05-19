<?php
session_start();

// Database connection
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all form fields are set and not empty
    if (!empty($_POST['cardNumber']) && !empty($_POST['expiryMonth']) && !empty($_POST['expiryYear']) && !empty($_POST['cvc'])) {
        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO CardPayment (CardNumber, ExpiryMonth, ExpiryYear, CVC) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $cardNumber, $expiryMonth, $expiryYear, $cvc);

        // Set parameters and execute statement
        $cardNumber = $_POST['cardNumber'];
        $expiryMonth = $_POST['expiryMonth'];
        $expiryYear = $_POST['expiryYear'];
        $cvc = $_POST['cvc'];
        $stmt->execute();

        // Close statement
        $stmt->close();

        // Redirect to a success page or do further processing
        // For example:
        // header("Location: success.php");
        // exit();
    } else {
        echo "All form fields are required.";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Summary</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="mt-4">Payment Summary</h1>

    <div class="row mt-4">
        <!-- Left side: Booking Summary -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Booking Summary - UP CINEMA.COM</h5>
                    <?php
                    // Check if booking data exists in session
                    if (isset($_SESSION['booking_data'])) {
                        // Retrieve booking data from session
                        $bookingData = $_SESSION['booking_data'];
                        $fullName = $bookingData['fullName'] ?? '';
                        $nic = $bookingData['nic'] ?? '';
                        $phoneNumber = $bookingData['phoneNumber'] ?? '';
                        $selectedSeats = $bookingData['selectedSeats'] ?? '';
                        $totalFare = $bookingData['totalFare'] ?? '';

                        // Display the payment details
                        echo "<p><strong>Full Name:</strong> $fullName</p>";
                        echo "<p><strong>NIC:</strong> $nic</p>";
                        echo "<p><strong>Phone Number:</strong> $phoneNumber</p>";
                        echo "<p><strong>Selected Seats:</strong> $selectedSeats</p>";
                        echo "<p><strong>Total Fare:</strong> $totalFare</p>";
                    } else {
                        echo "<p>No booking data found.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Right side: Card Payment Form -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card Payment</h5>
                    <form id="paymentForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="form-group">
                            <label for="cardNumber">Card Number</label>
                            <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="Enter card number" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="expiryMonth">Expiry Month</label>
                                <input type="text" class="form-control" id="expiryMonth" name="expiryMonth" placeholder="MM" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="expiryYear">Expiry Year</label>
                                <input type="text" class="form-control" id="expiryYear" name="expiryYear" placeholder="YYYY" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cvc">CVC</label>
                            <input type="text" class="form-control" id="cvc" name="cvc" placeholder="CVC" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript and jQuery (required for modal) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    // When the document is ready
    $(document).ready(function(){
        // When the form is submitted
        $('#paymentForm').submit(function(e){
            // Prevent the default form submission
            e.preventDefault();
            // Show the success message in a modal
            $('#successModal').modal('show');
        });
    });
</script>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Payment Successful</h5>
                
            </div>
            <div class="modal-body">
                Your payment was successful. Thank you!
            </div>
            <div class="modal-footer">
    <button type="button" class="btn btn-secondary" onclick="window.location.href = 'index.php';">Close</button>
</div>

        </div>
    </div>
</div>

</body>
</html>
