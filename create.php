<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>VOCO Blog - Create</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/create.css">

</head>

<body>
    <?php
    include('php/header.php');

    if(!(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true)){
        header("Location: index.php");
        exit();
    }
    ?>
<form action="php/create_blog.php" method="post" enctype="multipart/form-data">
    <div class="column">
        <div id="left">
            <h2>Create A Post:</h2>
                <label>
                    <textarea id="blogText" name="blog_contents" type="text" cols="10" rows="5" ></textarea>
                </label>
        </div>
        <div id="right">
            <div id="postInputs">
                <div class="postInput">
                    <label type="text" for="postTitle">Post Title:</label>
                    <input required type="text" id="postTitle" name="post_title">
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
