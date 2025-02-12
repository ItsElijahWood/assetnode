<?php
$config = require(__DIR__ . '/../../config.php');

$DB_HOST = $config['DB_HOST'];
$DB_USER = $config['DB_USER'];
$DB_PASSWORD = $config['DB_PASSWORD'];
$DB_NAME_ASSETS = $config['DB_NAME_ASSETS'];

$connAssets = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME_ASSETS);

if (!$conn) {
    die("Connection error:" . mysqli_connect_error());
}
