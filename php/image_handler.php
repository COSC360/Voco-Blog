<?php
include("db_connection.php");


// BLOBS only!
function upload_image($conn, $image, $dest){
    $pdo = connect();
    if($dest == "header"){
        $sql = "SELECT profile_picture FROM Users WHERE user_id=?";
        $stmt->prepare($sql);
        $stmt->execute([$user_id]);
        $result -> $stmt -> fetch();
        if($result) {
            $img_blob = $result["profile_picture"];
            echo "<img src=\"data:image/".$contentType.";base64,".base64_encode($imageblob)."\"/>";
        } else {
            // TODO: add placeholder icon
            echo "<img src=\"img/empty_profile.png\" alt=\"empty-user\"/>";
        }

    } else if($dest == "blogpost"){
        $sql = "SELECT profile_picture FROM Blogs WHERE user_id=?";


    } else if ($dest == "profile") {

    }
    else{
        return 'Error!';
    }

}