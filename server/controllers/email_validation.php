<?php

namespace Server\Controllers;

require_once __DIR__ . '/../../vendor/autoload.php';

use ItsElijahWood\Inspector\Inspector;

class Email_validation
{
  public function emailValidate(string $email): bool
  {
    return $this->validate($email);
  }

  private function validate(string $email): bool
  {
    $inspector = new Inspector();  
    return $inspector->hasValidDomain($email);
  }
}
