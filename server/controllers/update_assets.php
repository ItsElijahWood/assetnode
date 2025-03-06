<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/db/database_assets.php';
require_once __DIR__ . '/../core/session.php';

$sessionClass = new \Server\Auth\SessionManager($conn);
$user = $sessionClass->getUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $asset_id = $_POST['asset_id'];
  $asset_category = $_POST['asset_category'];
  $asset_type = $_POST['asset_type'];
  $asset_make = $_POST['asset_make'];
  $serial_number = $_POST['serial_number'];
  $purchase_date = $_POST['purchase_date'];
  $asset_warranty = $_POST['asset_warranty'];
  $asset_location = $_POST['asset_location'];
  $asset_user = $_POST['asset_user'];
  $asset_cost = $_POST['asset_cost'];
  $asset_depreciation = $_POST['asset_depreciation'];
  $asset_condition = $_POST['asset_condition'];
  $asset_mac_address = $_POST['asset_mac_address'];
  $asset_ip_address = $_POST['asset_ip_address'];
  $asset_ram = $_POST['asset_ram'];
  $asset_storage = $_POST['asset_storage'];
  $asset_os = $_POST['asset_os'];

  $uid_string = "uid_" . intval($user['id']);

  $stmt = $connAssets->prepare("UPDATE `$uid_string` SET 
    type = ?, 
    asset_type = ?, 
    make = ?, 
    serial_number = ?, 
    purchase_date = ?, 
    warranty_expiration_date = ?, 
    location = ?, 
    cost = ?, 
    depreciation = ?, 
    assigned_to = ?, 
    asset_condition = ?, 
    mac_address = ?, 
    ip_address = ?, 
    operating_system = ?, 
    storage_capacity = ?, 
    ram = ?
    WHERE asset_id = ?");

  $stmt->bind_param(
    "sssssssdisssssssi",
    $asset_category,      // s 
    $asset_type,          // s
    $asset_make,          // s
    $serial_number,       // s
    $purchase_date,       // s
    $asset_warranty,      // s
    $asset_location,      // s
    $asset_cost,          // d
    $asset_depreciation,  // i
    $asset_user,          // s
    $asset_condition,     // s
    $asset_mac_address,   // s
    $asset_ip_address,    // s
    $asset_os,            // s
    $asset_storage,       // s
    $asset_ram,           // s
    $asset_id             // i
  );

  if ($stmt->execute()) {
    $affectedRows = $stmt->affected_rows;
    if ($affectedRows > 0) {
      echo json_encode(['success' => true, 'message' => 'Successfully updated new asset data.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'No rows were updated.']);
    }
  } else {
    echo json_encode(['success' => false, 'message' => 'Failed to update new asset data: ' . $stmt->error]);
  }
}
