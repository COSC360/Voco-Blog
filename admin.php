<<<<<<< Updated upstream
<?php
=======
<?
error_reporting(E_ALL);
ini_set('display_errors', 1);

>>>>>>> Stashed changes
session_start();

$username = null;
$loggedIn = null;
$isAdmin = null;

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $user_id = $_SESSION['active_user_id'];
}

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
    $loggedIn = true;
    $isAdmin = $_SESSION["isAdmin"];
}else {
    header("Location: register.html");
    exit();
}
if(!$isAdmin){
    header('Location: index.php');
}

?>

<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>VOCO Blog - Profile</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/admin.css">
  <script type="text/javascript" src="js/admin.js"></script>


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

<!--TODO: Update 3 column layout to be prettier:
 Col 1: blog posts - view list of posted blogs, ability to view/edit/delete
 Col 2: Account Information - View account info, ability to edit account profile / delete account
 Col 3: Saved posts - Ability to access saved posts / remove saved posts
 -->

<div class="column">
  <div class="card" id="sidenav">
    <a id="manageuser">Manage Users</a>
    <a id="manageblogpost">Manage Blogs</a>
    <a id="manageadmin">Manage Admins</a>
  </div>

  <script>
    document.getElementById("manageuser").addEventListener("click", function () {
        userTableRequest("user");
    })
    document.getElementById("manageblogpost").addEventListener("click", function() {
        userTableRequest("blog");
    });
    document.getElementById("manageadmin").addEventListener("click", function() {
        userTableRequest("admin")
    });

  </script>



<div class="card" id="rightnav">
  <h2>Dashboard</h2>
  <div id="table">
  </div>


</div>
</div>

<footer>

</footer>
<script src="js/main.js"></script>
</body>

</html>
