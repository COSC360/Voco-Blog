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
        } else {
            die();
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
        $sql = "INSERT INTO Users (username,role_name,first_name, last_name, email, password) VALUES (?,?,?,?,?,?)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1,$username);

        //Set default role to 'user'
        $role = "user";
        $stmt->bindValue(2,$role);

        $stmt->bindValue(3,$firstname);
        $stmt->bindValue(4,$lastname);
        $stmt->bindValue(5,$email);

        //Hash user password
        $user_password = md5($user_password);
        $stmt->bindValue(6,$user_password);

        if($stmt->execute()) {
            echo "User Successfully Added";
            header("Location: ../login.html");
            exit();
        } else {
            echo "Failed to user";
        }
        // Close connection
        $pdo = null;

        }
    ?>
</html>
