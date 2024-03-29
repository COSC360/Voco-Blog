<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>VOCO Blog - Profile</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/admin.css">
  <script type="text/javascript" src="js/table_handler.js"></script>


</head>

<body>
<?php

session_start();

if((isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) && $_SESSION["isAdmin"] == false){
   header("Location: index.php");
}

session_abort();


// MUST BE DECLARED AFTER ANY HEADER
include('php/header.php');

?>

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
        userTableRequest("php/adminmanager.php","user");
    })
    document.getElementById("manageblogpost").addEventListener("click", function() {
        userTableRequest("php/adminmanager.php","blog");
    });
    document.getElementById("manageadmin").addEventListener("click", function() {
        userTableRequest("php/adminmanager.php","admin")
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
</body>

</html>
