<?php
include('db_connection.php');
$conn = connect();

// check if comment id is set
if(isset($_POST['comment_id'])) {

    $comment_id = $_POST['comment_id'];

    // delete comment from the database
    $sql = "DELETE FROM Comments WHERE comment_id = :comment_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['comment_id' => $comment_id]);

    // redirect back to the blog post page
    header("Location: ../post.php?blog_id=".$_POST['blog_id']);
    exit();
}