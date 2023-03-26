<?php
session_start();
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
    header('Location: index.php');
}
?>
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>VOCO Blog - Login Page</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/login.css">

</head>

<body>
  <header>
    <nav class="navbar">

      <div class="headbox">
        <!--TODO: Include Logo Image-->
        <img src="./img/voco_logo_black.png" alt="VOCO Logo img" class="logo">
      </div>

      <div class="headbox">
        <a href="index.php">Back</a>
      </div>
    </nav>
  </header>
  <div class="singleColumn">
        <form action="./php/login_handler.php" method="POST" class="user-form">
              <div>
                  <label for="loginuser">Username or Email</label>
                  <input name="loginuser" id="loginuser" placeholder="example@webmail.com">
              </div>
              <div>
                  <label for="password">Password</label>
                  <input name="password" required type="password" id="password" placeholder="Enter Your Password">
                <button type="submit">Login</button>
              </div>
      </form>
  </div>
  <footer>
      <p> New User ? <a href="register.html"> Register here</a></p>
  </footer>
  <script src="js/main.js"></script>
</body>

</html>