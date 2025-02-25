<?php
$config = require_once __DIR__ . '/../server/config.php';
require __DIR__ . '/../server/core/database.php';
require_once __DIR__ . '/../server/core/session.php';

// Get session manager for auth handling
$sessionClass = new \Server\Auth\SessionManager($conn);
$user = $sessionClass->getUser();

$isPremium = ($user['is_premium'] === 1) ? "PRO" : "FREE";
?>
<link rel="stylesheet" href="/../static/css/dashboard_header.css">
<!-- Header -->
<div class="header">
    <a class="a-header-logo" onclick="window.location.href='<?= $config['WEBSITE_URL'] ?>/dashboard'">
        <img src="/../static/img/Logo.png" alt="Header Logo" class="logo-header">
    </a>
    <img class="menu-header" alt="Menu Header Logo Button" src="/../static/img/Menu.svg" onclick="$('.sidebar').addClass('open');">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <img class="menu-sidebar" alt="Menu Sidebar Logo Button" src="/../static/img/Menu.svg" onclick="$('.sidebar').removeClass('open');">
        <a class="premium-tier"><?= $isPremium ?></a>
        <!-- Sidebar buttons -->
        <hr class="hr">
        <div class="sidebar-buttons">
            <div class="sidebar-div-header" onclick="window.location.href='<?= $config['WEBSITE_URL'] ?>/dashboard'">
                <a class="abutton-sidebar">Dashboard</a>
            </div>
            <div class="sidebar-div-header" onclick="window.location.href='<?= $config['WEBSITE_URL'] ?>/assets/list'">
                <a class="abutton-sidebar">Asset Management</a>
            </div>
            <div class="sidebar-div-header">
                <a class="abutton-sidebar" id="logout">Logout</a>
            </div>
        </div>
    </div>
</div>
<script src="../static/js/logout.js"></script>
<script src="../static/js/dashboard_header_auto_close.js"></script>
