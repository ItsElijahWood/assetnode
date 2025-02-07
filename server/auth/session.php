<?php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  require_once __DIR__ . "/../database/database.php";  

  $user;

  // Start session if one has not started
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (isset($_SESSION["user_id"])) {
    $user = getDataById($_SESSION["user_id"], $conn);
  } else {
    return $user = null;
  }

  function getDataById($userId, $conn) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM `accounts` WHERE `id` = ?");
    if (!$stmt) {
        error_log("SQL Prepare session failed");
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);

    if (!mysqli_stmt_execute($stmt)) {
        error_log("Failed to execute session");
    }

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $resultData = mysqli_fetch_assoc($result);

        return $resultData ? $resultData : null;
    } 

    mysqli_stmt_close($stmt);
    return null;
  }
?>