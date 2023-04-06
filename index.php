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
$conn = null;


?>
<head>
    <meta charset="utf-8">
    <title>VOCO Blog - Home</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php
include('php/header.php') ?>
<div class="column">
    <div id="left">
        <h2>Recent Posts</h2>
        <!--TODO: Update article cards such that they link to blog posts when clicked & add author-->
        <!--TODO: Update article card sizes, such that they evenly fill up the space inside the div container as rectangular blocks-->
        <div class="articleContainer">
            <?php
            while ($row = $blogs->fetch()) {
                echo "<div class='entry'>";
                if(isset($row["blog_img"]) && isset($row["blog_img_type"])){
                    $imagedata = $row["blog_img"];
                    $contentType = $row["blog_img_type"];
                    echo "<figure><img src=\"data:image/".$contentType.";base64,".base64_encode($imagedata)."\" height=\"100%\" width=\"100%\" /></figure>";
                }
                echo "<div class='blog-title'><h3><a href='post.php?blog_id=" . $row['blog_id'] . "'>".$row['blog_title']." - By ".$row['username']."</a></h3></div>";
                echo "<div class='blog-preview'><p>". substr($row['blog_contents'], 0, 100)."</p></div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <div id="right">
        <div id="sideOptions">
        <?php
        if($loggedIn) {
            echo "<div id=\"createPost\"><a href=\"create.html\"><button>Create Post</button><a></div>";
        }
        ?>
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
</div>
<footer>

</footer>
</body>
</html>
