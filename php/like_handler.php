<?php


function get_liked_posts($conn,$user_id){
    // TODO: Decide if we also want blog contents
    $sql = "SELECT blog.blog_id,blog.blog_title, user.username
            FROM blogLikes likes
            INNER JOIN Blogs blog ON likes.blog_id = blog.blog_id
            INNER JOIN Users user ON blog.user_id = user.user_id
            WHERE likes.user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $liked_posts = $stmt -> fetchAll();
    return $liked_posts;

}

function add_like($conn, $user_id, $post_id){
    // Insert like into join table
    $sql = "INSERT INTO blogLikes";
    // Update blog like value with new count
    $sql = "UPDATE Blogs blog SET like_count = (SELECT COUNT(blog_id) FROM blogLikes likes WHERE likes.blog_id = :post_id)";

}
function remove_like(){


}