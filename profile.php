<!doctype html>
<html class="no-js" lang="">
<?php
include('php/db_connection.php');
include('php/like_handler.php');
include('php/blogpost_handler.php');
include('php/user_handler.php');
?>
<head>
    <meta charset="utf-8">
    <title>VOCO Blog - Profile</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/profile.css">
    <script type="text/javascript" src="js/table_handler.js"></script>

</head>
<body>
<?php
include('php/header.php');
if(!(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true)){
    header("Location: register.html");
    exit();
}
?>

<div class="column">
    <div class="card">
        <h2>Your Posts</h2>
        <?php
        $blogs = get_user_posts($conn, $user_id);
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
    </div>
    <div class="card" id="your-profile">
        <h2>Your Profile</h2>
        <?php
            $user = get_user($conn,$user_id);
        ?>
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
    <div class="card" id="sidenav">

        <a id="likedposts">Liked Posts</a>
        <a id="usercomments">User Comments</a>

        <script>
            document.getElementById("likedposts").addEventListener("click", function () {
                userTableRequest("php/profile_handler.php","likedposts");
            })
            document.getElementById("usercomments").addEventListener("click", function() {
                userTableRequest("php/profile_handler.php","usercomments");
            });

        </script>
        <div id="table">
        </div>
    </div>
</div>
<footer>

</footer>
</body>

</html>
