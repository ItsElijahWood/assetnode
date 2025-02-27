<?php
namespace Server\Controllers;

class Asset_category_percentage
{
  private $connAssets;

  public function __construct($connAssets)
  {
    $this->connAssets = $connAssets;
  }

  /**
   * Retrieves the asset category distribution for a given user ID.
   *
   * @param int $uid 
   * @return string
   */
  public function getAssetCategory($uid)
  {
    $uidString = "uid_" . intval($uid);
    $sql = "SELECT `type` FROM `$uidString`";

    $result = mysqli_query($this->connAssets, $sql);

    $typeCounts = [];
    $totalCount = 0;

    if ($result->num_rows > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $type = $row['type'];
        $typeCounts[$type] = ($typeCounts[$type] ?? 0) + 1;
        $totalCount++;
      }
    } else {
	return "-";
    }

    $percentages = [];
    if ($totalCount > 0) {
      foreach ($typeCounts as $type => $count) {
        $percentages[$type] = ($count / $totalCount) * 100;
      }
    }

    foreach ($percentages as $type => $percentage) {
      $type_string = $type . " " . number_format($percentage, 2) . "%\n";
      return $type_string;
    }
  }
}
