<?php
namespace Server\Auth;

class Signup
{
    private $conn;
    private $connAssets;

    public function __construct($conn, $connAssets)
    {
        $this->conn = $conn;
        $this->connAssets = $connAssets;
    }

    public function createAssetDatabase($email) {
        if (!$email) {
            return ["success" => false, "message" => "All fields are required."];
        }

        $stmt = mysqli_prepare($this->conn, "SELECT * FROM accounts WHERE email = ?");

        mysqli_stmt_bind_param($stmt, "s", $email);

        if (!mysqli_stmt_execute($stmt)) {
            return ["success" => false, "message" => "Error executing database query."];
        }

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        $uid_string = "uid_" . $row['id'];
        $sql = "
            CREATE TABLE IF NOT EXISTS `$uid_string` (
                type VARCHAR(200) NOT NULL,
                asset_type VARCHAR(200) NOT NULL,
                make VARCHAR(200) NOT NULL,
                serial_number VARCHAR(200) NOT NULL,
                purchase_date VARCHAR(200) NOT NULL,
                warranty_expiration_date VARCHAR(200) NOT NULL,
                assigned_user VARCHAR(200) NOT NULL,
                location VARCHAR(200) NOT NULL,
                cost INT(200) NOT NULL,
                asset_condition VARCHAR(200) NOT NULL,
                maintenance_history VARCHAR(200) NOT NULL,
                mac_address VARCHAR(200) NOT NULL,
                operating_system VARCHAR(200) NOT NULL,
                storage_capacity VARCHAR(200) NOT NULL,
                ram VARCHAR(200) NOT NULL
            );
        ";
        
        if (!mysqli_query($this->connAssets, $sql)) {
            return ["success" => false, "message" => "Failed to execute database query"];
        }
    }

    public function register($user, $email, $password)
    {
        header('Content-Type: application/json');

        if (!$user || !$email || !$password) {
            return ["success" => false, "message" => "All fields are required."];
        }

        $stmt = mysqli_prepare($this->conn, "SELECT * FROM accounts WHERE email = ?");
        if (!$stmt) {
            return ["success" => false, "message" => "Prepare database error"];
        }

        mysqli_stmt_bind_param($stmt, "s", $email);

        if (!mysqli_stmt_execute($stmt)) {
            return ["success" => false, "message" => "Failed to execute database query"];
        }

        $result = mysqli_stmt_get_result($stmt);

        // If a user with the same email already exists, return a message
        if (mysqli_num_rows($result) > 0) {
            return ["success" => false, "message" => "Email already in use."];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($this->conn, "INSERT INTO accounts (`username`, `email`, `password`) VALUES (?, ?, ?)");
        if (!$stmt) {
            return ["success" => false, "message" => "Prepare database error"];
        }

        mysqli_stmt_bind_param($stmt, "sss", $user, $email, $hashedPassword);

        if (!mysqli_stmt_execute($stmt)) {
            return ["success" => false, "message" => "Failed to execute database query"];
        }

        return ["success" => true, "message" => "Signup successful"];
    }
}

require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/db/database_static.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $signup = new Signup($conn, $connAssets);

    $username = trim($_POST['user'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => "All fields are required."]);
        exit;
    }

    $response = $signup->register($username, $email, $password);
    $signup->createAssetDatabase($email);

    echo json_encode($response);
}
