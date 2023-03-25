<!DOCTYPE html>
<html>
    <?php
    include("db_connection.php");
    include("validateRequests.php");
    //Connect to db
    $pdo = connect();

    //Validate POST and Initialize parameters
    if(validatePostRequest($_POST,$_SERVER)) {
        $user_password = $_POST["password"];
        $userinfo = $_POST["loginuser"];
    } else {
        die();
    }

    //Hash user password for a match in db
    $user_password = md5($user_password);

    $sql = "SELECT username,password, user_id FROM Users WHERE username=? AND password=?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1,$userinfo);
    $stmt->bindValue(2,$user_password);
    $stmt->execute();

    $result = $stmt -> fetch();

    if($result) {
        echo "<p>User has a valid account</p>";

        // Initialize session
        session_start();
        $_SESSION["active_user_id"] = $result['user_id'];
        $_SESSION["username"] = $result["username"];
        $_SESSION["loggedIn"] = true;

        //Redirect
        header("Location: ../index.php");

    } else {
        echo "<p>User account is invalid<p>";
    }

    $pdo = null;

    ?>
</html>

