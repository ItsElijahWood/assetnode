<?php
$config = require_once __DIR__ . '/../server/config.php';
require __DIR__ . '/../server/core/database.php';
require_once __DIR__ . '/../server/core/session.php';
require_once __DIR__ . '/../server/controllers/check_premium.php';
// Get session manager for auth handling
$sessionClass = new \Server\Auth\SessionManager($conn);
$user = $sessionClass->getUser();

// Redirect if not signed in
if (!isset($user)) {
    header('Location: /404');
}

require __DIR__ . '/../server/sql/list_preset.php';
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
    <a class="a-new" onclick="$('.add').css('display', 'block'); $('*:not(.add, .add *, body, html)').css('opacity', '0.8');">New</a>
</div>
<!-- Add -->
<div id="add" class="add">
    <div class="add-header">
        <p class="add-header-title">Add Assets</p>
        <a class="add-header-x" onclick="$('.add').css('display', 'none'); $('*:not(.add, .add *, body, html)').css('opacity', '1');">X</a>
    </div>
    <div class="type-selector">
        <a onclick="selecter(this); $('.hardware-inputs-div').css('display', 'flex');" class="type-selector-a-1">IT Hardware</a>
        <a onclick="selecter(this);" class="type-selector-a-2">IT Software</a>
        <a onclick="selecter(this);" class="type-selector-a-3">FF&E</a>
        <a onclick="selecter(this);" class="type-selector-a-4">MEP</a>
    </div>
    <div id="hardware-input-id" class="hardware-inputs-div">
        <div class="input-div">
            <label id="asset-hardware" for="asset-hardware">Asset Category*</label>
            <input value="IT Hardware" id="asset_hardware-input" readonly>
        </div>
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
            <label id="asset-make">Make*</label>
            <select id="AssetMake" required>
                <?php foreach ($resultAssetMake as $make): ?> 
                    <?php if ($make[0] == '') continue; ?>
                <option style="color: black;"><?= htmlspecialchars($make[0]) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input-div">
            <label id="asset-serial-number" for="asset-serial-number">Serial Number*</label>
            <input id="asset_serial_number-input" required>
        </div>
        <div class="input-div">
            <label id="asset-purchase-date" for="asset-purchase-date">Purchase Date*</label>
            <input type="date" id="asset_purchase-date-input" required>
        </div>
        <div class="input-div">
            <label id="asset-warranty-expiration-date" for="asset-warranty-expiration-date">Warranty Expiration</label>
            <input type="date" id="asset_warranty-expiration-date-input" required>
        </div>
        <div class="select-div">
            <label id="asset-location">Location</label>
            <select id="AssetLocation" required>
                <?php foreach ($resultAssetLocation as $location): ?>
                    <?php if ($location[0] == '') continue; ?>
                <option style="color: black;"><?= htmlspecialchars($location[0]) ?></option>
                <?php endforeach; ?>
            </select>
        </div> 
        <div class="input-div">
            <label id="asset-assigned-user" for="asset-assigned-user">Assigned User</label>
            <input id="asset_assigned-user-input" required>
        </div>
        <div class="input-div">
            <label id="asset-cost" for="asset-cost">Cost*</label>
            <div class="input-div-cost">
                <p class="cost-p">£</p>
                <input id="asset_cost-input" required>
            </div>
        </div> 
        <div class="input-div">
            <label id="asset-depreciation" for="asset-depreciation">Annual Depreciation*</label>
            <div class="input-div-depreciation">
                <p class="depreciation-p">%</p>
                <input id="asset_depreciation-input" min="1" max="100" type="number" required>
            </div>
        </div>
        <div class="select-div">
            <label id="asset-condition">Condition*</label>
                <select id="AssetCondition" required>
                <?php foreach ($resultAssetCondition as $condition): ?>
                <?php if ($condition[0] == '') continue; ?>
                <option style="color: black;"><?= htmlspecialchars($condition[0]) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input-div">
            <label id="asset-mac-address" for="asset-mac-address">Mac Address</label>
            <input id="asset_mac_address-input" required>
        </div>
        <div class="input-div">
            <label id="asset-ip-address" for="asset-ip-address">IP Address</label>
            <input id="asset_ip_address-input" required>
        </div>
        <div class="select-div">
            <label id="asset-ram">Ram</label>
            <div class="select-div-ram">
                <p class="ram-p">GB</p>
                <select id="AssetRam" required>
                    <?php foreach ($resultAssetRam as $ram): ?>
                        <?php if ($ram[0] == '') continue; ?>
                    <option style="color: black;"><?= htmlspecialchars($ram[0]) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="input-div">
            <label id="asset-storage-capacity" for="asset-storage-capacity">Storage Capacity</label>
            <div class="input-div-storage-capacity">
                <p class="storage-capacity-p">MB</p>
                <input id="asset_storage_capacity-input" min="1" max="100" type="number" required>
            </div>
        </div>
        <div class="select-div">
            <label id="asset-os">OS</label>
            <select id="AssetOS" required>
                <?php foreach ($resultAssetOS as $os): ?> 
                    <?php if ($os[0] == '') continue; ?>
                <option style="color: black;"><?= htmlspecialchars($os[0]) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <a class="submit-hardware">Add Asset</a>
        <p id="error-msg"></p>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- Scripts -->
<script src="../static/js/popup_event_block.js"></script>
<script>
    $(document).ready(function () {
        $('.submit-hardware').click(function (event) {
            event.preventDefault(); 

            let requiredFields = [
                { id: '#AssetType', name: 'Asset Type' },
                { id: '#AssetMake', name: 'Asset Make' },
                { id: '#asset_serial_number-input', name: 'Serial Number' },
                { id: '#asset_purchase-date-input', name: 'Purchase Date' },
                { id: '#asset_cost-input', name: 'Cost' },
                { id: '#asset_depreciation-input', name: 'Depreciation' },
                { id: '#AssetCondition', name: 'Condition' }
            ];

            let missingFields = [];
            requiredFields.forEach(field => {
                if (!$(field.id).val().trim()) {
                    missingFields.push(field.name);
                }
            });

            if (missingFields.length > 0) {
                $('#error-msg').html("Missing fields: " + missingFields.join(", "));
                return;
            }

            let formData = {
                asset_category: $('#asset_hardware-input').val(),
                asset_id: $('#asset_id-input').val(),
                asset_type: $('#AssetType').val(),
                asset_make: $('#AssetMake').val(),
                serial_number: $('#asset_serial_number-input').val(),
                purchase_date: $('#asset_purchase-date-input').val(),
                warranty_expiration: $('#asset_warranty-expiration-date-input').val(),
                location: $('#AssetLocation').val(),
                assigned_user: $('#asset_assigned-user-input').val(),
                cost: $('#asset_cost-input').val(),
                depreciation: $('#asset_depreciation-input').val(),
                condition: $('#AssetCondition').val(),
                mac_address: $('#asset_mac_address-input').val(),
                ip_address: $('#asset_ip_address-input').val(),
                ram: $('#AssetRam').val(),
                storage_capacity: $('#asset_storage_capacity-input').val(),
                os: $('#AssetOS').val()
            };

            $.ajax({
                type: "POST",
                url: "../server/sql/list_submit.php",
                data: formData,
                dataType: "json",
                success: function (res) {
                    if (res.success) {
                        window.location.href = '/dashboard';
                    } else {
                        $('#error-msg').html(res.message);
                    }
                },
                error: function (res) {
                    $('#error-msg').html("An error occurred.");
                }
            });
        });
    });
</script>
</body>
</html>