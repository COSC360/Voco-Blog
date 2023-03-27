<!doctype html>
<html class="no-js" lang="">
<?php
include('php/db_connection.php');
$conn = connect();
// TODO: Update so that filters work - maybe extract to different file?

$search_query = $_GET['search'];
// Get Blog Posts
$sql = "SELECT *
        FROM Blogs
        INNER JOIN Users ON Blogs.user_id = Users.user_id
        WHERE Blogs.blog_title LIKE :search OR Blogs.blog_contents LIKE :search
        ORDER BY Blogs.blog_createdAt DESC";
$stmt = $conn->prepare($sql);
$stmt->execute(['search' => '%' . $search_query . '%']);
$blogs = $stmt->fetchAll();

// Get all categories
$sql = "SELECT * FROM Category";
$categories = $conn->query($sql);
$conn = null;

session_start();

$username = null;
$loggedIn = null;
$isAdmin = null;

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
}

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
    $loggedIn = true;
    $isAdmin = $_SESSION["isAdmin"];
}


?>
<head>
    <meta charset="utf-8">
    <title>VOCO Blog - Search</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<header>
    <nav class="navbar">
        <div class="headbox">
            <a href="index.php">Home</a>
        </div>
        <div class="headbox">
            <form action="search.php" method="GET" id="search">
                <label>
                    <input id="search_query" name="search" type="text" placeholder="Search..">
                </label>
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <div class="headbox">
            <img src="./img/voco_logo_black.png" alt="VOCO Logo img" class="logo">
        </div>

        <?php
        if ($loggedIn && $isAdmin) {
            echo "<div class=\"headbox\"><a href=\"admin.php\">Admin</a><a href='profile.php'>".$username. "</a><a href='php/logout.php'>Log out</a></div>";
        }elseif ($loggedIn){
            echo "<div class=\"headbox\"><a href='profile.php'>".$username. "</a><a href='php/logout.php'>Log out</a></div>";
        } else {
            echo "<div class=\"headbox\"><a href=\"login.php\">Login</a><a href=\"register.html\">Register</a></div>";
        }
        ?>

    </nav>
</header>
<div class="column">
    <div id="left">
        <h2>Showing results for: "<?php echo $search_query ?>"</h2>
        <!--TODO: Update article cards such that they link to blog posts when clicked & add author-->
        <!--TODO: Update article card sizes, such that they evenly fill up the space inside the div container as rectangular blocks-->
        <div class="articleContainer">
            <?php
            foreach($blogs as $blog){
                echo "<div class='entry'>";
                if(isset($blog['blog_img'])){
                    echo "<figure><img src=".$blog['blog_img']." height=\"100%\" width=\"100%\"></figure>";
                }
                echo "<div class='blog-title'><h3><a href='post.php?blog_id=" . $blog['blog_id'] . "'>".$blog['blog_title']." - By ".$blog['username']."</a></h3></div>";
                echo "<div class='blog-preview'><p>". substr($blog['blog_contents'], 0, 100)."</p></div>";
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
