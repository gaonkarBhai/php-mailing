<?php
session_start();

include '../conn.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT name,email,password,phone,role,id FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['phone'] = $row['phone'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['id'] = $row['id'];
        echo json_encode(['success' => true,'role'=>$row['role']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    }
}
