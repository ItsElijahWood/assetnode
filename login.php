<?php
$config = require __DIR__ . '/server/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Node Login</title>
    <link rel="icon" href="./static/img/favicon.png" type="image/png" />
    <link rel="stylesheet" href="./static/css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
</head>
<body>
    <?php require __DIR__ . '/./components/header.php'; ?>
    <!-- Main content -->
    <!-- Login form (pushes to ajax jquery)-->
    <form id="loginForm" class="loginForm">
        <h2 class="title">Login</h2>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" required><br><br>   
        <label for="password">Password</label>
        <div class="password-div">
            <input type="password" name="password" id="password" minlength="8" required>
            <div class="togglePassword-div" id="togglePassword-div">
                <span id="togglePassword">👁️</span>
            </div>
        </div>
        <input type="submit" value="Login">
        <a class="a-register" onclick="window.location.href='<?= $config['WEBSITE_URL'] ?>/signup'">Don't have an account?</a>
        <div id="resMsg"></div>
    </form>
    <!-- Scripts -->
    <script src="./static/js/toggle_password.js"></script> 
    <script>
        // Sends HTML form data to login.php thru POST
        $(document).ready(function () {
            $("#loginForm").submit(function (event) {
                event.preventDefault(); // Reload page disable

                $.ajax({
                    type: "POST",
                    url: "./server/auth/login.php",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        if (response['failed']) {
                            return $("#resMsg").html(response.message);
                        }
                        $("#resMsg").html(response.message);
                        window.location.href="/dashboard";
                    },
                    error: function (response) {
                        $("#resMsg").html(response.message);
                    }
                });
            });
        });
    </script> 
</body>
</html>