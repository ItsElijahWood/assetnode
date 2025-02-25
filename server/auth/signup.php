<?php

namespace Server\Auth;

use Server\Controllers\Filterwords;

class Signup
{
    private $conn;
    private $connAssets;

    public function __construct($conn, $connAssets)
    {
        $this->conn = $conn;
        $this->connAssets = $connAssets;
    }

    public function createAssetDatabase($email)
    {
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
                asset_id INT NOT NULL,
                asset_type VARCHAR(200) NOT NULL,
                make VARCHAR(200) NOT NULL,
                serial_number VARCHAR(200) NOT NULL,
                purchase_date VARCHAR(200) NOT NULL,
                warranty_expiration_date VARCHAR(200) NOT NULL,
                location VARCHAR(200) NOT NULL,
                cost DOUBLE(10,2) NOT NULL,
                depreciation INT NOT NULL,
                user_hardware VARCHAR(200) NOT NULL,
                asset_condition VARCHAR(200) NOT NULL,
                mac_address VARCHAR(200) NULL,
                ip_address VARCHAR(200) NULL,
                operating_system VARCHAR(200) NULL,
                storage_capacity VARCHAR(200) NULL,
                ram VARCHAR(200) NULL
            );
        ";

        if (!mysqli_query($this->connAssets, $sql)) {
            return ["success" => false, "message" => "Failed to execute database query"];
        }
    }

    public function createAssetPreset($email)
    {
        if (!$email) {
            return ["success" => false, "message" => "All fields are required."];
        }

        $stmt = mysqli_prepare($this->conn, "SELECT id FROM accounts WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);

        if (!mysqli_stmt_execute($stmt)) {
            return ["success" => false, "message" => "Error executing database query."];
        }

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            return ["success" => false, "message" => "User not found."];
        }

        $uid_string = "uid_" . intval($row['id']) . "_preset";

        $sqlCreateTable = "CREATE TABLE `$uid_string` (
            asset_type VARCHAR(255),
            ram VARCHAR(255),
            operating_system VARCHAR(255),
            make VARCHAR(255),
            location_asset VARCHAR(255),
            asset_condition VARCHAR(255)
        )";

        if (!mysqli_query($this->connAssets, $sqlCreateTable)) {
            return ["success" => false, "message" => "Failed to create asset preset table."];
        }

        // Insert default values into the assets table
        $sqlInsertAssets = "INSERT INTO `$uid_string` (asset_type, ram, operating_system, make, location_asset, asset_condition) VALUES
            ('-', '-', '-', '-', '-', '-'),
            ('Desktop', '2', 'Android', 'Acer', 'Basement', 'Unrepairable'),
            ('Laptop', '4', 'ChromeOS', 'Apple', 'Dining Room', 'Broken'),  
            ('Monitor', '6', 'iOS', 'Asus', 'Entrance', 'Poor'),        
            ('Phone', '8', 'Linux', 'Epson', 'Garage', 'Fair'),
            ('Projector', '16', 'macOS', 'Fujitsu', 'Kitchen', 'Good'),
            ('Server', '32', 'Windows', 'Google', 'Lounge', 'Excellent'),
            ('Switch', '64', '', 'HP', 'Office', ''),
            ('Tablet', '128', '', 'MSI', 'Meeting Room', ''),
            ('UPS', '256', '', 'Microsoft', 'Study Room', '')";

        if (!mysqli_query($this->connAssets, $sqlInsertAssets)) {
            return ["success" => false, "message" => "Failed to insert default assets."];
        }

        return ["success" => true, "message" => "Asset preset created successfully."];
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
require_once __DIR__ . '/../core/db/database_assets.php';
require_once __DIR__ . '/../controllers/filter_words.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $signup = new Signup($conn, $connAssets);
    $filter = new Filterwords();

    $username = trim($_POST['user'] ?? '');
    if ($filter->filterText($username)) {
        echo json_encode(['success' => false, 'message' => "Inappropriate name."]);
        exit();
    }

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => "All fields are required."]);
        exit;
    }

    $response = $signup->register($username, $email, $password);
    $signup->createAssetDatabase($email);
    $signup->createAssetPreset($email);

    echo json_encode($response);
}
