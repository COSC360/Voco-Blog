<?php

    require_once("db_connection.php");

    session_start();

    $pdo = connect();

    //Check if logged in and admin and correct params
    if ((!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == "false") && !isset($_POST['user_id'])) {
    $conn = null;
    header('Location: ../login.php');
    exit();
} else {

    $user_id = $_POST['user_id'];
    $sql = "UPDATE Users SET role_id= :role_id WHERE user_id= :user_id";
    $stmt = $pdo->prepare($sql);
    // role_id = 2 is admin
    $stmt->execute(["user_id" => $user_id,
                    "role_id" => 2]);

    if($stmt->rowCount() > 0) {
        //Success
        $conn = null;
        header("Location: ../admin.php");
    } else {
        $conn = null;
        die("Error: Could not perform admin update");
    }

    exit();

}

