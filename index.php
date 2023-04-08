<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>VOCO Blog - Home</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <script type="text/javascript" src="js/clickblog.js"></script>
</head>
<body>
<?php
include('php/header.php');
// TODO: Update so that filters work - maybe extract to different file?
// Get Blog Posts
$sql = "SELECT blog.*, user.username, user.profile_picture, profile_picture_type
        FROM Blogs blog
        INNER JOIN Users user ON blog.user_id = user.user_id";
$blogs = $conn->query($sql);
// Get all categories
$sql = "SELECT * FROM Category";
$categories = $conn->query($sql);
?>
<div class="column">
    <div id="left">
        <h2>Recent Posts</h2>
        <!--TODO: Update article cards such that they link to blog posts when clicked & add author-->
        <!--TODO: Update article card sizes, such that they evenly fill up the space inside the div container as rectangular blocks-->
        <div class="articleContainer">
            <?php
            while ($row = $blogs->fetch()) {
                echo "<div class='entry'>";
                $sql= "SELECT * FROM blogCategory AS blogcat  JOIN Category AS cat ON blogcat.category_id=cat.category_id WHERE blogcat.blog_id= :blog_id";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['blog_id' => $row['blog_id']]);
                $categoryList = $stmt->fetchAll();

                //List of categories for blog post
                if(isset($row["blog_img"]) && isset($row["blog_img_type"])){
                    $imagedata = $row["blog_img"];
                    $contentType = $row["blog_img_type"];
                    echo "<figure><img src=\"data:image/".$contentType.";base64,".base64_encode($imagedata)."\" height=\"100%\" width=\"100%\" /></figure>";
                }
                echo "<div class='blog-title'><h3><a class='blog-link' href='post.php?blog_id=" . $row['blog_id'] . "'>".$row['blog_title']."</a></h3></div>";
                echo "<div><h3> By: ".$row['username']."</h3></div>";
                echo "<div class='blog-preview'><p>". substr($row['blog_contents'], 0, 100)."</p></div>";
                echo "<div class='blog-author'><a href='profile.php' style='padding:0.5em'><img src=\"data:image/".$row["profile_picture_type"].";base64,".base64_encode($row["profile_picture"])."\" style=\"border:solid thin black;border-radius:50%\" height=\"30em\" width=\"30em\"></a><h3>".$row['username']."</h3></div>";
                //Iterate through category list for blog post
                $blog_categories = "<div class='blog-catagories'>";

                foreach($categoryList as $cat) {
                    $blog_categories .="<div class='cat-item'>".$cat['category_name']."</div>";
                }
                echo $blog_categories."</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <div id="right">
        <div id="sideOptions">
        <?php
        if($loggedIn) {
            echo "<div id=\"createPost\"><a href=\"create.php\"><button>Create Post</button><a></div>";
        }
        ?>
        <div class="filterGroup">
            <fieldset>
                <legend>Filters</legend>
                <?php
                while($row = $categories->fetch()){
                    echo "<form id='filter-form'><button type='button' value='".$row['category_name']."'>".$row['category_name']."</button></form>";
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
