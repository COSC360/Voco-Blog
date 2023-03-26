<?php

    session_start();

    echo "<p>".$_SESSION["loggedIn"]."</p>";
    echo "<p>".$_SESSION["username"]."</p>";

    unset($_SESSION['active_user_id']);
    unset($_SESSION["username"]);
    unset($_SESSION["isAdmin"]);
    $_SESSION["loggedIn"] = false;


    header("Location: ../index.php");
    exit;
?>
