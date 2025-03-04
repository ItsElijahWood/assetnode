<?php

namespace Server\Controllers;

class RenderListsAndFetchList
{
  private $connAssets;

  public function __construct($connAssets)
  {
    $this->connAssets = $connAssets;
  }

  public function renderListHardware(int $uid)
  {
    $data = $this->getHardware($uid);

    if (!empty($data)) {
      foreach ($data as $row) {
        if ($row['user_hardware'] === '') {
          $row['user_hardware'] = '-';
        }
        if ($row['warranty_expiration_date'] === '') {
          $row['warranty_expiration_date'] = '-';
        }

        echo "
        <div class='list_hardware_container'>
            <form action='http://localhost/assets/list' method='get' style='position: absolute; left: 15px; margin: 0;' class='view-form' id='view-form-" . $row['asset_id'] . "'>
              <input type='hidden' name='asset_category' value='" . urlencode($row['type']) . "'>
              <input type='hidden' name='asset_id' value='" . urlencode($row['asset_id']) . "'>
              <input type='hidden' name='asset_type' value='" . urlencode($row['asset_type']) . "'>
              <input type='hidden' name='asset_cost' value='" . urlencode($row['cost']) . "'>
              <input type='hidden' name='asset_make' value='" . urlencode($row['make']) . "'>
              <input type='hidden' name='serial_number' value='" . urlencode($row['serial_number']) . "'>
              <input type='hidden' name='purchase_date' value='" . urlencode($row['purchase_date']) . "'>
              <input type='hidden' name='asset_warranty' value='" . urlencode($row['warranty_expiration_date']) . "'>
              <input type='hidden' name='asset_location' value='" . urlencode($row['location']) . "'>
              <input type='hidden' name='asset_user' value='" . urlencode($row['user_hardware']) . "'>
              <input type='hidden' name='asset_depreciation' value='" . urlencode($row['depreciation']) . "'>
              <input type='hidden' name='asset_condition' value='" . urlencode($row['asset_condition']) . "'>
              <input type='hidden' name='asset_ip_address' value='" . urlencode($row['ip_address']) . "'>
              <input type='hidden' name='asset_mac_address' value='" . urlencode($row['mac_address']) . "'>
              <input type='hidden' name='asset_os' value='" . urlencode($row['operating_system']) . "'>
              <input type='hidden' name='asset_storage' value='" . urlencode($row['storage_capacity']) . "'>
              <input type='hidden' name='asset_ram' value='" . urlencode($row['ram']) . "'>
              <a onclick='event.preventDefault(); 
                $(\".edit_view\").css(\"display\", \"block\");
                $(\":not(.edit_view, .edit_view *, body, html)\").css(\"opacity\", \"0.8\");
                document.querySelectorAll(\"body *\").forEach(el => el.style.userSelect = \"none\");
                document.querySelectorAll(\".edit_view, .edit_view *\").forEach(el => el.style.userSelect = \"auto\");
                document.getElementById(\"view-form-" . $row['asset_id'] . "\").submit();'>
                <img class='eye_icon' style='width: 50px; height: 50px; user-select: none; cursor: pointer;' src='../../static/img/eye_icon.png'>
            </a>
        </form>
            <div class='list_column'>
              <p class='list_column_p'>" . htmlspecialchars($row['type']) . "</p>
            </div>
            <div class='list_column'>
              <p class='list_column_p'>" . htmlspecialchars($row['asset_id']) . "</p>
            </div>
            <div class='list_column'>
              <p class='list_column_p'>" . htmlspecialchars($row['asset_type']) . "</p>
            </div>
            <div class='list_column'>
              <p class='list_column_p'>" . htmlspecialchars($row['make']) . "</p>
            </div>
            <div class='list_column'>
              <p class='list_column_p'>" . htmlspecialchars($row['cost']) . "</p>
            </div>
            <div class='list_column'>
              <p class='list_column_p'>" . htmlspecialchars($row['user_hardware']) . "</p>
            </div>
            <div class='list_column'>
              <p class='list_column_p'>" . htmlspecialchars($row['warranty_expiration_date']) . "</p>
            </div>
          </div>";
      }

      return;
    } else {
      echo "<div class='list_column'>
        <p class='list_column_p'>No assets found.</p>
      </div>";
    }
  }

  /**
   *  Gets data and returns  
   *
   *  @param int $uid
   *  @return array
   */
  private function getHardware(int $uid): array
  {
    $uid_string = "uid_" . intval($uid);
    $sql = "SELECT * FROM `$uid_string`";

    $query = mysqli_query($this->connAssets, $sql);
    $data = [];

    if ($query && $query->num_rows > 0) {
      while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
      }
    }

    return $data;
  }
}
