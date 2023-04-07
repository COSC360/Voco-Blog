<!doctype html>
<html class="no-js" lang="">
<?php
    if(!isset($_GET['blog_id'])){
        header('Location: index.php');
        exit;
    }
    $blog_id = $_GET['blog_id'];
?>
<head>
    <meta charset="utf-8">
    <title>VOCO Blog - <?php echo $blog['blog_title']?></title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php
include('php/header.php');
 // If a new comment is submitted:
 if(isset($_POST['new_comment'])){
    $comment_contents = $_POST['comment_contents'];
    $sql = "INSERT INTO Comments (user_id, blog_id, comment_contents, comment_createdAt, like_count)
            VALUES (:user_id, :blog_id, :comment_contents, NOW(), 0)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'blog_id' => $blog_id, 'comment_contents' => $comment_contents]);
    header("Location: post.php?blog_id=".$blog_id);
    exit();
}

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
// Get comments
$sql = "SELECT comment.*, user.username
        FROM Comments comment
        INNER JOIN Users user ON comment.user_id = user.user_id
        WHERE comment.blog_id = :blog_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['blog_id' => $blog_id]);
$comments = $stmt -> fetchAll();
?>

<form action="" method="post">
    <div class="column">
        <div id="left">
            <?php
            echo "<h2>".$blog['blog_title']." - By ".$blog['username']."</h2>";
            ?>
            <div  class="articleContainer" id="blog-view">
                <?php
            if(isset($blog["blog_img"]) && isset($blog["blog_img_type"])){
                $imagedata = $blog["blog_img"];
                $contentType = $blog["blog_img_type"];
                echo "<figure><img src=\"data:image/".$contentType.";base64,".base64_encode($imagedata)."\" height=\"50%\" width=\"50%\" /></figure>";
            } else {
                echo "No Img :(";
            }
                ?>
                <p style="white-space: pre-wrap;">
                    <?php
                    // Enable like functionality
                    if($loggedIn) {
                    // listener is set in <a> in js script to POST a user like
                    echo "<div id=\"like\" style=\"position:absolute;bottom:0;\"><form id='like-form'><input type=\"hidden\" name=\"user-id\" value=\"".$user_id."\"><input type=\"hidden\" name=\"action\" value=\"like\"><button type=\"submit\">Like</button></form>
                          <p id=\"like_count\">".$blog["like_count"]."</p></div>";
                    }
                    echo "<div id=\"blog-contents\">".$blog['blog_contents']."</div>";
                    ?>
                </p>
            </div>
        </div>
        <div id="right">
            <div>
                <fieldset>
                    <legend>Comments</legend>
                    <?php
                        if($loggedIn){
                            echo "<form method='post'>";
                            echo "<label><input required type='text' name='comment_contents' placeholder='Write a comment...' maxlength='256'></label>";
                            echo "<button type='submit' name='new_comment'>Submit</button>";
                            echo "</form>";

                        }
                    ?>
                    <div class="articleContainer">
                    <?php
                        foreach($comments as $comment){
                            echo "<div class='article'>";
                            if($comment['user_id'] == $user_id){
                                echo "<form method='post' action='php/update_comment.php'>";
                                echo "<input type='hidden' name='comment_id' value='".$comment['comment_id']."'>";
                                echo "<input type='hidden' name='blog_id' value='".$blog_id."'>";
                                echo "<label><input type='text' name='comment_contents' value='".$comment['comment_contents']."'></label>";
                                echo "<button type='submit'>Update</button>";
                                echo "</form>";
                                echo "<form method='post' action='php/delete_comment.php'>";
                                echo "<input type='hidden' name='comment_id' value='".$comment['comment_id']."'>";
                                echo "<input type='hidden' name='blog_id' value='".$blog_id."'>";
                                echo "<button type='submit'>Delete</button>";
                                echo "</form>";
                            }else{
                                echo "<h3>".$comment['username']."</h3>";
                                echo "<p>".$comment['comment_contents']."</p>";
                            }
                            echo "</div>";
                        }
                    ?>
                    </div>
                </fieldset>
<!--                <fieldset>-->
<!--                    <legend>Related Posts</legend>-->
<!--                    <div class="articleContainer">-->
<!--                        <div class="article">-->
<!--                            <h3>A Blog title</h3>-->
<!--                            <p>This is the first two sentences of a blog post</p>-->
<!--                        </div>-->
<!--                        <div class="article">-->
<!--                            <h3>A Blog title</h3>-->
<!--                            <p>This is the first two sentences of a blog post</p>-->
<!---->
<!--                        </div>-->
<!--                        <div class="article">-->
<!--                            <h3>A Blog title</h3>-->
<!--                            <p>This is the first two sentences of a blog post</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </fieldset>-->
            </div>
        </div>
    </div>
<footer>
</footer>
</body>

</html>
