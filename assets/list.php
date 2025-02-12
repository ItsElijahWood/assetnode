<?php
$config = require_once __DIR__ . '/../server/config.php';
require __DIR__ . '/../server/core/database.php';
require_once __DIR__ . '/../server/core/session.php';
require_once __DIR__ . '/../server/controllers/check_premium.php';
require_once __DIR__ . '/../server/core/db/database_assets.php';
require_once __DIR__ . '/../server/controllers/get_highest_asset_id.php';

// Get session manager for auth handling
$sessionClass = new \Server\Auth\SessionManager($conn);
$user = $sessionClass->getUser();

// Redirect if not signed in
if (!isset($user)) {
    header('Location: /404');
}

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset List</title>
    <link rel="icon" href="../static/img/favicon.png" type="image/png" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../static/css/list.css">
    <script>
        function selecter(clickedLink) {
            $(".active").removeClass("active");
            $(clickedLink).addClass("active");
        }
    </script>
</head>     
<body>
<?php if (isset($user)): ?>
<?php require __DIR__ . "/../components/dashboard_header.php"; ?>
<!-- Main content -->
<div>
    <a class="a-new" onclick="$('.add').css('display', 'block'); $('*:not(.add, .add *, body, html, .add-header, .add-header-title)').css('opacity', '0.8');">New</a>
</div>
<!-- Add -->
<div class="add">
    <div class="add-header">
        <p class="add-header-title">Add Assets</p>
        <a class="add-header-x" onclick="$('.add').css('display', 'none'); $('*:not(.add, add *, body, html)').css('opacity', '1');">X</a>
    </div>
    <div class="type-selector">
        <a onclick="selecter(this); $('.hardware-inputs-div').css('display', 'flex');" class="type-selector-a-1">IT Hardware</a>
        <a onclick="selecter(this);" class="type-selector-a-2">IT Software</a>
        <a onclick="selecter(this);" class="type-selector-a-3">FF&E</a>
        <a onclick="selecter(this);" class="type-selector-a-4">MEP</a>
    </div>
    <div class="hardware-inputs-div">
        <div class="input-div">
            <label id="asset-id" for="asset-id">Asset id*</label>
            <input value="<?php echo htmlspecialchars($highestAssetId); ?>" id="asset_id-input" readonly>
        </div>
        <div class="select-div">
            <label id="asset-type">Asset Type*</label>
            <select id="AssetType" required>
                <?php foreach ($resultAssetType as $type): ?> 
                <?php if ($type[0] == '') continue; ?>
                <option style="color: black;"><?= htmlspecialchars($type[0]) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="select-div">
            <label id="asset-type">Ram*</label>
            <p class="ram-p">GB</p>
            <select id="AssetType" required>
                <?php foreach ($resultAssetRam as $ram): ?>
                    <?php if ($ram[0] == '') continue; ?>
                <option style="color: black;"><?= htmlspecialchars($ram[0]) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="select-div">
            <label id="asset-type">OS*</label>
            <select id="AssetType" required>
                <?php foreach ($resultAssetOS as $os): ?> 
                    <?php if ($os[0] == '') continue; ?>
                <option style="color: black;"><?= htmlspecialchars($os[0]) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="select-div">
            <label id="asset-type">Make*</label>
            <select id="AssetType" required>
                <?php foreach ($resultAssetMake as $make): ?> 
                    <?php if ($make[0] == '') continue; ?>
                <option style="color: black;"><?= htmlspecialchars($make[0]) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- Scripts -->
<script src="../static/js/popup_event_block.js"></script>
</body>
</html>