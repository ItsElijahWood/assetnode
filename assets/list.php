<?php
$config = require_once __DIR__ . '/../server/config.php';
require __DIR__ . '/../server/core/database.php';
require __DIR__ . '/../server/core/db/database_assets.php';
require_once __DIR__ . '/../server/core/session.php';
require_once __DIR__ . '/../server/controllers/check_premium.php';
require_once __DIR__ . '/../server/controllers/renderListsAndFetchList.php';

$renderListsClass = new \Server\Controllers\RenderListsAndFetchList($connAssets);

// Get session manager for auth handling
$sessionClass = new \Server\Auth\SessionManager($conn);
$user = $sessionClass->getUser();

// Redirect if not signed in
if (!isset($user)) {
  header('Location: /404');
}

require __DIR__ . '/../server/sql/list_preset.php';

$asset_id_get = null;
$asset_category_get = null;
$asset_type_get = null;
$asset_cost_get = null;
$asset_make_get = null;
$asset_serial_number_get = null;
$asset_purchase_date_get = null;
$asset_location_get = null;
$asset_condition_get = null;
$asset_ram_get = null;
$asset_storage_get = null;
$asset_os_get = null;
$asset_ip_address_get = null;
$asset_depreciation_get = null;
$asset_warranty_get = null;
$asset_serial_number_get_trim = null;
$asset_category_get_trim = null;
$asset_user_get_trim = null;
$asset_mac_address_get_trim = null;
$asset_location_get_trim = null;
if (
  isset($_GET['asset_id']) &&
  isset($_GET['asset_type']) &&
  isset($_GET['asset_category']) &&
  isset($_GET['asset_cost']) &&
  isset($_GET['asset_make']) &&
  isset($_GET['serial_number']) &&
  isset($_GET['purchase_date']) &&
  isset($_GET['asset_warranty']) &&
  isset($_GET['asset_location']) &&
  isset($_GET['asset_user']) &&
  isset($_GET['asset_condition']) &&
  isset($_GET['asset_depreciation']) &&
  isset($_GET['asset_os']) &&
  isset($_GET['asset_storage']) &&
  isset($_GET['asset_ram']) &&
  isset($_GET['asset_ip_address']) &&
  isset($_GET['asset_mac_address'])
) {
  $asset_id_get = $_GET['asset_id'];
  $asset_type_get = $_GET['asset_type'];
  $asset_category_get = $_GET['asset_category'];
  $asset_cost_get = $_GET['asset_cost'];
  $asset_make_get = $_GET['asset_make'];
  $asset_serial_number_get = $_GET['serial_number'];
  $asset_purchase_date_get = $_GET['purchase_date'];
  $asset_warranty_get = $_GET['asset_warranty'];
  $asset_location_get = $_GET['asset_location'];
  $asset_user_get = $_GET['asset_user'];
  $asset_depreciation_get = $_GET['asset_depreciation'];
  $asset_condition_get = $_GET['asset_condition'];
  $asset_ip_address_get = $_GET['asset_ip_address'];
  $asset_mac_address_get = $_GET['asset_mac_address'];
  $asset_os_get = $_GET['asset_os'];
  $asset_storage_get = $_GET['asset_storage'];
  $asset_ram_get = $_GET['asset_ram'];
  $asset_serial_number_get_trim = trim($asset_serial_number_get);
  $asset_category_get_trim = preg_replace('/\+/', ' ', trim($asset_category_get));
  $asset_user_get_trim = preg_replace('/\+/', ' ', trim($asset_user_get));
  $asset_mac_address_get_trim = preg_replace('/%253A/', ':', urldecode(trim($asset_mac_address_get)));
  $asset_location_get_trim = preg_replace('/\+/', ' ', urldecode(trim($asset_location_get)));

  echo '<style>.edit_view { display: block } body *:not(.edit_view):not(.edit_view *) { opacity: 0.8; user-select: none; } .edit_view, .edit_view * { user-select: auto; }</style>';
}
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
    <div class="buttons">
      <a class="a-new" onclick="$('.add').css('display', 'block'); $('*:not(.add, .add *, body, html)').css('opacity', '0.8'); document.querySelectorAll('body *').forEach(el => el.style.userSelect = 'none'); document.querySelectorAll('.add, .add *').forEach(el => el.style.userSelect = 'auto');">Add Asset</a>
    </div>
    <div class="list_hardware">
      <div class="list_header_hardware">
        <div class="list_header_column">
          <p class="list_header_p">Asset Category</p>
        </div>
        <div class="list_header_column">
          <p class="list_header_p">Asset Id</p>
        </div>
        <div class="list_header_column">
          <p class="list_header_p">Asset Type</p>
        </div>
        <div class="list_header_column">
          <p class="list_header_p">Make</p>
        </div>
        <div class="list_header_column">
          <p class="list_header_p">Asset Cost</p>
        </div>
        <div class="list_header_column">
          <p class="list_header_p">Assigned To</p>
        </div>
        <div class="list_header_column">
          <p class="list_header_p">Warranty Expiration</p>
        </div>
      </div>
      <?php $renderListsClass->renderListHardware($user['id']); ?>
    </div>
    <!-- Add -->
    <div id="add" class="add">
      <div class="add-header">
        <p class="add-header-title">Add Assets</p>
        <a class="add-header-x" onclick="$('.add').css('display', 'none'); $('*:not(.add, .add *, body, html)').css('opacity', '1'); document.querySelectorAll('body *').forEach(el => el.style.userSelect = 'auto');">X</a>
      </div>
      <div class="type-selector">
        <a onclick="selecter(this); $('.hardware-inputs-div').css('display', 'flex'); $('software-inputs-div').css('display', 'none');" class="type-selector-a-1">IT Hardware</a>
        <a onclick="selecter(this); $('.software-inputs-div').css('display', 'flex'); $('.hardware-inputs-div').css('display', 'none');" class="type-selector-a-2">IT Software</a>
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
              <?php if ($type[0] == '')
                continue; ?>
              <option style="color: black;"><?= htmlspecialchars($type[0]) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="select-div">
          <label id="asset-make">Make*</label>
          <select id="AssetMake" required>
            <?php foreach ($resultAssetMake as $make): ?>
              <?php if ($make[0] == '')
                continue; ?>
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
              <?php if ($location[0] == '')
                continue; ?>
              <option style="color: black;"><?= htmlspecialchars($location[0]) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="input-div">
          <label id="asset-assigned-user" for="asset-assigned-user">Assigned To</label>
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
              <?php if ($condition[0] == '')
                continue; ?>
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
                <?php if ($ram[0] == '')
                  continue; ?>
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
              <?php if ($os[0] == '')
                continue; ?>
              <option style="color: black;"><?= htmlspecialchars($os[0]) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <a class="submit-hardware">Add Asset</a>
        <p id="error-msg"></p>
      </div>
      <div id="software-inputs-id" class="software-inputs-div">
        <div class="input-div">
          <label id="asset-software" for="asset-software">Asset Category*</label>
          <input value="IT Software" id="asset_software-input" readonly>
        </div>
        <div class="input-div">
          <label id="asset-id" for="asset-id">Asset id*</label>
          <input value="<?php echo htmlspecialchars($highestAssetId); ?>" id="asset_id-input" readonly>
        </div>
        <div class="select-div">
          <label id="asset-type">Asset Type*</label>
          <select id="AssetType" required>
            <?php foreach ($resultAssetType as $type): ?>
              <?php if ($type[0] == '')
                continue; ?>
              <option style="color: black;"><?= htmlspecialchars($type[0]) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="select-div">
          <label id="asset-make">Make*</label>
          <select id="AssetMake" required>
            <?php foreach ($resultAssetMake as $make): ?>
              <?php if ($make[0] == '')
                continue; ?>
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
              <?php if ($location[0] == '')
                continue; ?>
              <option style="color: black;"><?= htmlspecialchars($location[0]) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="input-div">
          <label id="asset-assigned-user" for="asset-assigned-user">Assigned To</label>
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
              <?php if ($condition[0] == '')
                continue; ?>
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
                <?php if ($ram[0] == '')
                  continue; ?>
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
              <?php if ($os[0] == '')
                continue; ?>
              <option style="color: black;"><?= htmlspecialchars($os[0]) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <a class="submit-hardware">Add Asset</a>
        <p id="error-msg"></p>
      </div>
    </div>
    </div>
    <!-- Edit/View -->
    <div id="edit_view" style="display: <?php echo $asset_id_get !== null ? 'block' : 'none'; ?>;" class="edit_view" style="display: none">
      <div class="edit_view-header">
        <p class="edit_view-title">Edit Asset</p>
        <a class="edit_view-header-x" onclick="$('.edit_view').css('display', 'none'); $('*:not(.edit_view, .edit_view *, body, html)').css('opacity', '1'); document.querySelectorAll('body *').forEach(el => el.style.userSelect = 'auto'); window.location.href='<?= $config['WEBSITE_URL'] ?>/assets/list'">X</a>
      </div>
      <div id="edit_view-id" class="edit_view-div">
        <div class="input-div">
          <label id="asset-hardware" for="asset-hardware">Asset Category*</label>
          <input value="<?= $asset_category_get_trim ?>" class="asset_hardware-input-edit" id="asset_hardware-input" readonly>
        </div>
        <div class="input-div">
          <label id="asset-id" for="asset-id">Asset id*</label>
          <input value="<?= $asset_id_get ?>" class="asset_id-input-edit" id="asset_id-input" readonly>
        </div>
        <div class="select-div">
          <label class="asset-type" id="asset-type">Asset Type*</label>
          <select class="AssetTypeEdit" id="AssetType" required>
            <option style="color: black;"><?= $asset_type_get ?></option>
            <?php foreach ($resultAssetType as $type): ?>
              <?php if ($type[0] == '')
                continue; ?>
              <option style="color: black;"><?= htmlspecialchars($type[0]) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="select-div">
          <label id="asset-make">Make*</label>
          <select class="AssetMakeEdit" id="AssetMake" required>
            <option style="color: black;"><?= $asset_make_get ?></option>
            <?php foreach ($resultAssetMake as $make): ?>
              <?php if ($make[0] == '')
                continue; ?>
              <option style="color: black;"><?= htmlspecialchars($make[0]) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="input-div">
          <label id="asset-serial-number" for="asset-serial-number">Serial Number*</label>
          <input value="<?= $asset_serial_number_get_trim ?>" class="asset_serial_number-input-edit" id="asset_serial_number-input" required>
        </div>
        <div class="input-div">
          <label id="asset-purchase-date" for="asset-purchase-date">Purchase Date*</label>
          <input value="<?= $asset_purchase_date_get ?>" type="date" class="asset_purchase-date-input-edit" id="asset_purchase-date-input" required>
        </div>
        <div class="input-div">
          <label id="asset-warranty-expiration-date" for="asset-warranty-expiration-date">Warranty Expiration</label>
          <input value="<?= $asset_warranty_get ?>" type="date" class="asset_warranty-expiration-date-input-edit" id="asset_warranty-expiration-date-input" required>
        </div>
        <div class="select-div">
          <label id="asset-location">Location</label>
          <select class="AssetLocationEdit" id="AssetLocation" required>
            <option style="color: black;"><?= $asset_location_get_trim ?></option>
            <?php foreach ($resultAssetLocation as $location): ?>
              <?php if ($location[0] == '')
                continue; ?>
              <option style="color: black;"><?= htmlspecialchars($location[0]) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="input-div">
          <label id="asset-assigned-user" for="asset-assigned-user">Assigned To</label>
          <input value="<?= $asset_user_get_trim ?>" class="asset_assigned-user-input-edit" id="asset_assigned-user-input" required>
        </div>
        <div class="input-div">
          <label id="asset-cost" for="asset-cost">Cost*</label>
          <div class="input-div-cost">
            <p class="cost-p">£</p>
            <input value="<?= $asset_cost_get ?>" class="asset_cost-input-edit" id="asset_cost-input" required>
          </div>
        </div>
        <div class="input-div">
          <label id="asset-depreciation" for="asset-depreciation">Annual Depreciation*</label>
          <div class="input-div-depreciation">
            <p class="depreciation-p">%</p>
            <input value="<?= $asset_depreciation_get ?>" class="asset_depreciation-input-edit" id="asset_depreciation-input" min="1" max="100" type="number" required>
          </div>
        </div>
        <div class="select-div">
          <label id="asset-condition">Condition*</label>
          <select class="AssetConditionEdit" id="AssetCondition" required>
            <option style="color: black;"><?= $asset_condition_get ?></option>
            <?php foreach ($resultAssetCondition as $condition): ?>
              <?php if ($condition[0] == '')
                continue; ?>
              <option style="color: black;"><?= htmlspecialchars($condition[0]) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="input-div">
          <label id="asset-mac-address" for="asset-mac-address">Mac Address</label>
          <input value="<?= $asset_mac_address_get_trim ?>" class="asset_mac_address-input-edit" id="asset_mac_address-input" required>
        </div>
        <div class="input-div">
          <label id="asset-ip-address" for="asset-ip-address">IP Address</label>
          <input value="<?= $asset_ip_address_get ?>" class="asset_ip_address-input-edit" id="asset_ip_address-input" required>
        </div>
        <div class="select-div">
          <label id="asset-ram">Ram</label>
          <div class="select-div-ram">
            <p class="ram-p">GB</p>
            <select class="AssetRamEdit" id="AssetRam" required>
              <option style="color: black;"><?= $asset_ram_get ?></option>
              <?php foreach ($resultAssetRam as $ram): ?>
                <?php if ($ram[0] == '')
                  continue; ?>
                <option style="color: black;"><?= htmlspecialchars($ram[0]) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="input-div">
          <label id="asset-storage-capacity" for="asset-storage-capacity">Storage Capacity</label>
          <div class="input-div-storage-capacity">
            <p class="storage-capacity-p">MB</p>
            <input class="asset_storage_capacity-input-edit" value="<?= $asset_storage_get ?>" id="asset_storage_capacity-input" min="1" max="100" type="number" required>
          </div>
        </div>
        <div class="select-div">
          <label id="asset-os">OS</label>
          <select class="AssetOSEdit" id="AssetOS" required>
            <option style="color: black;"><?= $asset_os_get ?></option>
            <?php foreach ($resultAssetOS as $os): ?>
              <?php if ($os[0] == '')
                continue; ?>
              <option style="color: black;"><?= htmlspecialchars($os[0]) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <a class="save-hardware">Save Asset</a>
        <p class="error-msg" id="error-msg"></p>
      </div>
    </div>
    </div>
  <?php endif; ?>
  <!-- Scripts -->
  <script src="../static/js/popup_event_block.js"></script>
  <script>
    $(document).ready(function() {
      $('.submit-hardware').click(function(event) {
        event.preventDefault();

        let requiredFields = [{
            id: '#AssetType',
            name: 'Asset Type'
          },
          {
            id: '#AssetMake',
            name: 'Asset Make'
          },
          {
            id: '#asset_serial_number-input',
            name: 'Serial Number'
          },
          {
            id: '#asset_purchase-date-input',
            name: 'Purchase Date'
          },
          {
            id: '#asset_cost-input',
            name: 'Cost'
          },
          {
            id: '#asset_depreciation-input',
            name: 'Depreciation'
          },
          {
            id: '#AssetCondition',
            name: 'Condition'
          },
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
          success: function(res) {
            if (res.success) {
              window.location.href = '/dashboard';
            } else {
              $('#error-msg').html(res.message);
            }
          },
          error: function(res) {
            $('#error-msg').html("An error occurred.");
          }
        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('.save-hardware').click(function(event) {
        event.preventDefault();
        const assetId = $('.asset_id-input-edit').val();
        const assetCategory = $('.asset_hardware-input-edit').val();
        const assetType = $('.AssetTypeEdit').val();
        const assetMake = $('.AssetMakeEdit').val();
        const assetSerialNumber = $('.asset_serial_number-input-edit').val();
        const assetPurchaseDate = $('.asset_purchase-date-input-edit').val();
        const assetWarranty = $('.asset_warranty-expiration-date-input-edit').val();
        const assetLocation = $('.AssetLocationEdit').val();
        const assetUser = $('.asset_assigned-user-input-edit').val();
        const assetCost = $('.asset_cost-input-edit').val();
        const assetDepreciation = $('.asset_depreciation-input-edit').val();
        const assetCondition = $('.AssetConditionEdit').val();
        const assetMacAddress = $('.asset_mac_address-input-edit').val();
        const assetIpAddress = $('.asset_ip_address-input-edit').val();
        const assetRam = $('.AssetRamEdit').val();
        const assetStorage = $('.asset_storage_capacity-input-edit').val();
        const assetOs = $('.AssetOSEdit').val();

        $.ajax({
          url: '../server/controllers/update_assets.php',
          type: 'POST',
          data: {
            asset_id: assetId,
            asset_category: assetCategory,
            asset_type: assetType,
            asset_make: assetMake,
            serial_number: assetSerialNumber,
            purchase_date: assetPurchaseDate,
            asset_warranty: assetWarranty,
            asset_location: assetLocation,
            asset_user: assetUser,
            asset_cost: assetCost,
            asset_depreciation: assetDepreciation,
            asset_condition: assetCondition,
            asset_mac_address: assetMacAddress,
            asset_ip_address: assetIpAddress,
            asset_ram: assetRam,
            asset_storage: assetStorage,
            asset_os: assetOs
          },
          success: function(response) {
            window.location.href = window.location.pathname;
          },
          error: function(response) {
            $('.error-msg').html(response.message);
          },
        });
      })
    })
  </script>
</body>

</html>
