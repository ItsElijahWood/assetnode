<?php 
    $config = require __DIR__ . '/server/config.php';  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Node</title>
    <link rel="icon" href="./assets/img/favicon.png" type="image/png" />
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/header.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="circle-bg"></div>
        <a onclick="window.location.href='<?=$config['WEBSITE_URL']?>/'">
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
            <div class="button-div-header-login" onclick="window.location.href='<?=$config['WEBSITE_URL']?>/login'">
                <a class="abutton-header-3">Login</a>
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
                    <a class="abutton-sidebar" onclick="window.location.href='<?=$config['WEBSITE_URL']?>/login'">Login</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <div class="title-div">
        <h2 class="title">Asset Tracking, Made <br>Simple With Asset Node</h2>
        <p class="title-desc">Asset Node is the perfect solution for<br> businesses of all sizes. Our affordable<br> and easy-to-use platform makes<br> asset tracking accessible to everyone.</p>
    </div>
    <div class="rodeo">
        <img class="rodeo-img" alt="Rodeo mascot" src="./assets/img/rodeo.png">
    </div>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
</body>
</html>