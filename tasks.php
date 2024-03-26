<?php
// Set the content type to JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');

// Include your database connection file
include './conn.php';

try {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $pid = (int)$_POST['pid'];
        $belong = $_POST['belong'];
        if (empty($name) || empty($title) || empty($description) || empty($pid) || empty($belong)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit;
        }
        // Your SQL query here
        $sql = "INSERT INTO `tasks` (`id`, `name`, `title`, `description`, `pid`, `belong`) VALUES (NULL, '$name', '$title', '$description','$pid', '$belong')";
        $result = mysqli_query($conn, $sql);

        // fetch user email basedon pid
        $user = "SELECT * FROM `users` WHERE `id` = $pid";
        $userQuery = mysqli_query($conn, $user);
        $userResult = mysqli_fetch_assoc($userQuery);
        if ($userResult !== null) {
            $receiver = $userResult['email'];
            $sub = $userResult['name'] . " you got a new task from SIT ";
            $msg = "Hello " . $userResult['name'] . ",<br><br> You got a new task from SIT. <br><br> Task Title: " . $title . "<br>Task Description: " . $description . "<br><br>Check the dashboard for more info <br><br>Thanks,<br>SIT Team<br>Tumkur";

                $from = "your_domain";
                $subject = $sub;
                $to = $receiver;
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: ' . $from . "\r\n";
                if (mail($to, $subject, $msg, $headers)) {
                    echo json_encode(['success' => true]);
                } else {
                    $error = error_get_last();
                    echo json_encode(['success' => false, 'message' => 'Failed to send email: ' . $error['message']]);
                }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error occurred: ' . $e->getMessage()]);
}
