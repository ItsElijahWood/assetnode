<?php
    require_once __DIR__  . '/../database/database.php';
    header('Content-Type: application/json');

    $user = $_POST['user'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$user || !$password) {
        echo json_encode([ "message" => "User and password fields are empty."]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO accounts (`username`, `password`) VALUES (?, ?)");
    if (!$stmt) {
        echo json_encode([ "message" => "Prepare database error"]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "ss", $user, $hashedPassword);

    if (!mysqli_stmt_execute($stmt)) {
        echo json_encode([ "message" => "Failed to execute database query"]);
        exit;
    }

    echo json_encode([ "message" => "Signup successful" ]);
?>
