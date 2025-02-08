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

    public function authenticate($user, $password)
    {
        header("Content-Type: application/json");
        session_start();

        if (!$user || !$password) {
            return ["success" => false, "message" => "Username and password are required."];
        }

        $stmt = mysqli_prepare($this->conn, "SELECT * FROM accounts WHERE username = ?");
        if (!$stmt) {
            return ["success" => false, "message" => "Database query error."];
        }

        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 0) {
            return ["success" => false, "message" => "Invalid username or password."];
        }

        $accounts = mysqli_fetch_assoc($result);

        if (!password_verify($password, $accounts['password'])) {
            return ["success" => false, "message" => "Invalid username or password."];
        }

        session_regenerate_id();
        $_SESSION["user_id"] = $accounts["id"];

        return ["success" => true, "message" => "Login successful"];
    }
}

require __DIR__ . '/../core/database.php';

// Waits for html post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = new Login($conn);

    $username = trim($_POST['user'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => "Username and password are required."]);
        exit;
    }

    $response = $login->authenticate($username, $password);
    echo json_encode($response);
}
