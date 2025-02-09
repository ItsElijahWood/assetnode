<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 Not Found</title>
  <link rel="icon" href="./assets/img/favicon.png" type="image/png" />
</head>
<body>
  <style>
    body {
      text-align: center;
    }
    .fourofour {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
    .icon {
      width: 170px;
      height: 170px;
      animation: spin 1.8s infinite ease-in-out;
      user-select: none;
      padding-bottom: 25px;
    }
    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
    p {
      font-size: 20px;
    }
  </style>
  <div class="fourofour">
    <img src="./assets/img/sub_icon.png" class="icon">
    <h1>404 - Page Not Found</h1>
    <p>You are not authorized to view this page.</p>
  </div>
</body>
</html>