<?php
include("db_connection.php");

$conn = connect();
if(!$_SERVER['REQUEST_METHOD']=="POST"){
    $conn = null;

}else{
    session_start();
    if(!(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) || $_POST['user_id']!=$_SESSION['active_user_id']){
        header("Location: ../index.php");
        exit();
    }
    session_abort();
    $params = [
        'user_id'=> $_POST['user_id'],
        'first_name'=>$_POST['firstname'],
        'last_name'=>$_POST['lastname'],
        'username'=>$_POST['username'],
        'email'=> $_POST['email'],
    ];

    $query = "UPDATE Users user SET first_name = :first_name, last_name = :last_name, username = :username, email = :email";
    if(isset($_POST['password']) && $_POST['password'] != ""){
        $query = $query. ",password = :password";
        $params['password'] = md5($_POST['password']);
    }

    if(!empty($_FILES["profile_picture"]["tmp_name"])){
        $cover_img = $_FILES["profile_picture"]["tmp_name"];
        //Retrieve image path information
        $img_path = $_FILES["profile_picture"]['name'];
        $imageFileType = strtolower(pathinfo($img_path,PATHINFO_EXTENSION));
        $image_blob = file_get_contents($cover_img);
        if($_FILES["profile_picture"]["size"] < 8000000 && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "gif") ){
            $query = $query .", profile_picture = :profile_picture";
            $params['profile_picture'] = $image_blob;
        }
    }

    $query = $query." WHERE user.user_id = :user_id";
    $sql = $query;
    $stmt = $conn -> prepare($sql);
    $stmt ->execute($params);
    header("Location: ../profile.php?user_id=".$params['user_id']);
}

