<!DOCTYPE html>
<html lang="en">
    <?php
        include("db_connection.php");
        include("validateRequests.php");

        // Check that request method is valid and set parameters
        $pdo = connect();

        if(validatePostRequest($_POST,$_SERVER)) {
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $user_password = $_POST["password"];



            // Extract profile image file from user page
            if(empty($_FILES)) {
                //Retrieve profile img contents
                $cover_img = $_FILES["profile_picture"]["tmp_name"];
                $img_path = $_FILES["profile_picture"]['name'];
                $imageFileType = strtolower(pathinfo($img_path,PATHINFO_EXTENSION));
                //Get image blob
                $image_blob = file_get_contents($cover_img);
            } else {
                // If image is not upload then set profile image to default
                $image_blob = file_get_contents("../img/empty_profile.png");
                $imageFileType = "png";
            }

        } else {
            die();
        }

        // Validate img contents
        if($_FILES["profile_picture"]["size"] < 8000000 && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "gif") ) {
            $uploadOk = 1;
            echo "VALID IMAGE UPLOAD";
        } else {
            die("Error: Image is too large or image is invalid type");
        }

        // Check to see if user already exists

        $sql = "SELECT email,username FROM users WHERE email=? OR username=?";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1,$email);
        $stmt->bindValue(2,$username);
        $stmt->execute();

        $results = $stmt -> fetchAll();


        if(count($results) > 0) {
            echo "<p> username and/or email already exists<p>";
            // Close connection
            $pdo = null;

        } else {

        //Insert new user into the database
        $sql = "INSERT INTO Users (username,role_id,profile_picture,profile_picture_type,first_name, last_name, email, password) VALUES (?,?,?,?,?,?,?,?)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1,$username);

        //Set default role to 'user'
        $role = "1";
        $stmt->bindValue(2,$role);
        $stmt->bindValue(3,$image_blob);
        $stmt->bindValue(4,$imageFileType);
        $stmt->bindValue(5,$firstname);
        $stmt->bindValue(6,$lastname);
        $stmt->bindValue(7,$email);

        //Hash user password
        $user_password = md5($user_password);
        $stmt->bindValue(8,$user_password);

        if($stmt->execute()) {
            echo "User Successfully Added";
            header("Location: ../login.php");
            exit();
        } else {
            echo "Failed to user";
        }
        // Close connection
        $pdo = null;

        }
    ?>
</html>
