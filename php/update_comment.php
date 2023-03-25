<?php
include('db_connection.php');
$conn = connect();
// check if form is submitted
if (isset($_POST['comment_id']) && isset($_POST['comment_contents'])) {

    $comment_id = $_POST['comment_id'];
    $comment_contents = $_POST['comment_contents'];

    // update comment in the database
    $sql = "UPDATE Comments SET comment_contents = :comment_contents WHERE comment_id = :comment_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['comment_id' => $comment_id, 'comment_contents' => $comment_contents]);

    // redirect back to the blog post page
    header("Location: ../post.php?blog_id=" . $_POST['blog_id']);
}
$conn=null;
exit();