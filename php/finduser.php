<html>
    <?php
        include("db_connection.php");

        //Connect to db

        $pdo = connect();

        // Validate POST
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if(isset($_POST["username"])){
                $username = $_POST["username"];
            } else {
                die("Error: Invalid parameters");
            }
        } else {
            die("Error: Invalid Request Method");
        }

    $sql = "SELECT firstname,lastname,email FROM users WHERE username=?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1,$_POST["username"]);
    $stmt->execute();

    $result = $stmt -> fetch();

    $firstname = $result["firstname"];
    $lastname = $result["lastname"];
    $email = $result["email"];

    echo "<table><fieldset><legend>User: ".$username."</legend><label>First Name: ".$firstname."</label><br><label>Last Name: ".$lastname."</label><br><label>Email: ".$email."</label></fieldset></table>";

    $pdo = null;

    ?>
</html>