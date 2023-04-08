<?php
session_start();
if (!isset($_SESSION['active_user_id'])) {
    header('Location: ../login.php');
    exit();
}
include('db_connection.php');
$conn = connect();

// check if comment id is set
if (isset($_GET['user_id'])) {
    $user_id = $_SESSION['isAdmin']? $_GET['user_id']:$_SESSION['active_user_id'];

    $sql = "SELECT * FROM Users WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        header('Location: ../index.php');
        $conn = null;
        exit();
    }
    // Delete likes
    $sql = "DELETE FROM blogLikes WHERE blog_id IN (SELECT blog_id FROM Blogs WHERE user_id = :user_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);

    $sql = "DELETE FROM blogLikes WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);

    $sql = "UPDATE Blogs blog SET like_count = (SELECT COUNT(blog_id) FROM blogLikes likes WHERE likes.blog_id = blog.blog_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    // delete blog from categories
    $sql = "DELETE FROM blogCategory WHERE blog_id IN (SELECT blog_id FROM Blogs WHERE user_id = :user_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id'=>$user_id]);
    // delete comment from the database
    $sql = "DELETE FROM Comments WHERE user_id = :user_id OR blog_id IN (SELECT blog_id FROM Blogs WHERE user_id = :user_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    // delete the blog post from the database
    $sql = "DELETE FROM Blogs WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    // delete the blog post from the database
    $sql = "DELETE FROM Users WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);

    if ($_SESSION['isAdmin'] && $user_id != $_SESSION['active_user_id']) {
        header("Location: ../admin.php");
    } else {
        unset($_SESSION['active_user_id']);
        unset($_SESSION["username"]);
        unset($_SESSION["isAdmin"]);
        $_SESSION["loggedIn"] = false;
        session_destroy();
        header("Location: ../login.php");
    }
    $conn = null;
    exit();
} else {
    header('Location: ../index.php');
    $conn = null;
    exit();
}
