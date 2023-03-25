<?php
include("../php/db_connection.php");

$conn = connect();

$conn -> exec("DELETE FROM blogCategory");
$conn -> exec("DELETE FROM Comments");
$conn -> exec("DELETE FROM Blogs");
$conn -> exec("DELETE FROM Users");
$conn -> exec("DELETE FROM Roles");

$roles = array(
    array('role_name' => 'user'),
    array('role_name' => 'admin'),
);
foreach ($roles as $role) {
    $sql = "INSERT INTO Roles (role_name) VALUES ('" . $role['role_name'] . "')";
    $conn->query($sql);
}
$users = array(
    array('username' => 'loggylog', 'role_id' => 1, 'first_name' => 'log', 'last_name' => 'par', 'email' => 'johndoe@example.com', 'password' => 'password123'),
    array('username' => 'eddyed', 'role_id' => 2, 'first_name' => 'ed', 'last_name' => 'el', 'email' => 'janedoe@example.com', 'password' => 'password123'),
    array('username' => 'bobsmith', 'role_id' => 1, 'first_name' => 'Bob', 'last_name' => 'Smith', 'email' => 'bobsmith@example.com', 'password' => 'password123')
);
foreach ($users as $user) {
    $sql = "INSERT INTO Users (username, role_id, first_name, last_name, email, password) VALUES ('" . $user['username'] . "', " . $user['role_id'] . ", '" . $user['first_name'] . "', '" . $user['last_name'] . "', '" . $user['email'] . "', '" . $user['password'] . "')";
    $conn->query($sql);
}
$blogs = array(
    array('user_id' => 1, 'blog_title' => 'My First Blog', 'blog_createdAt' => '2022-01-01 10:00:00', 'blog_modifiedAt' => '2022-01-01 10:30:00', 'blog_img' => 'blog1.jpg', 'blog_contents' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'like_count' => 10),
    array('user_id' => 2, 'blog_title' => 'My Second Blog', 'blog_createdAt' => '2022-02-01 10:00:00', 'blog_modifiedAt' => '2022-02-01 10:30:00', 'blog_img' => 'blog2.jpg', 'blog_contents' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', 'like_count' => 20),
    array('user_id' => 3, 'blog_title' => 'My Third Blog', 'blog_createdAt' => '2022-03-01 10:00:00', 'blog_modifiedAt' => '2022-03-01 10:30:00', 'blog_img' =>'blog3.jpg', 'blog_contents' => 'Donec ac quam vitae leo consequat maximus at vel ipsum.', 'like_count' => 5)
);
foreach ($blogs as $blog) {
    $sql = "INSERT INTO Blogs (user_id, blog_title, blog_createdAt, blog_modifiedAt, blog_img, blog_contents, like_count) VALUES (" . $blog['user_id'] . ", '" . $blog['blog_title'] . "', '" . $blog['blog_createdAt'] . "', '" . $blog['blog_modifiedAt'] . "', '" . $blog['blog_img'] . "', '" . $blog['blog_contents'] . "', " . $blog['like_count'] . ")";
    $conn->query($sql);
}
$comments = array(
    array('user_id' => 1, 'blog_id' => 1, 'comment_contents' => 'Great post!', 'comment_createdAt' => '2022-01-01 11:00:00', 'like_count' => 5),
    array('user_id' => 2, 'blog_id' => 1, 'comment_contents' => 'Thanks for sharing.', 'comment_createdAt' => '2022-01-01 12:00:00', 'like_count' => 3),
    array('user_id' => 1, 'blog_id' => 2, 'comment_contents' => 'I completely agree.', 'comment_createdAt' => '2022-02-01 11:00:00', 'like_count' => 7),
    array('user_id' => 3, 'blog_id' => 2, 'comment_contents' => 'Interesting perspective.', 'comment_createdAt' => '2022-02-01 12:00:00', 'like_count' => 1),
    array('user_id' => 2, 'blog_id' => 3, 'comment_contents' => 'Great job!', 'comment_createdAt' => '2022-03-01 11:00:00', 'like_count' => 2)
);
foreach ($comments as $comment) {
    $sql = "INSERT INTO Comments (user_id, blog_id, comment_contents, comment_createdAt, like_count) VALUES (" . $comment['user_id'] . ", " . $comment['blog_id'] . ", '" . $comment['comment_contents'] . "', '" . $comment['comment_createdAt'] . "', " . $comment['like_count'] . ")";
    $conn->query($sql);
}
$categories = array(
    array('category_name' => 'Climbing'),
    array('category_name' => 'Hiking'),
    array('category_name' => 'Skiing'),
    array('category_name' => 'Snowboarding')
);
foreach ($categories as $category) {
    $sql = "INSERT INTO Category (category_name) VALUES ('" . $category['category_name'] . "')";
    $conn->query($sql);
}
$blogCategories = array(
    array('category_id' => 1, 'blog_id' => 1),
    array('category_id' => 2, 'blog_id' => 1),
    array('category_id' => 2, 'blog_id' => 2),
    array('category_id' => 3, 'blog_id' => 2),
    array('category_id' => 4, 'blog_id' => 3)
);
foreach ($blogCategories as $blogCategory) {
    $sql = "INSERT INTO blogCategory (category_id, blog_id) VALUES (" . $blogCategory['category_id'] . ", " . $blogCategory['blog_id'] . ")";
    $conn->query($sql);
}

$conn = null;

echo "Seeder Executed Successfully";