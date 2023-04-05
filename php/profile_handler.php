<?php
include("db_connection.php");
include("validateRequests.php");
include("comment_handler.php");
include("like_handler.php");

$pdo = connect();

if(validateGetRequest($_GET,$_SERVER)){
    $tablename = $_GET["tablename"];
} else {
    die();
};


if($tablename == "likedposts") {
    $sql = "SELECT * FROM Users WHERE role_id=2";
    // Set up for unlike actions
    $id = "user_id";
    $action = "like_handler.php";
} elseif ($tablename == "usercomments") {
    $sql = "SELECT * FROM Users";
    // Set up for delete action
    $id = "user_id";
    $action = "comment_handler.php";
} elseif ($tablename == "blog") {
    $sql = "SELECT * FROM Blogs";
    // Set up for delete actions
    $id = "blog_id";
    $action = "delete_blog.php";

} else {
    echo("Error: Invalid request parameter");
    die();

}