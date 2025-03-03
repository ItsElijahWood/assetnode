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
        <img class='eye_icon' onclick=\"document.querySelector('.edit_view').style.display = 'block'; document.querySelectorAll('*:not(.edit_view):not(.edit_view *):not(body):not(html)').forEach(el => el.style.opacity = '0.8'); document.querySelectorAll('body *').forEach(el => el.style.userSelect = 'none'); document.querySelectorAll('.edit_view, .edit_view *').forEach(el => el.style.userSelect = 'auto');\"
            style='position: absolute; left: 15px; width: 50px; height: 50px; user-select: none; cursor: pointer;' src='../../static/img/eye_icon.png'>
            </img>
            <div class='list_column'>
              <p id='asset_id_eye' class='list_column_p'>" . htmlspecialchars($row['type']) . "</p>
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
