<?php
function get_user($conn, $user_id){
    // Get user info
    $sql = "SELECT * FROM Users WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch();
    return $user;
}