<?php
include("db_connection.php");
$conn = connect();

function get_like_count($conn,$blog_id) {
    $sql = "SELECT like_count FROM Blogs WHERE blog_id= :blog_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['blog_id' => $blog_id]);
    $result = $stmt -> fetch();

    return $result['like_count'];
}
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
    $sql = "INSERT INTO blogLikes (user_id,blog_id) VALUES(:user_id, :post_id)";
    $stmt = $conn->prepare($sql);
    $stmt -> execute([
       'user_id' => $user_id,
       'post_id' => $post_id
    ]);

    update_post($conn,$post_id);

}
function remove_like($conn,$user_id,$post_id){
    $sql = "DELETE FROM blogLikes WHERE user_id = :user_id AND blog_id = :blog_id";
    $stmt = $conn->prepare($sql);
    $stmt -> execute([
        'user_id' => $user_id,
        'blog_id' => $post_id
    ]);
    update_post($conn,$post_id);
}
function update_post($conn,$post_id){
    $sql = "UPDATE Blogs blog SET like_count = (SELECT COUNT(blog_id) FROM blogLikes likes WHERE likes.blog_id = blog.blog_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

}




if (isset($_GET['action']) && $_GET['action'] == 'get') {
    get_liked_posts();
}

if (isset($_POST['action']) && $_POST['action'] == 'like') {

    add_like($conn,$_POST['user_id'],$_POST['blog_id']);

    echo get_like_count($conn,$_POST['blog_id']);

}

if (isset($_POST['action']) && $_POST['action'] == 'unlike') {


    remove_like($conn, $_POST['user_id'],$_POST['blog_id']);


    echo get_like_count($conn,$_POST['blog_id']);

}