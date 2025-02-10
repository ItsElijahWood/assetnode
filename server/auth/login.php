<?php
namespace Server\Auth;

// Fetches database to check login information matches the html form input
class Login
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function authenticate($email, $password)
    {
        header("Content-Type: application/json");
        session_start();

        if (!$email || !$password) {
            return ["failed" => true, "message" => "Email and password are required."];
        }

        $stmt = mysqli_prepare($this->conn, "SELECT * FROM accounts WHERE email = ?");
        if (!$stmt) {
            return ["failed" => true, "message" => "Database query error."];
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 0) {
            return ["failed" => true, "message" => "Account not found."];
        }

        $accounts = mysqli_fetch_assoc($result);

        if (!password_verify($password, $accounts['password'])) {
            return ["failed" => true, "message" => "Invalid Email or password."];
        }

        session_regenerate_id();
        $_SESSION["user_id"] = $accounts["id"];

        return ["failed" => false, "message" => "Login successful"];
    }
}

require __DIR__ . '/../core/database.php';

// Waits for html post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = new Login($conn);

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        echo json_encode(['failed' => true, 'message' => "Email and password are required."]);
        exit;
    }

    $response = $login->authenticate($email, $password);
    echo json_encode($response);
}
