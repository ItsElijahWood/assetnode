<?php
    require_once __DIR__ . '/../database/database.php';
    header("Content-Type: application/json");

    $user = $_POST['user'] ?? null;
    $password = $_POST['password'] ?? null;

    session_start();

    if (!$user || !$password) {
        echo json_encode(["message" => "Username and password are required."]);
        exit;
    }

    $stmt = mysqli_prepare($conn, "SELECT * FROM accounts WHERE username = ?");
    if (!$stmt) {
        echo json_encode(["message" => "Database query error."]);
        exit;
    }
    
    // Bind paramater to database to return result
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 0) {
        echo json_encode(["message" => "Invalid username or password."]);
        exit;
    }
    
    $accounts = mysqli_fetch_assoc($result);

    if (!password_verify($password, $accounts['password'])) {
        echo json_encode(["message" => "Invalid username or password."]);
        exit;
    }

    // Generate session id and put database info into session globar var
    session_regenerate_id();
    // Fetches more info at session.php
    $_SESSION["user_id"] = $accounts["id"];

    echo json_encode(["message" => "Login successful"]);
?>
