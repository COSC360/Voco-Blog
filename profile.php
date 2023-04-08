<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <title>VOCO Blog - Profile</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/profile.css">
    <script type="text/javascript" src="js/table_handler.js"></script>
    <script type="text/javascript" src="js/validate_update.js"></script>
</head>
<body>
<?php
include('php/header.php');
include('php/blogpost_handler.php');
if(!(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true)){
    header("Location: register.php");
    exit();
}
?>


<div class="column">
    <div class="card">

        <h2>Your Posts</h2>
        <?php
        $blogs = get_user_posts($conn, $user_id);
        if(!$blogs){
            echo "No Posts Found...";
        }
        foreach ($blogs as $blog){
            echo "<div class='post-entry'><div class='post-preview'>";
            echo "<h3 style='float:left;'>".$blog['blog_title']."</h3><h3 style='float:right;'>Likes: ".$blog['like_count']."</h3>";
            echo "</div><div class='entry-buttons'>";
            echo "<a href='post.php?blog_id=".$blog['blog_id']."'><button>View</button></a>";
            //echo "<a href='update.php?blog_id=".$blog['blog_id']."'><button>Edit</button></a>";
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

         <?php echo "<figure id='profilepicture'><img class=\"profile-pic\" src=\"data:image/".$user["profile_picture_type"].";base64,".base64_encode($user["profile_picture"])."\" height=\"100%\" width=\"100%\" /></figure>" ?>
            <p><b>Username:</b> <?php echo $user['username']?></p>
            <p><b>First Name:</b> <?php echo $user['first_name']?> <b>Last Name:</b> <?php echo $user['last_name']?></p>
            <p><b>Email:</b> <?php echo $user['email'] ?></p>

        </div>
        <div id="profile-buttons">
            <a href='php/delete_user.php?user_id=<?php echo $_SESSION['active_user_id']?>'><button>Delete Account</button></a>
            <button id="edit-profile-btn">Edit Profile</button>
        </div>

    </div>
    <div id="edit-profile-popup" class="popup">
        <div class="singleColumn popup-content">
            <form action="php/update_user.php" method="POST" class="user-form" id="updateuser-form" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value='<?php echo $user_id ?>'>
                <div>
                    <label for="firstname">First Name</label>
                    <input required type="text" name="firstname" id="firstname" value='<?php echo $user['first_name'] ?>'>
                </div>
                <div>
                    <label for="lastname">Last Name</label>
                    <input required type="text" name="lastname" id="lastname" value='<?php echo $user['last_name'] ?>'>
                </div>
                <div>
                    <label for="username">Username</label>
                    <input required type="text" name="username" id="username" value='<?php echo $user['username'] ?>'>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input required type="email" name="email" id="email" value='<?php echo $user['email'] ?>'>
                </div>
                <div>
                    <label for="profile_picture">Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" accept=".jpg,.png,.gif">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter new Password">
                </div>
                <div>
                    <label for="verifyPassword">Confirm Password</label>
                    <input type="password" name="verifyPassword" id="verifyPassword" placeholder="Verify Password">
                    <button type="button" id="cancel-edit-btn">Cancel</button>
                    <button type="submit">Update</button>
                </div>
            </form>

        </div>
    </div>
    <div class="card">
        <div id="sidenav">
            <a id="likedposts">Liked Posts</a>
            <a id="usercomments">User Comments</a>
        </div>
    <div id="table"></div>
        <script>
            document.getElementById("likedposts").addEventListener("click", function () {

                userTableRequest("php/profile_handler.php","likedposts");

            })
            document.getElementById("usercomments").addEventListener("click", function() {

                userTableRequest("php/profile_handler.php","usercomments");
            });

        </script>
    </div>
</div>
<footer>

</footer>
<script>

    document.getElementById("cancel-edit-btn").addEventListener("click", function () {
        document.getElementById('edit-profile-popup').style.display = "none";
    })
    document.getElementById("edit-profile-btn").addEventListener("click", function() {
        // Show the popup form by setting its display property to "block"
        document.getElementById("edit-profile-popup").style.display = "block";
    });

</script>
</body>

</html>
