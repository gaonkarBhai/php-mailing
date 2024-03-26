<?php
// Set the content type to JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST,GET');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');

// Include your database connection file
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `tasks` WHERE `id` = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'data' => $row]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['taskId'];
    if (!empty($_POST['category'])) {
        $category = $_POST['category'];
        // Handle the "DONE" category
        if ($category == "DONE") {
            $sql = "UPDATE tasks SET belong='$category' WHERE id='$id' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                // Fetch the user_id associated with the task
                $taskQuery = mysqli_query($conn, "SELECT pid FROM `tasks` WHERE `id` = $id");
                if (mysqli_num_rows($taskQuery) > 0) {
                    $taskResult = mysqli_fetch_assoc($taskQuery);
                    $user_id = $taskResult['pid']; // Assuming the column name is 'user_id'

                    // Query to fetch user details using the user_id
                    $userQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = $user_id");
                    if (mysqli_num_rows($userQuery) > 0) {
                        $userResult = mysqli_fetch_assoc($userQuery);
                        $receiver = $userResult['email'];
                        $username = $userResult['name'];

                        // Email configuration
                        $from = "info@crisscrosstamizh.in";
                        $subject = "Your task has been Reviewed";
                        $message = "Hello $username,<br><br>Nice work.<br><br>Your work has been selected and marked as done.<br><br>Check the dashboard for more info<br><br>Thanks,<br>CrissCrossTamizh Team<br>";

                        // Email headers
                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'From: ' . $from . "\r\n";

                        // Send email
                        if (mail($receiver, $subject, $message, $headers)) {
                            echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Failed to send email']);
                        }
                    }
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'task not moved.']);
            }
        }

        // Handle the "REVIEW" category
        elseif ($category == "REVIEW") {
            $sql = "UPDATE tasks SET belong='$category' WHERE id='$id' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                // Fetch all users with role 1
                $userQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE `role` = 1");
                if (mysqli_num_rows($userQuery) > 0) {
                    while ($userResult = mysqli_fetch_assoc($userQuery)) {
                        $receiver = $userResult['email'];
                        $username = $userResult['name'];

                        // Email configuration
                        $from = "your_domain";
                        $subject = "A task is ready for review";
                        $message = "Hello $username,<br><br>A new task is ready for review.<br><br>Check the dashboard for more info<br><br>Thanks,<br>SIT Team<br>Tumkur";

                        // Email headers
                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'From: ' . $from . "\r\n";

                        // Send email
                        if (mail($receiver, $subject, $message, $headers)) {
                            // Email sent successfully
                            echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
                            // Exit after sending the email
                            exit();
                        } else {
                            // Email sending failed
                            echo json_encode(['success' => false, 'message' => 'Failed to send email']);
                            // Exit after sending the email
                            exit();
                        }
                    }
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'task not moved.']);
            }
        }


        // for progress
        $sql = "UPDATE tasks SET belong='$category' WHERE id='$id' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'successfully moved']);
        } else {
            echo json_encode(['success' => false, 'message' => 'failed to  move']);
        }
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $sql = "UPDATE tasks SET title='$title', description='$description' WHERE id='$id' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $taskQuery = mysqli_query($conn, "SELECT pid FROM `tasks` WHERE `id` = $id");
            if (mysqli_num_rows($taskQuery) > 0) {
                $taskResult = mysqli_fetch_assoc($taskQuery);
                $user_id = $taskResult['pid']; // Assuming the column name is 'user_id'

                // Query to fetch user details using the user_id
                $userQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = $user_id");
                if (mysqli_num_rows($userQuery) > 0) {
                    $userResult = mysqli_fetch_assoc($userQuery);
                    $receiver = $userResult['email'];
                    $username = $userResult['name'];

                    // Email configuration
                    $from = "your_domain";
                    $subject = "Your task has been Updated";
                    $message = "Hello $username,<br><br>Work Update.<br><br>Your work has been Updated.<br><br>Check the dashboard for more info<br><br>Thanks,<br>SIT Team<br>TUMKUR";

                    // Email headers
                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: ' . $from . "\r\n";

                    // Send email
                    if (mail($receiver, $subject, $message, $headers)) {
                        echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
                        exit; // Exit script after sending JSON response
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to send email']);
                        exit; // Exit script after sending JSON response
                    }
                }
            }
            echo json_encode(['success' => true, 'message' => 'Task updated']);
            exit; // Exit script after sending JSON response
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update task']);
            exit; // Exit script after sending JSON response
        }
    }
}
