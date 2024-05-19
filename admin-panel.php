<?php
session_start();

// Check if the form has been submitted
if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Replace this with your actual authentication logic
    if($username === "admin" && $password === "admin"){ // Change the admin credentials
        // Authentication successful, set session variable
        $_SESSION['username'] = $username;
        // Redirect to the posterManagement.php page or any other page you want to redirect to after login
        header("Location: posterManagement.php");
        exit(); // Make sure to stop executing the current script after redirection
    } else {
        // Authentication failed, show an error message or redirect to the login page
        echo "Invalid username or password.";
    }
}
?>