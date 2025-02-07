<?php
    $config = require __DIR__ . '/server/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Node Sign-up</title>
    <link rel="icon" href="./assets/img/favicon.png" type="image/png" />
    <link rel="stylesheet" href="./assets/css/signup.css">
    <link rel="stylesheet" href="./assets/css/header.css">
</head>
<body>
    <!-- Header -->
    <div class="circle-bg"></div>
    <div class="header">
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
        <img class="menu-header" alt="Menu Header Icon Button" src="./assets/img/Menu.svg" onclick="$('.sidebar').addClass('open');">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar">
            <div class="circle-sidebar"></div>
            <img class="menu-sidebar" alt="Menu Sidebar Icon Button" src="./assets/img/Menu.svg" onclick="$('.sidebar').removeClass('open');">
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
    <!-- Login form (pushes to ajax jquery) -->
    <form id="signupForm" class="loginForm">
        <h2 class="title">Sign Up</h2>
        <label for="user">Username</label>
        <input type="text" name="user" id="user" required><br><br>   
        <label for="password">Password</label>
        <div class="password-div">
            <input type="password" name="password" id="password" minlength="8" required>
            <div class="togglePassword-div">
                <span id="togglePassword">👁️</span>
            </div>
        </div>
        <div class="password-strength" id="password-strength"></div>
        <input type="submit" value="Login">
        <a class="a-login" onclick="window.location.href='<?= $config['WEBSITE_URL'] ?>/login'">Already have an account?</a>
    </form>
    <div id="resMsg"></div>
    <div class="rodeo">
        <img class="rodeo-img" alt="Rodeo mascot" src="./assets/img/rodeo.png">
    </div>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="./assets/js/toggle_password.js"></script>
    <script src="./assets/js/password_strength.js"></script>
    <script>
        // Sends HTML form data to login.php thru POST
        $(document).ready(function () {
            $("#signupForm").submit(function (event) {
                event.preventDefault(); // Reload page disable

                $.ajax({
                    type: "POST",
                    url: "./server/auth/signup.php",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        $("#resMsg").html(response.message);
                    },
                    error: function () {
                        $("#resMsg").html("Error processing request.");
                    }
                });
            });
        });
    </script> 
</body>
</html>