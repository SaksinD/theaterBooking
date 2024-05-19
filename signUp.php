<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Example</title>
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <script>
        function validatePassword() {
            const password = document.getElementById('password').value;
            const passwordErr = document.getElementById('passwordErr');

            const hasNumber = /\d/.test(password);
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);
            const len = password.len;

            if (!(hasNumber && hasUpperCase && hasLowerCase && hasSpecialChar) && !(len >= 8)) {
                passwordErr.innerHTML = 'Password must contain at least one number, one capital letter, one simple letter, and one special character.';
                return false;
            } else {
                passwordErr.innerHTML = '';
                return true;
            }
        }
    </script>
    <style>
        .error-message {
            color: red;
        }
        
    </style>
</head>

<body>
<?php
session_start();

$thispage = htmlspecialchars($_SERVER["PHP_SELF"]);

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

$name = "";
$email = "";
$password = ""; // Added to define the variable
$sameemailerr = $nameErr = $emailErr = $passwordErr = ""; // Corrected variable name
$sameEMAIL = false;
$errorFound = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    if (empty($_POST["name"])) {
        $nameErr = "Please enter your name";
        $errorFound = true;
    } else {
        $name = $_POST["name"];
    }

    if (empty($_POST["email"])) {
        $emailErr = "Please enter your email";
        $errorFound = true;
    } else {
        $email = $_POST["email"];
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Please enter a valid password";
        $errorFound = true;
    } else {
        $password = $_POST["password"];
    }

    if (!$errorFound) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result !== false) {
            if ($result->num_rows > 0) {
                $_SESSION["sameemail"] = true; // Set session variable to indicate same email
                header("Location: signUp.php"); // Redirect to signUp.php
                exit();
            } else {
                $sql = "INSERT INTO users (email, username, password) VALUES ('$email', '$name', '$password')";
                if ($conn->query($sql) === TRUE) {
                    $_SESSION["success"] = true;
                    header("Location: admin-login.php");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        } else {
            echo "Error executing SQL: " . $conn->error;
        }
    }
}

// Check if sameemail session variable is set and true, then show alert
if (isset($_SESSION["sameemail"]) && $_SESSION["sameemail"]) {
    echo "<script>alert('You have an account. Click \"I am already a member\" to login!');</script>";
    unset($_SESSION["sameemail"]); // Reset the session variable
}

$conn->close();
?>


<!--<div class="form-container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter your name">
        <span class="error-message"><?php echo $nameErr; ?></span>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter your email">
        <span class="error-message"><?php echo $emailErr; ?></span>
        <span class="error-message" name="sameEmail"><?php echo $sameEMAIL; ?></span>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>" placeholder="Enter a strong password">
        <span class="error-message"><?php echo $passwordErr; ?></span><br>

        <button type="submit">Submit</button>
    </form>-->

<div class="main">
    <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="register-form" id="register-form">
                        <span class="error-message"><?php echo $sameemailerr; ?></span>
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Your Name"/>
                                <span class="error-message"><?php echo $nameErr; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Your Email"/>
                                <span class="error-message" ><?php echo $emailErr; ?></span>
                                <span class="error-message" name="sameEmail"><?php echo $sameEMAIL; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>" placeholder="Password"/>
                                <span class="error-message" ><?php echo $passwordErr; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="terms.html" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/example-4.png" alt="sing up image"></figure>
                        <a href="admin-login.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>
        
<script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</div>

        




</div>


</body>

</html>