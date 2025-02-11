<?php
$config = require_once __DIR__ . '/../server/config.php';
require __DIR__ . '/../server/core/database.php';
require_once __DIR__ . '/../server/core/session.php';
require_once __DIR__ . '/../server/controllers/check_premium.php';

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
    <title>Asset List</title>
    <link rel="icon" href="../static/img/favicon.png" type="image/png" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../static/css/list.css">
</head>
<body>
<?php if (isset($user)): ?>
<?php require __DIR__ . "/../components/dashboard_header.php"; ?>
<!-- Main content -->
<?php endif; ?>
</body>
</html>