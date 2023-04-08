<?php
require_once('db_connection.php');
$conn = connect();
session_start();
function get_blog_comments($conn, $blog_id){

    $sql = "SELECT comment.*, user.username
            FROM Comments comment
            INNER JOIN Users user ON comment.user_id = user.user_id
            WHERE comment.blog_id = :blog_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['blog_id' => $blog_id]);
    $comments = $stmt -> fetchAll();
    return $comments;
}

function get_user_comments($conn, $user_id){
    $sql = "SELECT comment.*, user.username
            FROM Comments comment
            INNER JOIN Users user ON comment.user_id = user.user_id
            WHERE comment.user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $comments = $stmt -> fetchAll();
    return $comments;
}

function get_comment($conn, $comment_id){
    $sql = "SELECT comment.*, user.username, user.user_id
            FROM Comments comment
            INNER JOIN Users user ON comment.user_id = user.user_id
            WHERE comment.comment_id = :comment_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['comment_id' => $comment_id]);
    $comment = $stmt -> fetch();
    return $comment;
}

function post_comment($conn, $user_id, $blog_id, $comment_contents, $parent_id){

    $sql = "INSERT INTO Comments (user_id, blog_id, comment_contents, comment_createdAt, parent_id)
                VALUES (:user_id, :blog_id, :comment_contents, NOW(), :parent)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'user_id' => $user_id,
        'blog_id' => $blog_id,
        'comment_contents' => $comment_contents,
        'parent' => $parent_id
    ]);
    return $conn->lastInsertId();
}

function get_replies($conn, $comment_id){
    $sql = "SELECT comment.*, user.username
            FROM Comments comment
            INNER JOIN Users user ON comment.user_id = user.user_id
            WHERE comment.parent_id = :comment_id";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute([
        'comment_id'=>$comment_id
    ]);
    $replies = $stmt -> fetchAll();
    return $replies;
}

function delete_comment($conn, $comment_id, $active_user_id){
    $sql = "SELECT user.user_id, role.role_name
            FROM Users user
            INNER JOIN Roles role ON user.role_id = Roles.role_id
            WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt -> execute([
        'user_id' => $active_user_id
    ]);
    $currentUser = $stmt -> fetch();
    // delete comment from the database
    $sql = "DELETE FROM Comments WHERE comment_id = :comment_id AND (user_id = :uid OR :role LIKE '%admin%')";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'comment_id' => $comment_id,
        'uid' => $currentUser['user_id'],
        'role' => strtolower($currentUser['role_name'])
    ]);
    $stmt->fetch();
}


function display_comment($conn,$comment){
    $response = "<details open class='comment' id='comment-".$comment['comment_id']."'>".
    "<summary><div class='comment-heading'><div class='comment-info'>".
    "<a href='#' class='comment-author'>".$comment['username']."</a>".
    "<p class='m-0'>".$comment['comment_createdAt']."</p>".
    "</div></div></summary>".
    "<div class='comment-body'>".
    "<p style='white-space: pre-wrap;'>".$comment['comment_contents']."</p>".
    "<button type='button' data-toggle='reply-form' data-target='comment-".$comment['comment_id']."-reply-form'>Reply</button>";
    if($comment['user_id'] == $_SESSION['active_user_id']){
        $response = $response."<button type='button' data-toggle='edit-form' data-target='comment-".$comment['comment_id']."-edit-form'>Edit</button>".
        "<button type='button' data-toggle='edit-form' data-target='comment-".$comment['comment_id']."-edit-form'>Edit</button>";
    }

    // todo: add edit/delete options
    $response = $response."<form method='POST' class='reply-form d-none' id='comment-".$comment['comment_id']."-reply-form'>".
    "<textarea placeholder='Reply...' rows='4'></textarea>".
    "<button type='submit'>Submit</button>".
    "<button type='button' data-toggle='reply-form' data-target='comment-".$comment['comment_id']."-reply-form'>Cancel</button>".
    "</form></div>";
    $replies = get_replies($conn, $comment['comment_id']);
    if(count($replies)>0){
        $response = $response."<div class='replies'>";
        foreach($replies as $reply){
            display_comment($conn, $reply);
        }
        $response = $response."</div>";
    }
    $response = $response."</details>";
    echo $response;
}

if (isset($_POST['action']) && $_POST['action'] == 'new_comment') {
    $comment_id = post_comment($conn,$_POST['user_id'],$_POST['blog_id'],$_POST['comment_contents'],isset($_POST['parent_id'])? $_POST['parent_id']:NULL);
    $comment = get_comment($conn, $comment_id);
    display_comment($conn, $comment);
}

if(isset($_POST['action']) && $_POST['action'] == 'get_blog_comments'){
    $blog_id = $_POST['blog_id'];
    $user_id = $_POST['user_id'];
    $comments = get_blog_comments($conn, $blog_id);
    foreach($comments as $comment){
        display_comment($conn, $comment);
    }

}
if(isset($_POST['action']) && $_POST['action'] == 'delete'){
    $blog_id = $_POST['blog_id'];
    $user_id = $_POST['user_id'];
    if($_SESSION['isAdmin'])

    $comments = get_blog_comments($conn, $blog_id);
    foreach($comments as $comment){
        display_comment($conn, $comment);
    }

}
