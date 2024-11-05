<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Glassmorphism Login Form</title>
  <link rel="stylesheet" href="../assets/style/style.css" />
</head>

<body>
  <div class="background">
    <div class="shapes"></div>
    <div class="shapes"></div>
  </div>
  <form action="login.php" method="post">
    <h6>Ease - M - Track</h6>

    <label for="user"> Username</label>
    <input type="text" name="user" id="user" placeholder="Enter Username" autocomplete="name" />
    <label for="psw">Password</label>
    <input type="password" name="psw" id="psw" placeholder="Enter Password" autocomplete="password" />
    <button type="submit">Login Now</button>

  </form>
  <script src="../assets/js/components.js"></script>
</body>

</html>