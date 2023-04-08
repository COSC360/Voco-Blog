<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <title>VOCO Blog Page</title>
    <link rel="stylesheet" href="css/reset.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/comment.css">
    <link rel="stylesheet" href="css/post.css">

    <script type="text/javascript" src="js/post.js"></script>

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

$data = array(
    'blog_id' => $blog_id,
    'user_id' => $user_id,
    'action' => 'get_blog_comments'
);

$comment_data = json_encode($data);
?>
<script>
    $(document).ready(function () {
        $.ajax({
            url: 'php/comment_handler.php',
            type: 'POST',
            data: <?php echo $comment_data ?>,
            success: function (response) {
                $('#commentContainer').html(response);
            }
        })
        $('#commentForm').submit(function (event) {
            console.log("submitting")
            event.preventDefault()
            var formData = $(this).serialize()
            $.ajax({
                url: 'php/comment_handler.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#commentContainer').append(response)
                    $('#commentForm')[0].reset()
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            })
        })
    })
    document.addEventListener(
        "click",
        function(event) {
            var target = event.target
            var replyForm;
            if (target.matches("[data-toggle='reply-form']")) {
                replyForm = document.getElementById(target.getAttribute("data-target"))
                replyForm.classList.toggle("d-none")
            }
        },
        false
    )

</script>
<div class="column">
    <div id="left">
        <?php
        echo "<div id='blog-header'><h2>" . $blog['blog_title'] . " - By " . $blog['username'] . "</h2>";
        if($loggedIn) {
            // Check if user has liked post before
            $sql = "SELECT * FROM blogLikes WHERE user_id= :user_id AND blog_id= :blog_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['blog_id' => $blog_id, 'user_id' => $user_id]);
            $result = $stmt->fetch();

            // User did not like post already
            if($stmt -> rowCount() == 0) {
                // User UPDATE like and RESPONSE update count and CHANGE button...
                echo "<div id=\"like\"><form id='like-form'><input type=\"hidden\" name=\"user_id\" value=\"".$user_id."\"><input type=\"hidden\" name=\"blog_id\" value=\"".$blog_id."\"><input type=\"hidden\" id=\"action\" name=\"action\" value=\"like\"><button id='like-btn' type=\"submit\">Like</button></form></div>";
            } else {
                echo "<div id=\"like\"><form id='like-form'><input type=\"hidden\" name=\"user_id\" value=\"".$user_id."\"><input type=\"hidden\" name=\"blog_id\" value=\"".$blog_id."\"><input type=\"hidden\" id=\"action\" name=\"action\" value=\"unlike\"><button id='like-btn' type=\"submit\">Unlike</button></form></div>";
            }
            }
            echo "<p id='like-count'>Likes: ".$blog['like_count']."</p>";




            echo "</div>";
        ?>
            <div class="articleContainer" id="blog-stuff">
                <?php
            if(isset($blog["blog_img"]) && isset($blog["blog_img_type"])){
                $imagedata = $blog["blog_img"];
                $contentType = $blog["blog_img_type"];
                echo "<figure class='blog-figure'><img src=\"data:image/" . $contentType . ";base64," . base64_encode($imagedata) . "\" /></figure>";
            }
            //Display blog content
            echo "<div id=\"blog-contents\"><p>".$blog['blog_contents']."</p></div>";
            ?>

            </div>
    </div>
    <div id="right">
        <div id ='comments'>
            <form method="post" id="commentForm">
                <label>
                    <input required type="text" name="comment_contents" placeholder="Write a comment..." maxlength="256" <?php if(!$loggedIn) echo "disabled" ?>>
                </label>
                <input type="hidden" name="user_id" value="<?php echo $user_id?>">
                <input type="hidden" name="blog_id" value="<?php echo $blog_id?>">
                <input type="hidden" name="action" value="new_comment">
                <button <?php if(!$loggedIn) echo "disabled" ?> type="submit">Submit</button>
            </form>
            <div class="articleContainer" id="commentContainer">
            </div>
        </div>

    </div>
</div>
<footer>
</footer>
</body>

</html>
