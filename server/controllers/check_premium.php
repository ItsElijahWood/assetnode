<?php
namespace Server\Controllers;

class CheckPremium {
  private $conn;

  public function __construct($conn) {
    $this->conn = $conn;
  }

  public function isPremium($userId) {
    $stmt = mysqli_prepare($this->conn, "SELECT * FROM accounts WHERE id = ?");

    mysqli_stmt_bind_param($stmt, "i", $userId);
    if (!mysqli_stmt_execute($stmt)) {
      die("Failed to execute check_premium function");
    }
    $result = mysqli_stmt_get_result($stmt);

    $result_assoc = mysqli_fetch_assoc($result);

    // Return true or false depending on the statement from database
    return (bool) $result_assoc['is_premium'];
  }
}
