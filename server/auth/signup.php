<?php
namespace Server\Auth;

require_once __DIR__ . '/../database/database.php';

class Signup
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register($user, $password)
    {
        header('Content-Type: application/json');

        if (!$user || !$password) {
            return ["success" => false, "message" => "User and password fields are empty."];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($this->conn, "INSERT INTO accounts (`username`, `password`) VALUES (?, ?)");
        if (!$stmt) {
            return ["success" => false, "message" => "Prepare database error"];
        }

        mysqli_stmt_bind_param($stmt, "ss", $user, $hashedPassword);

        if (!mysqli_stmt_execute($stmt)) {
            return ["success" => false, "message" => "Failed to execute database query"];
        }

        return ["success" => true, "message" => "Signup successful"];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $signup = new Signup($conn);

    $username = trim($_POST['user'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => "Username and password are required."]);
        exit;
    }

    $response = $signup->register($username, $password);
    echo json_encode($response);
}
