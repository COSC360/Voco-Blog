<?php
require_once('db_connection.php');
$conn = connect();
session_start();

function get_blog_comments($conn, $blog_id)
{

    $sql = "SELECT comment.*, user.username
            FROM Comments comment
            INNER JOIN Users user ON comment.user_id = user.user_id
            WHERE comment.blog_id = :blog_id AND comment.parent_id IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['blog_id' => $blog_id]);
    $comments = $stmt->fetchAll();
    return $comments;
}

function get_user_comments($conn, $user_id)
{
    $sql = "SELECT comment.comment_id, comment.parent_id, comment.user_id, comment.blog_id,comment.comment_contents, user.username
            FROM Comments comment
            INNER JOIN Users user ON comment.user_id = user.user_id
            WHERE comment.user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $comments = $stmt->fetchAll();
    return $comments;
}

function get_comment($conn, $comment_id)
{
    $sql = "SELECT comment.*, user.username, user.user_id
            FROM Comments comment
            INNER JOIN Users user ON comment.user_id = user.user_id
            WHERE comment.comment_id = :comment_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['comment_id' => $comment_id]);
    $comment = $stmt->fetch();
    return $comment;
}

function post_comment($conn, $user_id, $blog_id, $comment_contents, $parent_id)
{

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

function get_replies($conn, $comment_id)
{
    $sql = "SELECT comment.*, user.username
            FROM Comments comment
            INNER JOIN Users user ON comment.user_id = user.user_id
            WHERE comment.parent_id = :comment_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'comment_id' => $comment_id
    ]);
    $replies = $stmt->fetchAll();
    return $replies;
}

function delete_comment($conn, $comment_id)
{
    // delete comment from the database
    $sql = "DELETE FROM Comments WHERE parent_id = :comment_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'comment_id' => $comment_id,
    ]);
    $sql = "DELETE FROM Comments WHERE comment_id = :comment_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'comment_id' => $comment_id,
    ]);
    $stmt->fetch();
}


function display_comment($conn, $comment, $displayed_comments = array())
{
    $comment_id = $comment['comment_id'];
    $response = '';
    if (!in_array($comment_id, $displayed_comments)) {
        $displayed_comments[] = $comment_id;
        $response = $response . "<details open class='comment' id='comment-" . $comment['comment_id'] . "'>" .
            "<summary><div class='comment-heading'><div class='comment-info'>" .
            "<a href='#' class='comment-author'>" . $comment['username'] . "</a>" .
            "<p class='m-0'>" . $comment['comment_createdAt'] . "</p>" .
            "</div></div></summary>" .
            "<div class='comment-body'>" .
            "<p style='white-space: pre-wrap;'>" . $comment['comment_contents'] . "</p>" .
            "<button type='button' data-toggle='reply-form' data-target='comment-" . $comment['comment_id'] . "-reply-form'>Reply</button>";
        if ($comment['user_id'] == $_SESSION['active_user_id']) {
            $response = $response .
                "<form method='POST' action='php/comment_handler.php'>" .
                "<input type='hidden' name='user_id' value='" . $_SESSION['active_user_id'] . "'>" .
                "<input type='hidden' name='comment_id' value='" . $comment['comment_id'] . "'>" .
                "<input type='hidden' name='post_id' value='" . $comment['blog_id'] . "'>" .
                "<input type='hidden' name='action' value='delete'>" .
                "<button type='submit'>Delete</button></form>";
        }
        $disabled = "disabled";
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
            $disabled = "";
        }
        $response = $response .
            "<form method='POST' action='php/comment_handler.php' class='reply-form d-none' id='comment-" . $comment['comment_id'] . "-reply-form'>" .
            "<input type='hidden' name='user_id' value='" . $_SESSION['active_user_id'] . "'>" .
            "<input type='hidden' name='blog_id' value='" . $comment['blog_id'] . "'>" .
            "<input type='hidden' name='parent_id' value='" . $comment['comment_id'] . "'>" .
            "<input type='hidden' name='action' value='reply_comment'>" .
            "<input required type='text' name='comment_contents' placeholder='Write a comment...' maxlength='256' " . $disabled . ">" .
            "<button type='submit'>Submit</button>" .
            "<button type='button' data-toggle='reply-form' data-target='comment-" . $comment['comment_id'] . "-reply-form'>Cancel</button>" .
            "</form></div>";
        $replies = get_replies($conn, $comment['comment_id']);
        if (count($replies) > 0) {
            $response = $response . "<div class='replies'>";
            foreach ($replies as $reply) {
                $response = $response. display_comment($conn, $reply, $displayed_comments);
            }
            $response = $response . "</div>";
        }
        $response = $response . "</details>";
    }else{
        return $response;
    }
    return $response;
}

if (isset($_POST['action']) && $_POST['action'] == 'new_comment') {
    $comment_id = post_comment($conn, $_POST['user_id'], $_POST['blog_id'], $_POST['comment_contents'], isset($_POST['parent_id']) ? $_POST['parent_id'] : NULL);
    $comment = get_comment($conn, $comment_id);
    display_comment($conn, $comment);
}
if (isset($_POST['action']) && $_POST['action'] == 'reply_comment') {
    $comment_id = post_comment($conn, $_POST['user_id'], $_POST['blog_id'], $_POST['comment_contents'], isset($_POST['parent_id']) ? $_POST['parent_id'] : NULL);
    header("Location: ../post.php?blog_id=" . $_POST['blog_id']);
}
if (isset($_POST['action']) && $_POST['action'] == 'get_blog_comments') {
    $blog_id = $_POST['blog_id'];
    $user_id = $_POST['user_id'];
    $comments = get_blog_comments($conn, $blog_id);
    foreach ($comments as $comment) {
        echo display_comment($conn, $comment);
    }

}
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    if ($_SESSION['isAdmin'] || $_SESSION['active_user_id'] == $user_id) {
        delete_comment($conn, $comment_id);
        header("Location: ../post.php?blog_id=" . $_POST['post_id']);
    } else {
        header("Location: ../post.php?blog_id=" . $_POST['post_id']);
    }
}
