<?php
function get_comments($conn, $blog_id){

    $sql = "SELECT comment.*, user.username
            FROM Comments comment
            INNER JOIN Users user ON comment.user_id = user.user_id
            WHERE comment.blog_id = :blog_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['blog_id' => $blog_id]);
    $comments = $stmt -> fetchAll();
    return $comments;
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
    $rows = $stmt->fetch();
    if($rows <= 0){
        return "Error";
    }else{
        return "Success";
    }
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
    $currentUser = $stmt -> fetchAll();
    // delete comment from the database
    $sql = "DELETE FROM Comments WHERE comment_id = :comment_id AND (user_id = :uid OR :role LIKE '%admin%')";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'comment_id' => $comment_id,
        'uid' => $currentUser['user_id'],
        'role' => strtolower($currentUser['role_name'])
    ]);
    $rows = $stmt->fetch();
    if($rows <= 0){
        return "Error";
    }else{
        return "Success";
    }
}

