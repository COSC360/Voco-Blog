<?php
session_start();
if(!isset($_SESSION['active_user_id'])){
    header('Location: ../login.html');
    exit();
}
include('db_connection.php');
$conn = connect();

// check if comment id is set
if(isset($_GET['blog_id'])) {
    $blog_id = $_GET['blog_id'];
    // get the blog post from the database
    $sql = "SELECT * FROM Blogs WHERE blog_id = :blog_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['blog_id' => $blog_id, 'user_id' => $_SESSION['active_user_id']]);
    $blog = $stmt->fetch();

    // ensure blog exists & belongs to user
    if (!$blog) {
        header('Location: index.php');
        exit();
    }
    // delete blog from categories
    $sql = "DELETE FROM blogCategory WHERE blog_id = :blog_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['blog_id' => $blog_id]);
    // delete comment from the database
    $sql = "DELETE FROM Comments WHERE blog_id = :blog_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['blog_id' => $blog_id]);
    // delete the blog post from the database
    $sql = "DELETE FROM Blogs WHERE blog_id = :blog_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['blog_id' => $blog_id]);

    // redirect back to the profile page
    header("Location: ../profile.php");
    exit();
}else{
    header('Location: ../index.php');
    exit();
}
