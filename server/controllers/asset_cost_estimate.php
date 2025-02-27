<?php

namespace Server\Controllers;

class Asset_cost_estimate
{
    private $connAssets;

    public function __construct($connAssets)
    {
        $this->connAssets = $connAssets;
    }

    public function getEstimate($uid)
    {
        $uidString = "uid_" . intval($uid);
        $sql = "SELECT cost FROM `$uidString`";
        $query = mysqli_query($this->connAssets, $sql);

        return $this->estimateTotal($query);
    }

    private function estimateTotal($query)
    {
        $totalCount = null;

	if ($query->num_rows <= 0) {
	  return $totalCount = '0';
	}
        while ($row = mysqli_fetch_assoc($query)) {
            $totalCount += $row['cost'];
        }

        return $totalCount;
    }
}
