<?php
$config = require __DIR__ . '/server/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Node</title>
    <link rel="icon" href="./static/img/favicon.png" type="image/png" />
    <link rel="stylesheet" href="./static/css/index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <?php require __DIR__ . '/./components/header.php'; ?>
    <!-- Main content -->
    <div class="title-div">
        <h2 class="title">Asset Tracking, Made <br>Simple With Asset Node</h2>
        <p class="title-desc">Asset Node is the perfect solution for<br> businesses of all sizes. Our affordable<br> and easy-to-use platform makes<br> asset tracking accessible to everyone.</p>
    </div>
    <div class="rodeo">
        <img class="rodeo-img" alt="Rodeo mascot" src="./static/img/rodeo.png">
    </div>
</body>
</html>
