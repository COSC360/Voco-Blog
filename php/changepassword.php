<html>
    <?php
        include("db_connection.php");
        include("validateRequests.php");

        // Connect to db
        $pdo = connect();

        // Validate POST request and initialize values
        if(validatePostRequest($_POST, $SERVER)) {
            $username = $_POST["username"];
            $oldpassword = $_POST["oldpassword"];
            $newpassword = $_POST["newpassword"];
        } else {
            die();
        }


            //Determine if username and old password are valid

            //Hash user passwords
            $oldpassword=md5($oldpassword);
            $newpassword=md5($newpassword);


            $sql = "SELECT username,password FROM users WHERE username=? AND password=?";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1,$username);
            $stmt->bindValue(2,$oldpassword);
            $stmt->execute();

            $result = $stmt -> fetchAll();

            if(count($result) > 0) {
                echo "<p>User has a valid account</p>";
                // Update user password
                $sql = "UPDATE users SET password=? WHERE username=? AND password=?";
                $stmt = $pdo ->prepare($sql);
                $stmt->bindValue(1,$newpassword);
                $stmt->bindValue(2,$username);
                $stmt->bindValue(3,$oldpassword);

                if($stmt->execute()){
                    echo "User password has been successfully updated";
                } else {
                    $pdo =null;
                    die("User password has not been successfully updated");
                }
            } else {
                $pdo =null;
                die("<p> Error: User account is invalid<p>");
            }

            $pdo = null;
            ?>
</html>