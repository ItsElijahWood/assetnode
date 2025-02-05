<?php 
  $config = require(__DIR__ . '/../config.php');
  
  $DB_HOST = $config['DB_HOST'];
  $DB_USER = $config['DB_USER'];
  $DB_PASSWORD = $config['DB_PASSWORD'];
  $DB_NAME = $config['DB_NAME'];

  try { 
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
  } catch (mysqli_sql_exception $e) {
    echo "Failure when connecting to database: " . $e->getMessage() . "\n";
  }
?>
