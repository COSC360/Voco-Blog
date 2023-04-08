<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>VOCO Blog - Login Page</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>
<?php
include('php/header.php');
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
    header('Location: index.php');
}
?>
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
      <div style="padding: 2%">
          <p>New user? <a href="register.html">Register here</a></p>
      </div>

  </div>
  <footer>

  </footer>
</body>

</html>
