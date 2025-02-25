<?php
namespace Server\Controllers;

class Get_highest_asset_id
{
  private $connAssets;

  public function __construct($connAssets)
  {
    $this->connAssets = $connAssets;
  }

  public function getAssetCount($uid)
  {
    $uidString = "uid_" . intval($uid);
    $sql = "SELECT COUNT(asset_id) AS asset_count FROM `$uidString`";

    $result = mysqli_query($this->connAssets, $sql);
    $resultRow = mysqli_fetch_assoc($result);

    $resultRow['asset_count'] += 1;

    return $resultRow ? $resultRow['asset_count'] : 0; // Return 0 if no assets found
  }
}
