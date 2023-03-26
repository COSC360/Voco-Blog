<!doctype html>
<html class="no-js" lang="">
<?php
include('php/db_connection.php');
$conn = connect();
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


// TODO: Update so that filters work - maybe extract to different file?
// Get Blog Posts
$sql = "SELECT * FROM Blogs WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$blogs = $stmt->fetchAll();
// Get user info
$sql = "SELECT * FROM Users WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch();
// TODO: Get Saved Blogs - Requires DB refactor
?>
<head>
    <meta charset="utf-8">
    <title>VOCO Blog - Profile</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
<header>
    <nav class="navbar">
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
            echo "<div class=\"headbox\"><a href=\"login.html\">Login</a><a href=\"register.html\">Register</a></div>";
        }
        ?>

    </nav>
</header>

<!--TODO: Update 3 column layout to be prettier:
 Col 1: blog posts - view list of posted blogs, ability to view/edit/delete
 Col 2: Account Information - View account info, ability to edit account profile / delete account
 Col 3: Saved posts - Ability to access saved posts / remove saved posts
 -->

<div class="column">
    <div class="card">
        <h2>Your Posts</h2>
        <?php
        foreach ($blogs as $blog){
            echo "<div class='post-entry'><div class='post-preview'>";
            echo "<h3 style='float:left;'>".$blog['blog_title']."</h3><h3 style='float:right;'>Likes: ".$blog['like_count']."</h3>";
            echo "</div><div class='entry-buttons'>";
            echo "<a href='post.php?blog_id=".$blog['blog_id']."'><button>View</button></a>";
            echo "<a href='create.php?blog_id=".$blog['blog_id']."'><button>Edit</button></a>";
            // TODO: Add a "are you sure" confirmation?
            echo "<a href='php/delete_blog.php?blog_id=".$blog['blog_id']."'><button>Delete</button></a>";
            echo "</div></div>";
        }
        ?>
<!--        <div class="post-entry">-->
<!--            <div class="post-preview">-->
<!--                <h3 style="float:left;">A Blog Title</h3>-->
<!--                <h3 style="float:right;">John Doe</h3>-->
<!--            </div>-->
<!--            <div class="entry-buttons">-->
<!--                <button>View</button>-->
<!--                <button>Edit</button>-->
<!--                <button>Delete</button>-->
<!--            </div>-->
<!--        </div>-->
    </div>
    <div class="card" id="your-profile">
        <h2>Your Profile</h2>
        <div class="profile-contents">
            <img class="profile-pic" src="">
            <p>First Name: <?php echo $user['first_name']?> Last Name: <?php echo $user['last_name']?></p>
            <p>Email: <?php echo $user['email'] ?></p>

        </div>
        <div id="profile-buttons">
            <a href='php/delete_user.php?user_id=<?php echo $_SESSION['active_user_id']?>'><button>Delete Account</button></a>
            <!--TODO: implement this-->
            <button>Edit Profile</button>
        </div>

    </div>
    <div class="card">
        <h2>Saved Posts</h2>
        <div class="post-entry">
            <div class="post-preview">
                <h3 style="float:left;">A Blog Title</h3>
                <h3 style="float:right;">John Doe</h3>
            </div>
            <div class="entry-buttons">
                <button>Unsave</button>
            </div>
        </div>
        <div class="post-entry">
            <div class="post-preview">
                <h3 style="float:left;">A Blog Title</h3>
                <h3 style="float:right;">John Doe</h3>
            </div>
            <div class="entry-buttons">
                <button>Unsave</button>
            </div>
        </div>
    </div>
</div>
<footer>

</footer>
<script src="js/main.js"></script>
</body>

</html>
