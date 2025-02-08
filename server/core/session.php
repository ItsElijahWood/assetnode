<?php
namespace Server\Auth;

// Display all errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "database.php";

class SessionManager
{
    private $conn;
    private $user = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->startSession();
        $this->loadUser();
    }

    private function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function loadUser()
    {
        if (isset($_SESSION["user_id"])) {
            $this->user = $this->getDataById($_SESSION["user_id"]);
        }
    }

    private function getDataById($userId)
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM `accounts` WHERE `id` = ?");
        if (!$stmt) {
            error_log("SQL Prepare session failed");
            return null;
        }

        mysqli_stmt_bind_param($stmt, "i", $userId);

        if (!mysqli_stmt_execute($stmt)) {
            error_log("Failed to execute session");
            return null;
        }

        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }

        mysqli_stmt_close($stmt);
        return null;
    }

    public function getUser()
    {
        return $this->user;
    }
}
