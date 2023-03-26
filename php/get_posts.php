<?php
$conn = connect();

$search_query = $_GET['search'];
// Get Blog Posts
$sql = "SELECT *
        FROM Blogs
        INNER JOIN Users ON Blogs.user_id = Users.user_id
        WHERE Blogs.blog_title LIKE :search OR Blogs.blog_contents LIKE :search
        ORDER BY Blogs.blog_createdAt DESC";
$stmt = $conn->prepare($sql);
$stmt->execute(['search' => '%' . $search_query . '%']);
$blogs = $stmt->fetchAll();