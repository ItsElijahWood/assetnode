<?php
$config = require_once __DIR__ . '/./server/config.php';
require __DIR__ . '/server/core/database.php';
require __DIR__ . '/server/core/db/database_assets.php';
require_once __DIR__ . '/server/core/session.php';
require_once __DIR__ . '/server/controllers/get_highest_asset_id.php';
require_once __DIR__ . '/server/controllers/asset_category_percentage.php';
require_once __DIR__ . '/server/controllers/asset_cost_estimate.php';

// Get session manager for auth handling
$sessionClass = new \Server\Auth\SessionManager($conn);
$user = $sessionClass->getUser();

$getHighestAssetIdClass = new \Server\Controllers\Get_highest_asset_id($connAssets);
$asset_id = $getHighestAssetIdClass->getAssetCount($user['id']);

$getAssetTypePercentageClass = new \Server\Controllers\Asset_category_percentage($connAssets);
$asset_type_percentage = $getAssetTypePercentageClass->getAssetCategory($user['id']);

$asset_cost_estimateClass = new \Server\Controllers\Asset_cost_estimate($connAssets);
$asset_estimate = $asset_cost_estimateClass->getEstimate($user['id']);

// Redirect if not signed in
if (!isset($user)) {
    header('Location: /404');
}

// Gets the is_premium bool from $user session manager
$isPremium = ($user['is_premium'] === 1) ? "PRO" : "FREE";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Dashboard</title>
    <link rel="icon" href="./static/img/favicon.png" type="image/png" />
    <link rel="stylesheet" href="./static/css/dashboard.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <?php if (isset($user)): ?>
        <?php require __DIR__ . "/./components/dashboard_header.php"; ?>
        <!-- Main content -->
        <div class="dashboard-1">
            <div class="asset-id">
                <h3 class="d-h">Total Assets</h3>
                <p class="d-p"><?php echo $asset_id - 1 ?></p>
            </div>
            <div class="asset-type">
                <h3 class="d-h">Asset Type</h3>
                <p class="d-p"><?php echo $asset_type_percentage ?></p>
            </div>
            <div class="asset-total">
                <h3 class="d-h">Total Capital</h3>
                <p class="d-p"><?php echo $asset_estimate ?></p>
            </div>
        </div>
        <!-- Display if they don't have premium -->
        <?php if ($isPremium === "FREE"): ?>
            <div class="pay-message">
                <p class="pay-x" onclick="$('.pay-message').addClass('close'); setTimeout(() => { $('.pay-message').css('display', 'none') }, 500);">X</p>
                <h3 class="pay-h3">Thanks for using Asset Node</h3>
                <p class="pay-p">Subscribe to get more than 20 asset</p>
                <a class="pay-pricing">Pricing</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>
