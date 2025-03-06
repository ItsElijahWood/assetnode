<?php
$config = require __DIR__ . '/server/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Node Sign-up</title>
    <link rel="icon" href="./static/img/favicon.png" type="image/png" />
    <link rel="stylesheet" href="./static/css/signup.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
</head>
<body>
    <?php require __DIR__ . '/./components/header.php'; ?>
    <!-- Main content -->
    <!-- Login form (pushes to ajax jquery) -->
    <form id="signupForm" class="loginForm">
        <h2 class="title">Sign Up</h2>
        <label for="user">Name</label>
        <input type="text" name="user" id="user" required><br><br>
        <label for="text">Email</label>
        <input type="email" name="email" id="email" required><br><br>   
        <label for="password">Password</label>
        <div class="password-div">
            <input type="password" name="password" id="password" minlength="8" required>
            <div class="togglePassword-div" id="togglePassword-div">
                <span id="togglePassword">👁️</span>
            </div>
        </div>
        <div class="password-strength" id="password-strength"></div>
        <input type="submit" value="Sign up">
        <a class="a-login" onclick="window.location.href='<?= $config['WEBSITE_URL'] ?>/login'">Already have an account?</a>
        <div id="resMsg"></div>
    </form>
    <!-- Scripts -->
    <script src="./static/js/toggle_password.js"></script>
    <script src="./static/js/password_strength.js"></script>
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
