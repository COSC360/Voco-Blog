<?php
//$conn = connect();
//
//$search_query = $_GET['search'];
//// Get Blog Posts
//$sql = "SELECT *
//        FROM Blogs
//        INNER JOIN Users ON Blogs.user_id = Users.user_id
//        WHERE Blogs.blog_title LIKE :search OR Blogs.blog_contents LIKE :search
//        ORDER BY Blogs.blog_createdAt DESC";
//$stmt = $conn->prepare($sql);
//$stmt->execute(['search' => '%' . $search_query . '%']);
//$blogs = $stmt->fetchAll();

function get_posts($conn, $search_phrase, $order, $category){
    $blogAttributes = "Blogs.blog_id,Blogs.user_id,blog_title,blog_createdAt,blog_img,blog_contents,like_count,username,first_name,last_name,category_name";
    $sql = "SELECT $blogAttributes 
            FROM Blogs INNER JOIN Users on Blogs.user_id = Users.user_id 
            INNER JOIN blogCategory on blogCategory.blog_id = Blogs.blog_id 
            INNER JOIN Category ON Category.category_id = blogCategory.category_id";
    $condition = "WHERE";
    if($search_phrase != ""){
       $condition = $condition . "Blogs.blog_title LIKE :search OR Blogs.blog_contents LIKE :search";
    }
    if($category != ""){
        $condition = $condition . "AND category_name LIKE :category";
    }
    if($order == "ASC" || $order == "DESC"){
        $condition = $condition . "ORDER BY Blogs.blog_createdAt :order";
    }else{
        $condition = $condition . "ORDER BY Blogs.blog_createdAt DESC";
    }
    $sql = $sql . $condition .';';

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'search' => "%$search_phrase%",
        'category' => "%$category%",
        'order'=> $order
    ]);
    $blogs = $stmt->fetchAll();
    // Do something?
    return $blogs;
}