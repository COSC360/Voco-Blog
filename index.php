<!doctype html>
<html class="no-js" lang="">
<?php

session_start();

if(isset($_SESSION["username"])){
  $username = $_SESSION["username"];
}

if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true ) {
  $loggedIn = true;
}


?>
<head>
  <meta charset="utf-8">
  <title>VOCO Blog - Home</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="headbox">
        <form action="" id="search">
          <label>
            <input type="text" placeholder="Search.." name="search">
          </label>
          <button type="submit"><i class="fa fa-search"></i></button>
        </form>
      </div>

      <div class="headbox">
        <img src="./img/voco_logo_black.png" alt="VOCO Logo img" class="logo">
      </div>

      <?php
      if($loggedIn) {
        echo "<div class=\"headbox\"><a href=\"profile.html\">".$username."</a><a href=\"/vocoblog/php/logout.php\">Log out</a></div>";
      } else {
        echo "<div class=\"headbox\"><a href=\"login.html\">Login</a><a href=\"register.html\">Register</a></div>";
      }
      ?>

    </nav>
  </header>
  <div class="column">
    <div id="left">
    <h2>Recent Posts</h2>
      <div class="articleContainer">
        <div class="entry">
          <figure>
            <img src="./img/japan.png" height="100%" width="100%">
          </figure>
          <div class="blog-title">
            <h3>A Blog Title - By Author Name</h3>
          </div>
          <div class="blog-preview">
            <p>This is the first two sentences of a blog post asd lkjasd;l kjsd asd asd asd asd </p>
            <p>asd  as asd sdasd asd asd of sdas asd aasddasd ad lkjasd;l kjsd asd asd asd asd </p>
          </div>
        </div>
        <div class="entry">
          <figure>
          </figure>
          <div class="blog-title">
            <h3>A Blog Title - By Author Name</h3>
          </div>
          <div class="blog-preview">
            <p>This is the first two sentences of a blog post asd lkjasd;l kjsd asd asd asd asd </p>
            <p>asd  as asd sdasd asd asd of sdas asd aasddasd ad lkjasd;l kjsd asd asd asd asd </p>
          </div>
        </div>
        <!--TODO: Update article cards such that they link to blog posts when clicked & add author-->
        <!--TODO: Update article card sizes, such that they evenly fill up the space inside the div container as rectangular blocks-->

        <div class="entry">
          <figure>
          </figure>
          <div class="blog-title">
            <h3>A Blog Title - By Author Name</h3>
          </div>
          <div class="blog-preview">
            <p>This is the first two sentences of a blog post asd lkjasd;l kjsd asd asd asd asd </p>
            <p>asd  as asd sdasd asd asd of sdas asd aasddasd ad lkjasd;l kjsd asd asd asd asd </p>
          </div>
        </div>

        <div class="entry">
          <figure>
          </figure>
          <div class="blog-title">
            <h3>A Blog Title - By Author Name</h3>
          </div>
          <div class="blog-preview">
            <p>This is the first two sentences of a blog post asd lkjasd;l kjsd asd asd asd asd </p>
            <p>asd  as asd sdasd asd asd of sdas asd aasddasd ad lkjasd;l kjsd asd asd asd asd </p>
          </div>
        </div>
        <div class="entry">
          <figure>
          </figure>
          <div class="blog-title">
            <h3>A Blog Title - By Author Name</h3>
          </div>
          <div class="blog-preview">
            <p>This is the first two sentences of a blog post asd lkjasd;l kjsd asd asd asd asd </p>
            <p>asd  as asd sdasd asd asd of sdas asd aasddasd ad lkjasd;l kjsd asd asd asd asd </p>
          </div>
        </div>
      </div>
    </div>
    <div id="right">
      <div id="createPost">
        <button>Create Post</button>
      </div>
      <div class="filterGroup">
        <fieldset>
          <legend>Filters</legend>
          <button type="button" value="climb">Climbing</button>
          <button type="button" value="mountaineering">Mountaineering</button>
          <button type="button" value="hike">Hiking</button>

        </fieldset>
      </div>

    </div>
  </div>
  <footer>

  </footer>
  <script src="js/main.js"></script>
</body>
</html>