<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>VOCO Blog - Login Page</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/main.css">
  <script type="text/javascript" src="js/validate.js"></script>

  <script>

    function checkMatchingPassword(e) {


    var password = document.getElementById("password");
    var password_check = document.getElementById("verifyPassword");

    if(password.value === password_check.value) {
      mainForm.submit();
    } else {
      makeRed(password);
      makeRed(password_check);
      alert("Passwords do not match");
      e.preventDefault();
    }

    function makeRed(inputDiv) {
        inputDiv.style.borderColor="#AA0000";
    }

    }
  </script>
</head>

<body>
  <?php
  include('php/header.php');
  if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
      header('Location: index.php');
  }
  ?>
  <div class="singleColumn">
        <form action="php/newuser.php" method="POST" class="user-form" id="newuser-form" enctype="multipart/form-data">
              <div>
                  <label for="firstname">First Name</label>
                  <input type="text" name="firstname" id="firstname" placeholder="John">
              </div>
              <div>
                  <label for="lastname">Last Name</label>
                  <input type="text" name="lastname" id="lastname" placeholder="Smith">
              </div>
              <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="johnysmith1">
            </div>
              <div>
                  <label for="email">Email</label>
                  <input required type="email" name="email" id="email" placeholder="example@webmail.com">
              </div>
              <div>
                <label for="profile_picture">Profile Picture</label>
                <input type="file" name="profile_picture" id="profile_picture" accept=".jpg,.png,.gif">
              </div>
              <div>
                  <label for="password">Password</label>
                  <input required type="password" name="password" id="password" placeholder="Enter Your Password">
              </div>
              <div>
                  <label for="verifyPassword">Confirm Password</label>
                  <input required type="password" name="verifyPassword" id="verifyPassword" placeholder="Verify Password">
                  <button type="submit">Register</button>
                </div>
      </form>
  </div>
  <footer>

  </footer>
</body>

</html>
