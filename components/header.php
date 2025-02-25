<?php
$config = require __DIR__ . '/../server/config.php';
?>
<link rel="stylesheet" href="./static/css/header.css">
<!-- Header -->
<div class="header">
  <div class="circle-bg"></div>
  <a onclick="window.location.href='<?= $config['WEBSITE_URL'] ?>/'">
      <img src="./static/img/Logo.png" alt="Header Logo" class="logo-header">
  </a>
  <!-- Buttons -->
  <div class="buttons-header">
      <div class="button-div-header">
          <a class="abutton-header-1">About</a>
      </div>
      <div class="button-div-header">
          <a class="abutton-header-2">Contact us</a>
      </div>
      <div class="button-div-header-login" onclick="window.location.href='<?= $config['WEBSITE_URL'] ?>/login'">
          <a class="abutton-header-3">Login</a>
      </div>
  </div>
  <img class="menu-header" alt="Menu Header Logo Button" src="./static/img/Menu.svg" onclick="$('.sidebar').addClass('open');">
  <!-- Sidebar -->
  <div id="sidebar" class="sidebar">
      <div class="circle-sidebar"></div>
      <img class="menu-sidebar" alt="Menu Sidebar Logo Button" src="./static/img/Menu.svg" onclick="$('.sidebar').removeClass('open');">
      <!-- Sidebar buttons -->
      <div class="sidebar-buttons">
          <div class="sidebar-div-header">
              <a class="abutton-sidebar">About</a>
          </div>
          <div class="sidebar-div-header">
              <a class="abutton-sidebar">Contact us</a>
          </div>
          <div class="sidebar-div-header">
              <a class="abutton-sidebar" onclick="window.location.href='<?= $config['WEBSITE_URL'] ?>/login'">Login</a>
          </div>
      </div>
  </div>
</div>