<?php
// Enable error reporting for debugging purposes
ini_set('display_errors',  1);
ini_set('display_startup_errors',  1);
error_reporting(E_ALL);

// Set the content type to JSON
header('Content-Type: application/json');

// Include your database connection file
include '../conn.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Your SQL query here
    $sql = "INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`) VALUES (NULL, '$name', '$email', '$password', '$phone', '0')";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        // Return a JSON response indicating success
        echo json_encode(['success' => true]);
    } else {
        // Return a JSON response indicating failure along with an error message
        echo json_encode(['success' => false, 'message' => 'Registration failed. Please try again.']);
    }
}
?>