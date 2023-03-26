<?php
    include("db_connection.php");
    include("validateRequests.php");

    session_start();

    // Connection to db
    $pdo = connect();

    // Validate user is logged in (should always be true, but good to check)
    if(isset($_SESSION["active_user_id"])) {
        $active_user_id = $_SESSION["active_user_id"];
    } else {
        die("Error: User is not logged in");
    }

    echo var_dump($_POST);
    // Validate contents from post request
    if(validatePostRequest($_POST,$_SERVER)) {
        $blog_title = $_POST["post_title"];
        $blog_contents = $_POST["blog_contents"];
        //TODO:  For now only sends one category_id val, allow more then one
        $catagories = $_POST["categories"];

        //TODO: Have user select their own image for a blog post
        //$cover_img = $_FILES["cover_img"]["tmp_name"];

        //TODO: Remove in final milestone, so that img uploads are user choices
        $cover_img = "img/eddyed.jpg";

        $like_count = 0;
    } else {
        die();
    }

    //TODO: Store images as blobs
    //$image_blob = file_get_contents($cover_img);

    // // INSERT into Blogs
    $sql = "INSERT INTO Blogs (user_id,blog_title,blog_createdAt,blog_modifiedAt,blog_img,blog_contents,like_count) VALUES (?,?,NOW(),NOW(),?,?,?)";

    $stmt = $pdo->prepare($sql);

    $result = $stmt->execute([$active_user_id,$blog_title,$cover_img,$blog_contents,$like_count]);

    // //Get new blog ID
    $new_blog_id = $pdo->lastInsertId();

    // //TODO: Allow users to add category tags to a blog post
    $sql = "INSERT INTO blogCategory VALUES (?,?)";

    $stmt = $pdo->prepare($sql);

    $result = $stmt->execute([$catagories,$new_blog_id]);

    //Redirect
    header("Location: ../index.php");





?>
