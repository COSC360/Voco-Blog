<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>VOCO Blog - Update</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/create.css">

</head>

<body>
<?php
include('php/header.php');

if(!isset($_GET['blog_id'])){
    header('Location: index.php');
    exit;
}
$blog_id = $_GET['blog_id'];


// Get blog posts
$sql = "SELECT blog.*, user.username, category.category_name
        FROM Blogs AS blog
        INNER JOIN Users AS user ON blog.user_id = user.user_id
        JOIN blogCategory AS bc ON blog.blog_id = bc.blog_id
        JOIN Category category ON bc.category_id = category.category_id
        WHERE blog.blog_id = :blog_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['blog_id' => $blog_id]);
$blog = $stmt->fetch();
if (!$blog) {
    header('Location: index.php');
    exit;
}


if(!(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) && $_SESSION['active_user_id'] = $blog['user_id']){
    header("Location: index.php");
    exit();
}
?>
<form action="php/update_blog.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="" value="">
    <div class="column">
        <div id="left">
            <h2>Update Post:</h2>
            <label>
                <textarea id="blogText" name="blog_contents" type="text" cols="10" rows="5"> <?php echo $blog['blog_contents'] ?> </textarea>
            </label>
        </div>
        <div id="right">
            <div id="postInputs">
                <div class="postInput">
                    <label type="text" for="postTitle">Post Title:</label>
                    <input required type="text" id="postTitle" name="post_title" value='<?php echo $blog['blog_title'] ?>'>
                </div>
                <div class="postInput">
                    <label for="categories[]">Select Post Categories</label>
                    <select name="categories[]" id="categories[]" type="dropdown" multiple>
                        <?php
                        // Get all categories
                        $sql = "SELECT * FROM Category";
                        $categories = $conn->query($sql);
                        while($row = $categories->fetch()){
                            echo "<option value='".$row['category_id']."'>".$row['category_name']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="postInput">
                    <label for="bannerImage">Upload Cover Image:</label>
                    <input type="file" name="cover_img" id="bannerImage" accept=".jpg,.png,.gif">
                </div>
                <div class="postInput">
                    <label id="createPostButton">
                        <button type="submit">Create Post</button>
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>

<footer>

</footer>
</body>

</html>
