<?php
  $config = require_once __DIR__ . '/./server/config.php';
  require __DIR__ . '/server/core/database.php';
  require_once __DIR__ . '/server/core/session.php';

  // Get session manager for auth handling
  $sessionClass = new \Server\Auth\SessionManager($conn);
  $user = $sessionClass->getUser();

  // Redirect if not signed in
  if (!isset($user)) {
    header('Location: /404');
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="icon" href="./assets/img/favicon.png" type="image/png" />
  <link rel="stylesheet" href="./assets/css/home.css">
  <link rel="stylesheet" href="./assets/css/header.css">
</head>
<body>
  <?php if (isset($user)): ?>
  <!-- Header -->
  <div class="header">
        <div class="circle-bg"></div>
        <a onclick="window.location.href='<?= $config['WEBSITE_URL'] ?>/'">
            <img src="./assets/img/Logo.png" alt="Header Logo" class="logo-header">
        </a>
        <!-- Buttons -->
        <div class="buttons-header">
            <div class="button-div-header">
                <a class="abutton-header-1">About</a>
            </div>
            <div class="button-div-header">
                <a class="abutton-header-2">Contact us</a>
            </div>
            <div class="button-div-header-login" id="logout">
                <a class="abutton-header-3">Logout</a>
            </div>
        </div>
        <img class="menu-header" alt="Menu Header Logo Button" src="./assets/img/Menu.svg" onclick="$('.sidebar').addClass('open');">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar">
            <div class="circle-sidebar"></div>
            <img class="menu-sidebar" alt="Menu Sidebar Logo Button" src="./assets/img/Menu.svg" onclick="$('.sidebar').removeClass('open');">
            <!-- Sidebar buttons -->
            <div class="sidebar-buttons">
                <div class="sidebar-div-header">
                    <a class="abutton-sidebar">About</a>
                </div>
                <div class="sidebar-div-header">
                    <a class="abutton-sidebar">Contact us</a>
                </div>
                <div class="sidebar-div-header">
                    <a class="abutton-sidebar" id="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./assets/js/logout.js"></script>
</body>
</html>