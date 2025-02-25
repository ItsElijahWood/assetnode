<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  header("Content-Type: application/json");

  $requiredFields = ['asset_type', 'asset_make', 'serial_number', 'purchase_date', 'cost', 'depreciation', 'condition'];
  $missingFields = [];

  foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
      $missingFields[] = $field;
    }
  }

  if (!empty($missingFields)) {
    echo json_encode(["success" => false, "message" => "Missing fields: " . implode(", ", $missingFields)]);
    exit();
  }

  require_once __DIR__ . '/../core/database.php';
  require_once __DIR__ . '/../core/db/database_assets.php';
  require_once __DIR__ . '/../core/session.php';

  $userClass = new \Server\Auth\SessionManager($conn);
  $user = $userClass->getUser();
  $db_string = "uid_" . $user['id'];

  $stmt = mysqli_prepare(
    $connAssets,
    "INSERT INTO `$db_string` (`type`, asset_id, asset_type, make, serial_number, 
          purchase_date, warranty_expiration_date, `location`, user_hardware, cost, depreciation, 
          `asset_condition`, mac_address, ip_address, ram, storage_capacity, operating_system) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
  );

  mysqli_stmt_bind_param(
    $stmt,
    "sisssssssdissssss",
    $_POST['asset_category'],
    $_POST['asset_id'],
    $_POST['asset_type'],
    $_POST['asset_make'],
    $_POST['serial_number'],
    $_POST['purchase_date'],
    $_POST['warranty_expiration'],
    $_POST['location'],
    $_POST['assigned_user'],
    $_POST['cost'],
    $_POST['depreciation'],
    $_POST['condition'],
    $_POST['mac_address'],
    $_POST['ip_address'],
    $_POST['ram'],
    $_POST['storage_capacity'],
    $_POST['os']
  );

  if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["success" => true, "message" => "Successfully inserted into database."]);
  } else {
    echo json_encode(["success" => false, "message" => "Error inserting into database."]);
  }
}
