<?php
session_start();

$email = $password = $invalidmessage = ""; // Initialize variables
$emailErr = $passwordErr = ""; // Initialize error variables
$errorFound = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email)) {
        $emailErr = "Please enter your email";
        $errorFound = true;
    }

    if (empty($password)) {
        $passwordErr = "Please enter a valid password";
        $errorFound = true;
    }

    if (!$errorFound) {
        // Connect to database
        $servername = "localhost";
        $username = "root";
        $dbpassword = ""; // Changed variable name to avoid conflict
        $dbname = "movie_theater";

        $conn = new mysqli($servername, $username, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute SQL statement to check if email and password exist for users
        $userSql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $userResult = $conn->query($userSql);

        // Check if the user login is successful
        if ($userResult->num_rows == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email; // Store email in session for later use if needed
            header("Location: login_user.php");
            exit();
        }

        // Prepare and execute SQL statement to check if email and password exist for admins
        $adminSql = "SELECT * FROM admin WHERE AdminEmail = '$email' AND Password = '$password'";
        $adminResult = $conn->query($adminSql);

        // Check if the admin login is successful
        if ($adminResult->num_rows == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['admin'] = $email; // Store admin email in session for later use if needed
            header("Location: posterManagement.php");
            exit();
        }

        // If neither user nor admin login is successful
        $invalidmessage = "Invalid email or password.";

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        
       
    </style>
</head>
<body>

<!-- <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <span><?php echo $invalidmessage; ?></span>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter your email">
    <span><?php echo $emailErr; ?></span>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>" placeholder="Enter your password">
    <span><?php echo $passwordErr; ?></span><br>

    <button type="submit">Submit</button>
</form>-->


<div class="main">

        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/example-1.png" alt="sing up image"></figure>
                        <a href="signUp.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign up</h2>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="register-form" id="login-form">
                        <span><?php echo $invalidmessage; ?></span>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                        <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>

</body>
</html>
