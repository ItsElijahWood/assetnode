<?php
namespace Server\Controllers;

require __DIR__ . '/../../vendor/autoload.php';
use ItsElijahWood\Profanity\Profanity;

class Filterwords
{
  public function filterText($string)
  {
    $profanity = new Profanity();
    $result = $profanity->filterString($string);

    return $result;
  }
}
