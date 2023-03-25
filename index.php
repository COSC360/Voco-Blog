<!doctype html>
<html class="no-js" lang="">
<?php
include('php/db_connection.php');
$conn = connect();
// TODO: Update so that filters work - maybe extract to different file?
// Get Blog Posts
$sql = "SELECT blog.*, user.username
        FROM Blogs blog
        INNER JOIN Users user ON blog.user_id = user.user_id";
$blogs = $conn->query($sql);
// Get all categories
$sql = "SELECT * FROM Category";
$categories = $conn->query($sql);

session_start();

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
}

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
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
        if ($loggedIn) {
            echo "<div class=\"headbox\"><a href=\"profile.html\">" . $username . "</a><a href=\"/vocoblog/php/logout.php\">Log out</a></div>";
        } else {
            echo "<div class=\"headbox\"><a href=\"login.html\">Login</a><a href=\"register.html\">Register</a></div>";
        }
        ?>

    </nav>
</header>
<div class="column">
    <div id="left">
        <h2>Recent Posts</h2>
        <!--TODO: Update article cards such that they link to blog posts when clicked & add author-->
        <!--TODO: Update article card sizes, such that they evenly fill up the space inside the div container as rectangular blocks-->
        <div class="articleContainer">
            <?php
            while ($row = $blogs->fetch()) {
                echo "<div class='entry'>";
                if(isset($row['blog_img'])){
                    echo "<figure><img src=".$row['blog_img']." height=\"100%\" width=\"100%\"></figure>";
                }
                echo "<div class='blog-title'><h3>".$row['blog_title']." - By ".$row['username']."</h3></div>";
                echo "<div class='blog-preview'><p>". substr($row['blog_contents'], 0, 100)."</p></div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <div id="right">
        <div id="createPost">
            <button>Create Post</button>
        </div>
        <div class="filterGroup">
            <fieldset>
                <legend>Filters</legend>
                <?php
                while($row = $categories->fetch()){
                    echo "<button type='button' value='".$row['category_name']."'>".$row['category_name']."</button>";
                }
                ?>
            </fieldset>
        </div>

    </div>
</div>
<footer>

</footer>
<script src="js/main.js"></script>
</body>
</html>
