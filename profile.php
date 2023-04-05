<!doctype html>
<html class="no-js" lang="">
<?php
include('php/db_connection.php');
include('php/like_handler.php');
$conn = connect();

//$likedPosts = get_liked_posts($conn,$user_id);

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
<?php
include('php/header.php');
if(!(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true)){
    header("Location: register.html");
    exit();
}
?>
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
    <div class="card" id="sideOptions">

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
        <h2>Liked Posts</h2>
        <table>
            <thead>
            <tr>
                <td>Post</td>
                <td>Author</td>
                <td colspan="2"></td>
            </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($likedPosts as $post){
                        echo "<tr><td>".$post['blog_title']."</td><td>".$post['username']."</td>";
                        echo "<td><a href='post.php?blog_id=".$post['blog_id']."'>View</a></td>";
                        // TODO: Functionality not complete. Probably needs to be done with AJAX.
                        echo "<td href=''><a>Delete</a></td>";
                    }
                ?>
            </tbody>
        </table>

    </div>
</div>
<footer>

</footer>
<script src="js/main.js"></script>
</body>

</html>
