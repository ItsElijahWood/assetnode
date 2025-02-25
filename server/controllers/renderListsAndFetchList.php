<?php

namespace Server\Controllers;

class RenderListsAndFetchList
{
  private $connAssets;

  public function __construct($connAssets)
  {
    $this->connAssets = $connAssets;
  }

  public function renderListHardware($uid)
  {
    $data = $this->getHardware($uid);

    if (!empty($data)) {
      foreach ($data as $row) {
        if ($row['user_hardware'] == '') {
          $row['user_hardware'] = '-';
        } 
        if ($row['warranty_expiration_date'] == '') {
          $row['warranty_expiration_date'] = '-';
        }
       echo '
      <div class="list_hardware_container">
          <div class="list_column">
            <p class="list_column_p">' . htmlspecialchars($row["type"]) . '</p>
          </div>
          <div class="list_column">
            <p class="list_column_p">' . htmlspecialchars($row["asset_id"]) . '</p>
          </div>
          <div class="list_column">
            <p class="list_column_p">' . htmlspecialchars($row["asset_type"]) . '</p>
          </div>
          <div class="list_column">
            <p class="list_column_p">' . htmlspecialchars($row["make"]) . '</p>
          </div>
          <div class="list_column">
            <p class="list_column_p">' . htmlspecialchars($row["cost"]) . '</p>
          </div>
          <div class="list_column">
            <p class="list_column_p">' . htmlspecialchars($row["user_hardware"]) . '</p>
          </div>
          <div class="list_column">
            <p class="list_column_p">' . htmlspecialchars($row["warranty_expiration_date"]) . '</p>
          </div>
        </div>';
      }

      return;
    } else {
      echo '<div class="list_column">
        <p class="list_column_p">No assets found.</p>
      </div>';
    }
  }

  /**
   *  Gets data and returns  
   *
   *  @param int $uid
   *  @return array
   */
  private function getHardware($uid): array
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

