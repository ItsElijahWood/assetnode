<?php
require_once __DIR__ . '/../controllers/get_highest_asset_id.php';
require_once __DIR__ . '/../core/db/database_assets.php';
require_once __DIR__ . '/../core/session.php';

$sessionClass = new \Server\Auth\SessionManager($conn);
$user = $sessionClass->getUser();

$highestAssetIdClass = new \Server\Controllers\Get_highest_asset_id($connAssets);
$highestAssetId = $highestAssetIdClass->getAssetCount($user['id']);

$uid = "uid_" . $user['id'] . "_preset";
$stmt = mysqli_prepare($connAssets, "SELECT `asset_type` FROM `$uid`");

mysqli_execute($stmt);
$resultType = mysqli_stmt_get_result($stmt);
$resultAssetType = mysqli_fetch_all($resultType);

$stmtRam = mysqli_prepare($connAssets, "SELECT `ram` FROM `$uid`");

mysqli_execute($stmtRam);

$resultRam = mysqli_stmt_get_result($stmtRam);
$resultAssetRam = mysqli_fetch_all($resultRam);

$stmtOs = mysqli_prepare($connAssets, "SELECT `operating_system` FROM `$uid`");

mysqli_execute($stmtOs);

$resultOs = mysqli_stmt_get_result($stmtOs);
$resultAssetOS = mysqli_fetch_all($resultOs);

$stmtMake = mysqli_prepare($connAssets, "SELECT `make` FROM `$uid`");

mysqli_execute($stmtMake);

$resultMake = mysqli_stmt_get_result($stmtMake);
$resultAssetMake = mysqli_fetch_all($resultMake);

$stmtLocation = mysqli_prepare($connAssets, "SELECT `location_asset` FROM `$uid`");

mysqli_execute($stmtLocation);

$resultLocation = mysqli_stmt_get_result($stmtLocation);
$resultAssetLocation = mysqli_fetch_all($resultLocation);

$stmtCondition = mysqli_prepare($connAssets, "SELECT `asset_condition` FROM `$uid`");

mysqli_execute($stmtCondition);

$resultCondition = mysqli_stmt_get_result($stmtCondition);
$resultAssetCondition = mysqli_fetch_all($resultCondition);
